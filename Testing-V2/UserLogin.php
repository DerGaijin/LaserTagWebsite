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

function testingV2MaskToken(string $token): string
{
	if ($token === '') {
		return '';
	}

	return strlen($token) <= 12 ? str_repeat('*', strlen($token)) : substr($token, 0, 6) . '...' . substr($token, -4);
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

function testingV2InputString(array $input, string $name): string
{
	$value = $input[$name] ?? '';

	return is_scalar($value) ? trim((string) $value) : '';
}

function testingV2MaskSensitiveResponse(array $value): array
{
	foreach ($value as $key => $item) {
		$keyText = is_string($key) ? strtolower($key) : '';

		if (is_array($item)) {
			$value[$key] = testingV2MaskSensitiveResponse($item);
		} elseif (is_scalar($item) && ($keyText === 'token' || $keyText === 'access_token' || $keyText === 'refresh_token')) {
			$value[$key] = testingV2MaskToken((string) $item);
		}
	}

	return $value;
}

function testingV2RunUserLoginTest(): array
{
	$startedAt = microtime(true);
	$result = [
		'hasRun' => true,
		'ok' => false,
		'status' => 'Failed',
		'testedAt' => date('Y-m-d H:i:s'),
		'duration' => '-',
		'error' => '',
		'detail' => '',
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

		$input = json_decode((string) file_get_contents('php://input'), true);
		if (!is_array($input)) {
			$input = $_POST;
		}

		$login = testingV2InputString($input, 'login');
		$password = testingV2InputString($input, 'password');

		if ($login === '' || $password === '') {
			throw new RuntimeException('Email/login and password are required.');
		}

		$authResponse = testingV2CurlJson('https://user-api-v2.simplybook.me/public/auth/token', 'POST', [], [
			'company' => $companyLogin,
			'key' => $widgetApiKey,
		]);
		$token = testingV2ExtractToken($authResponse);

		$loginResponse = testingV2CurlJson('https://user-api-v2.simplybook.me/public/clients/login', 'POST', [
			'X-Company-Login: ' . $companyLogin,
			'X-Token: ' . $token,
		], [
			'login' => $login,
			'password' => $password,
		]);

		if ($loginResponse['httpStatus'] >= 400) {
			$message = $loginResponse['body']['message'] ?? $loginResponse['body']['error'] ?? ('SimplyBook HTTP error: ' . $loginResponse['httpStatus']);
			throw new RuntimeException(is_array($message) ? json_encode($message) : (string) $message);
		}

		$body = $loginResponse['body'];
		$client = is_array($body['client'] ?? null) ? $body['client'] : (is_array($body['data'] ?? null) ? $body['data'] : $body);
		$clientId = is_array($client) ? (string) ($client['id'] ?? $client['client_id'] ?? '') : '';
		$clientName = is_array($client) ? (string) ($client['name'] ?? $client['full_name'] ?? '') : '';
		$clientToken = is_array($body) ? (string) ($body['token'] ?? $body['access_token'] ?? '') : '';

		$result['ok'] = true;
		$result['status'] = 'Passed';
		$result['detail'] = 'HTTP ' . $loginResponse['httpStatus'] . '. Login accepted'
			. ($clientId !== '' ? '. Client ID: ' . $clientId : '')
			. ($clientName !== '' ? '. Name: ' . $clientName : '')
			. ($clientToken !== '' ? '. Client token: ' . testingV2MaskToken($clientToken) : '')
			. '.';
		$result['raw'] = testingV2MaskSensitiveResponse($body);
		$result['httpStatus'] = $loginResponse['httpStatus'];
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

testingV2JsonResponse(testingV2RunUserLoginTest());
