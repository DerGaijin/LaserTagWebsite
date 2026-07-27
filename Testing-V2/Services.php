<?php

ini_set('display_errors', '0');
ob_start();

function testingV2JsonResponse(array $data, int $statusCode = 200): void
{
	while (ob_get_level() > 0) {
		ob_end_clean();
	}

	http_response_code($statusCode);
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	exit;
}

register_shutdown_function(function (): void {
	$error = error_get_last();
	$fatalTypes = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR];

	if ($error !== null && in_array($error['type'], $fatalTypes, true)) {
		testingV2JsonResponse(['error' => 'PHP error: ' . $error['message']], 500);
	}
});

function testingV2LoadDotEnv(string $path): void
{
	if (!is_readable($path)) {
		return;
	}

	foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
		$line = trim($line);

		if ($line === '' || strpos($line, '#') === 0 || strpos($line, '=') === false) {
			continue;
		}

		[$name, $value] = explode('=', $line, 2);
		$name = trim($name);
		$value = trim($value, " \t\n\r\0\x0B\"'");

		if ($name !== '' && getenv($name) === false) {
			putenv($name . '=' . $value);
		}
	}
}

function testingV2EnvValue(string $name): string
{
	$value = getenv($name);

	return is_string($value) ? trim($value) : '';
}

function testingV2FirstEnvValue(array $names): string
{
	foreach ($names as $name) {
		$value = testingV2EnvValue($name);

		if ($value !== '') {
			return $value;
		}
	}

	return '';
}

function testingV2CurlJson(string $url, string $method = 'GET', array $headers = [], ?array $payload = null): array
{
	$curl = curl_init($url);

	if ($curl === false) {
		throw new RuntimeException('Could not initialize cURL.');
	}

	$requestHeaders = array_merge(['Accept: application/json'], $headers);
	$options = [
		CURLOPT_HTTPHEADER => $requestHeaders,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 20,
	];

	if ($method === 'POST') {
		$body = json_encode($payload ?? []);

		if ($body === false) {
			throw new RuntimeException('Could not encode SimplyBook request.');
		}

		$options[CURLOPT_POST] = true;
		$options[CURLOPT_POSTFIELDS] = $body;
		$options[CURLOPT_HTTPHEADER] = array_merge($requestHeaders, [
			'Content-Type: application/json',
			'Content-Length: ' . strlen($body),
		]);
	}

	$caCertPath = testingV2EnvValue('SIMPLYBOOK_CA_CERT_PATH');
	if ($caCertPath !== '') {
		$options[CURLOPT_CAINFO] = $caCertPath;
	} else {
		$options[CURLOPT_SSL_VERIFYPEER] = false;
		$options[CURLOPT_SSL_VERIFYHOST] = 0;
	}

	curl_setopt_array($curl, $options);

	$response = curl_exec($curl);
	$httpStatus = (int) curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
	$curlError = curl_error($curl);
	curl_close($curl);

	if ($response === false) {
		throw new RuntimeException('SimplyBook request failed: ' . $curlError);
	}

	$decoded = json_decode((string) $response, true);
	if (!is_array($decoded)) {
		throw new RuntimeException('SimplyBook returned invalid JSON.');
	}

	return [
		'body' => $decoded,
		'httpStatus' => $httpStatus,
	];
}

function testingV2ExtractToken(array $authResponse): string
{
	$body = $authResponse['body'];
	$token = (string) ($body['token'] ?? $body['access_token'] ?? '');

	if ($token === '') {
		throw new RuntimeException('SimplyBook public auth response did not include a token.');
	}

	return $token;
}

function testingV2NormalizeServices(array $response): array
{
	$rawServices = $response['data'] ?? $response['services'] ?? $response;
	$services = [];

	foreach ($rawServices as $key => $service) {
		if (!is_array($service)) {
			continue;
		}

		$id = (string) ($service['id'] ?? $service['event_id'] ?? (is_int($key) ? '' : $key));
		$name = (string) ($service['name'] ?? $service['title'] ?? '');

		if ($id === '' && $name === '') {
			continue;
		}

		$duration = $service['duration'] ?? $service['length'] ?? $service['duration_minutes'] ?? '';
		$visible = $service['is_visible'] ?? $service['visible'] ?? $service['hide'] ?? null;

		if ($visible === null) {
			$visibleText = '-';
		} elseif ((string) $visible === '0' || $visible === false) {
			$visibleText = isset($service['hide']) ? 'Yes' : 'No';
		} else {
			$visibleText = isset($service['hide']) ? 'No' : 'Yes';
		}

		$services[] = [
			'id' => $id,
			'name' => $name,
			'duration' => (string) $duration,
			'visible' => $visibleText,
		];
	}

	return $services;
}

function testingV2RunServicesTest(): array
{
	$startedAt = microtime(true);
	$result = [
		'hasRun' => true,
		'ok' => false,
		'status' => 'Failed',
		'testedAt' => date('Y-m-d H:i:s'),
		'duration' => '-',
		'error' => '',
		'services' => [],
		'raw' => null,
		'httpStatus' => null,
	];

	try {
		testingV2LoadDotEnv(dirname(__DIR__) . '/.env');

		$companyLogin = testingV2FirstEnvValue(['SIMPLYBOOK_COMPANY_LOGIN', 'SIMPLYBOOK_COMPANY']);
		$widgetApiKey = testingV2EnvValue('SIMPLYBOOK_WIDGET_API_KEY');

		if ($companyLogin === '' || $widgetApiKey === '') {
			throw new RuntimeException('Missing SIMPLYBOOK_COMPANY_LOGIN/SIMPLYBOOK_COMPANY or SIMPLYBOOK_WIDGET_API_KEY.');
		}

		if (!function_exists('curl_init')) {
			throw new RuntimeException('PHP cURL extension is not enabled.');
		}

		$authResponse = testingV2CurlJson('https://user-api-v2.simplybook.me/public/auth/token', 'POST', [], [
			'company' => $companyLogin,
			'key' => $widgetApiKey,
		]);
		$token = testingV2ExtractToken($authResponse);

		$servicesResponse = testingV2CurlJson('https://user-api-v2.simplybook.me/public/services', 'GET', [
			'X-Company-Login: ' . $companyLogin,
			'X-Token: ' . $token,
		]);

		if ($servicesResponse['httpStatus'] >= 400) {
			$message = $servicesResponse['body']['message'] ?? $servicesResponse['body']['error'] ?? ('SimplyBook HTTP error: ' . $servicesResponse['httpStatus']);
			throw new RuntimeException(is_array($message) ? json_encode($message) : (string) $message);
		}

		$result['ok'] = true;
		$result['status'] = 'Passed';
		$result['services'] = testingV2NormalizeServices($servicesResponse['body']);
		$result['raw'] = $servicesResponse['body'];
		$result['httpStatus'] = $servicesResponse['httpStatus'];
	} catch (Throwable $exception) {
		$result['error'] = $exception->getMessage();
	} finally {
		$result['duration'] = number_format((microtime(true) - $startedAt) * 1000, 0) . ' ms';
	}

	return $result;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
	testingV2JsonResponse(['error' => 'Invalid request method.'], 405);
}

testingV2JsonResponse(testingV2RunServicesTest());
