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
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 20,
		CURLOPT_USERAGENT => 'Mozilla/5.0 Lasertag-ServiceBookingTest/2.0',
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

function testingV2ExtractCompanyLogin(array $authResponse, string $fallback): string
{
	// Token responses identify the exact company login required by subsequent API calls.
	$body = $authResponse['body'];
	$companyLogin = (string) ($body['company_login'] ?? $body['company'] ?? $fallback);

	if (trim($companyLogin) === '') {
		throw new RuntimeException('SimplyBook token response did not include a company login.');
	}

	return trim($companyLogin);
}

function testingV2InputString(array $input, string $name): string
{
	$value = $input[$name] ?? '';

	return is_scalar($value) ? trim((string) $value) : '';
}

function testingV2ExtractClientId(array $clientResponse): int
{
	// Prefer an explicit client ID when SimplyBook includes one in the response.
	$body = $clientResponse['body'];
	$client = is_array($body['client'] ?? null) ? $body['client'] : (is_array($body['data'] ?? null) ? $body['data'] : $body);
	$id = $client['id'] ?? $client['client_id'] ?? null;

	if (is_numeric($id) && (int) $id > 0) {
		return (int) $id;
	}

	// Current client-login responses may expose the ID only as the JWT data.client claim.
	$token = (string) ($body['token'] ?? $body['access_token'] ?? '');
	$segments = explode('.', $token);

	if (count($segments) === 3) {
		$payload = strtr($segments[1], '-_', '+/');
		$payload .= str_repeat('=', (4 - strlen($payload) % 4) % 4);
		$decodedPayload = base64_decode($payload, true);
		$claims = is_string($decodedPayload) ? json_decode($decodedPayload, true) : null;
		$claimData = is_array($claims['data'] ?? null) ? $claims['data'] : [];
		$claimId = $claimData['client'] ?? null;

		if (is_numeric($claimId) && (int) $claimId > 0) {
			return (int) $claimId;
		}
	}

	throw new RuntimeException('SimplyBook client login returned neither a client id nor a numeric data.client token claim.');
}

function testingV2NormalizeDate(string $date): string
{
	if ($date === '') {
		throw new RuntimeException('Date is required.');
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

function testingV2NormalizeTime(string $time): string
{
	if (preg_match('/^\d{1,2}:\d{2}$/', $time) === 1) {
		[$hour, $minute] = explode(':', $time, 2);

		return sprintf('%02d:%02d:00', (int) $hour, (int) $minute);
	}

	if (preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $time) === 1) {
		[$hour, $minute, $second] = explode(':', $time, 3);

		return sprintf('%02d:%02d:%02d', (int) $hour, (int) $minute, (int) $second);
	}

	throw new RuntimeException('Time must use HH:MM or HH:MM:SS.');
}

function testingV2MaskSensitiveResponse(array $value): array
{
	foreach ($value as $key => $item) {
		$keyText = is_string($key) ? strtolower($key) : '';

		if (is_array($item)) {
			$value[$key] = testingV2MaskSensitiveResponse($item);
		} elseif (is_scalar($item) && ($keyText === 'token' || $keyText === 'access_token' || $keyText === 'refresh_token')) {
			$value[$key] = '********';
		}
	}

	return $value;
}

function testingV2ErrorMessageFromResponse(array $response, string $fallback): string
{
	foreach (['message', 'error', 'detail', 'title'] as $key) {
		if (!array_key_exists($key, $response)) {
			continue;
		}

		$value = $response[$key];
		if (is_scalar($value) && trim((string) $value) !== '') {
			return trim((string) $value);
		}

		if (is_array($value)) {
			$encoded = json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			if (is_string($encoded) && $encoded !== '') {
				return $encoded;
			}
		}
	}

	$encoded = json_encode(testingV2MaskSensitiveResponse($response), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

	return is_string($encoded) && $encoded !== '' ? $fallback . ': ' . $encoded : $fallback;
}

function testingV2RequireSuccessfulResponse(array $response): void
{
	// Preserve the HTTP status instead of exposing only SimplyBook's generic message.
	if ($response['httpStatus'] < 400) {
		return;
	}

	$message = testingV2ErrorMessageFromResponse($response['body'], 'No error detail returned');
	throw new RuntimeException('HTTP ' . $response['httpStatus'] . ': ' . $message);
}

function testingV2RunBookingTest(): array
{
	$startedAt = microtime(true);
	$stage = 'Initialization';
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
		// Load and validate server-side API configuration.
		$stage = 'Configuration';
		testingV2LoadDotEnv(dirname(__DIR__) . '/.env');

		$companyLogin = testingV2FirstEnvValue(['SIMPLYBOOK_COMPANY_LOGIN', 'SIMPLYBOOK_COMPANY']);
		$widgetApiKey = testingV2EnvValue('SIMPLYBOOK_WIDGET_API_KEY');

		if ($companyLogin === '' || $widgetApiKey === '') {
			throw new RuntimeException('Missing SIMPLYBOOK_COMPANY_LOGIN/SIMPLYBOOK_COMPANY or SIMPLYBOOK_WIDGET_API_KEY.');
		}

		if (!function_exists('curl_init')) {
			throw new RuntimeException('PHP cURL extension is not enabled.');
		}

		// Parse and validate the submitted booking details.
		$stage = 'Input validation';
		$input = json_decode((string) file_get_contents('php://input'), true);
		if (!is_array($input)) {
			$input = $_POST;
		}

		$serviceId = testingV2InputString($input, 'serviceId');
		$performerId = testingV2InputString($input, 'performerId');
		$date = testingV2NormalizeDate(testingV2InputString($input, 'date'));
		$time = testingV2NormalizeTime(testingV2InputString($input, 'time'));
		$count = testingV2InputString($input, 'count');
		$clientName = testingV2InputString($input, 'clientName');
		$clientEmail = testingV2InputString($input, 'clientEmail');
		$clientPhone = testingV2InputString($input, 'clientPhone');
		$clientPassword = testingV2InputString($input, 'clientPassword');

		if ($serviceId === '' || !ctype_digit($serviceId) || (int) $serviceId < 1) {
			throw new RuntimeException('Service ID must be a positive number.');
		}

		if ($performerId === '' || !ctype_digit($performerId) || (int) $performerId < 1) {
			throw new RuntimeException('Performer ID must be a positive number.');
		}

		if ($count === '') {
			$count = '1';
		}

		if (!ctype_digit($count) || (int) $count < 1) {
			throw new RuntimeException('Count must be a positive number.');
		}

		if ($clientName === '' || $clientEmail === '' || $clientPhone === '' || $clientPassword === '') {
			throw new RuntimeException('Client name, email, phone, and password are required.');
		}

		if (filter_var($clientEmail, FILTER_VALIDATE_EMAIL) === false) {
			throw new RuntimeException('Client email must be valid.');
		}

		// Obtain the anonymous public API token required for client login.
		$stage = 'Public API authentication';
		$authResponse = testingV2CurlJson('https://user-api-v2.simplybook.me/public/auth/token', 'POST', [], [
			'company' => $companyLogin,
			'key' => $widgetApiKey,
		]);
		$result['httpStatus'] = $authResponse['httpStatus'];
		testingV2RequireSuccessfulResponse($authResponse);
		$token = testingV2ExtractToken($authResponse);
		$publicCompanyLogin = testingV2ExtractCompanyLogin($authResponse, $companyLogin);

		// Authenticate the client and obtain their client-bound API token and ID.
		$stage = 'Client login';
		$loginResponse = testingV2CurlJson('https://user-api-v2.simplybook.me/public/clients/login', 'POST', [
			'X-Company-Login: ' . $publicCompanyLogin,
			'X-Token: ' . $token,
		], [
			'login' => $clientEmail,
			'password' => $clientPassword,
			'remember' => false,
		]);
		$result['httpStatus'] = $loginResponse['httpStatus'];
		testingV2RequireSuccessfulResponse($loginResponse);

		// Use the client identity and token returned directly by login.
		$clientToken = testingV2ExtractToken($loginResponse);
		$clientCompanyLogin = testingV2ExtractCompanyLogin($loginResponse, $publicCompanyLogin);
		$clientId = testingV2ExtractClientId($loginResponse);

		// Build the public booking request.
		$payload = [
			'service_id' => (int) $serviceId,
			'provider_id' => (int) $performerId,
			'start_datetime' => $date . ' ' . $time,
			'count' => (int) $count,
			'client_id' => $clientId,
			'client' => [
				'id' => $clientId,
				'name' => $clientName,
				'email' => $clientEmail,
				'phone' => $clientPhone,
			],
			'additional_fields' => [],
			'terms' => [
				'simplybook_terms' => true,
				'user_terms' => true,
				'cancellation_terms' => true,
				'privacy_policy' => true,
			],
		];

		// Submit the booking with the authenticated client token.
		$stage = 'Booking submission';
		$bookingResponse = testingV2CurlJson('https://user-api-v2.simplybook.me/public/booking/item', 'POST', [
			'X-Company-Login: ' . $clientCompanyLogin,
			'X-Token: ' . $clientToken,
		], $payload);

		$result['raw'] = testingV2MaskSensitiveResponse($bookingResponse['body']);
		$result['httpStatus'] = $bookingResponse['httpStatus'];
		testingV2RequireSuccessfulResponse($bookingResponse);

		// Extract identifiers from the successful booking response.
		$stage = 'Booking response parsing';
		$body = $bookingResponse['body'];
		$booking = is_array($body['bookings'][0] ?? null)
			? $body['bookings'][0]
			: (is_array($body['booking'] ?? null) ? $body['booking'] : (is_array($body['data'] ?? null) ? $body['data'] : $body));
		$bookingId = is_array($booking) ? (string) ($booking['id'] ?? $booking['booking_id'] ?? $booking['schedule_id'] ?? '') : '';
		$bookingSign = is_array($booking) ? (string) ($booking['sign'] ?? '') : '';

		$result['ok'] = true;
		$result['status'] = 'Passed';
		$result['detail'] = 'HTTP ' . $bookingResponse['httpStatus'] . '. Booking accepted'
			. ($bookingId !== '' ? '. Booking ID: ' . $bookingId : '')
			. ($bookingSign !== '' ? '. Sign: ' . $bookingSign : '')
			. '.';
	} catch (Throwable $exception) {
		$result['error'] = $stage . ': ' . $exception->getMessage();

		if (isset($authResponse) && $stage === 'Public API authentication') {
			$result['raw'] = testingV2MaskSensitiveResponse($authResponse['body']);
		} elseif (isset($loginResponse) && $stage === 'Client login') {
			$result['raw'] = testingV2MaskSensitiveResponse($loginResponse['body']);
		}
	} finally {
		$result['duration'] = number_format((microtime(true) - $startedAt) * 1000, 0) . ' ms';
	}

	return $result;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
	testingV2JsonResponse(['error' => 'Invalid request method.'], 405);
}

testingV2JsonResponse(testingV2RunBookingTest());
