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

function testingV2InputString(array $input, string $name): string
{
	$value = $input[$name] ?? '';

	return is_scalar($value) ? trim((string) $value) : '';
}

function testingV2NormalizeDate(string $date): string
{
	if ($date === '') {
		return date('Y-m-d');
	}

	$germanDate = DateTime::createFromFormat('!d.m.Y', $date);
	if ($germanDate instanceof DateTime) {
		return $germanDate->format('Y-m-d');
	}

	$isoDate = DateTime::createFromFormat('!Y-m-d', $date);
	if ($isoDate instanceof DateTime) {
		return $isoDate->format('Y-m-d');
	}

	throw new RuntimeException('Date must use DD.MM.YYYY or YYYY-MM-DD.');
}

function testingV2NormalizeAvailabilitySlots(array $response): array
{
	$rawSlots = $response['data'] ?? $response['slots'] ?? $response['times'] ?? $response['available_times'] ?? $response;
	$slots = [];
	$collectSlots = function ($value, $key = null) use (&$slots, &$collectSlots): void {
		if (is_scalar($value)) {
			$slots[] = (string) $value;
			return;
		}

		if (!is_array($value)) {
			return;
		}

		$time = (string) ($value['time'] ?? $value['start_time'] ?? $value['start'] ?? $value['from'] ?? '');
		if ($time !== '') {
			$slots[] = $time;
			return;
		}

		if (is_string($key) && preg_match('/^\d{1,2}:\d{2}/', $key) === 1) {
			$slots[] = $key;
		}

		foreach ($value as $childKey => $childValue) {
			$collectSlots($childValue, $childKey);
		}
	};

	foreach ($rawSlots as $key => $slot) {
		$collectSlots($slot, $key);
	}

	return array_values(array_unique($slots));
}

function testingV2RunAvailabilityTest(): array
{
	$startedAt = microtime(true);
	$result = [
		'hasRun' => true,
		'ok' => false,
		'status' => 'Failed',
		'testedAt' => date('Y-m-d H:i:s'),
		'duration' => '-',
		'error' => '',
		'slots' => [],
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

		$serviceId = testingV2InputString($input, 'serviceId');
		$performerId = testingV2InputString($input, 'performerId');
		$count = testingV2InputString($input, 'count');
		$fromDate = testingV2NormalizeDate(testingV2InputString($input, 'fromDate'));
		$toDateInput = testingV2InputString($input, 'toDate');
		$toDate = $toDateInput !== '' ? testingV2NormalizeDate($toDateInput) : $fromDate;

		if ($serviceId === '' || !ctype_digit($serviceId) || (int) $serviceId < 1) {
			throw new RuntimeException('Service ID must be a positive number.');
		}

		if ($performerId !== '' && (!ctype_digit($performerId) || (int) $performerId < 1)) {
			throw new RuntimeException('Performer ID must be empty or a positive number.');
		}

		if ($count === '') {
			$count = '1';
		}

		if (!ctype_digit($count) || (int) $count < 1) {
			throw new RuntimeException('Count must be a positive number.');
		}

		if ($toDate < $fromDate) {
			throw new RuntimeException('To day must be the same as or later than from day.');
		}

		$authResponse = testingV2CurlJson('https://user-api-v2.simplybook.me/public/auth/token', 'POST', [], [
			'company' => $companyLogin,
			'key' => $widgetApiKey,
		]);
		$token = testingV2ExtractToken($authResponse);

		$query = [
			'service_id' => $serviceId,
			'from' => $fromDate,
			'to' => $toDate,
			'count' => $count,
		];

		if ($performerId !== '') {
			$query['provider_id'] = $performerId;
		}

		$availabilityResponse = testingV2CurlJson('https://user-api-v2.simplybook.me/public/timeline/slots?' . http_build_query($query), 'GET', [
			'X-Company-Login: ' . $companyLogin,
			'X-Token: ' . $token,
		]);

		if ($availabilityResponse['httpStatus'] >= 400) {
			$message = $availabilityResponse['body']['message'] ?? $availabilityResponse['body']['error'] ?? ('SimplyBook HTTP error: ' . $availabilityResponse['httpStatus']);
			throw new RuntimeException(is_array($message) ? json_encode($message) : (string) $message);
		}

		$result['ok'] = true;
		$result['status'] = 'Passed';
		$result['slots'] = testingV2NormalizeAvailabilitySlots($availabilityResponse['body']);
		$result['raw'] = $availabilityResponse['body'];
		$result['httpStatus'] = $availabilityResponse['httpStatus'];
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

testingV2JsonResponse(testingV2RunAvailabilityTest());
