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

function testingV2RunAdminAccessTokenTest(): array
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
		'httpStatus' => null,
	];

	try {
		testingV2LoadDotEnv(dirname(__DIR__) . '/.env');

		$companyLogin = testingV2FirstEnvValue(['SIMPLYBOOK_COMPANY_LOGIN', 'SIMPLYBOOK_COMPANY']);
		$adminLogin = testingV2EnvValue('SIMPLYBOOK_ADMIN_LOGIN');
		$adminPassword = testingV2FirstEnvValue(['SIMPLYBOOK_ADMIN_PASSWORD', 'SIMPLYBOOK_ADMIN_API_KEY', 'SIMPLYBOOK_ADMIN_KEY']);

		if ($companyLogin === '' || $adminLogin === '' || $adminPassword === '') {
			throw new RuntimeException('Missing SIMPLYBOOK_COMPANY_LOGIN/SIMPLYBOOK_COMPANY, SIMPLYBOOK_ADMIN_LOGIN, or SIMPLYBOOK_ADMIN_PASSWORD/SIMPLYBOOK_ADMIN_API_KEY/SIMPLYBOOK_ADMIN_KEY.');
		}

		if (!function_exists('curl_init')) {
			throw new RuntimeException('PHP cURL extension is not enabled.');
		}

		$payload = json_encode([
			'company' => $companyLogin,
			'login' => $adminLogin,
			'password' => $adminPassword,
		]);

		if ($payload === false) {
			throw new RuntimeException('Could not encode SimplyBook admin auth request.');
		}

		$curl = curl_init('https://user-api-v2.simplybook.me/admin/auth');

		if ($curl === false) {
			throw new RuntimeException('Could not initialize cURL.');
		}

		curl_setopt_array($curl, [
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $payload,
			CURLOPT_HTTPHEADER => [
				'Accept: application/json',
				'Content-Type: application/json',
				'Content-Length: ' . strlen($payload),
			],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 20,
		]);

		$caCertPath = testingV2EnvValue('SIMPLYBOOK_CA_CERT_PATH');
		if ($caCertPath !== '') {
			curl_setopt($curl, CURLOPT_CAINFO, $caCertPath);
		} else {
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		}

		$response = curl_exec($curl);
		$httpStatus = (int) curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
		$curlError = curl_error($curl);

		$result['httpStatus'] = $httpStatus;

		if ($response === false) {
			throw new RuntimeException('SimplyBook admin auth request failed: ' . $curlError);
		}

		$decoded = json_decode($response, true);
		if (!is_array($decoded)) {
			throw new RuntimeException('SimplyBook admin auth returned invalid JSON.');
		}

		if ($httpStatus >= 400) {
			$message = $decoded['message'] ?? $decoded['error'] ?? ('SimplyBook HTTP error: ' . $httpStatus);
			throw new RuntimeException(is_array($message) ? json_encode($message) : (string) $message);
		}

		$token = (string) ($decoded['token'] ?? '');
		$refreshToken = (string) ($decoded['refresh_token'] ?? '');

		if ($token === '') {
			throw new RuntimeException('SimplyBook admin auth response did not include a token.');
		}

		$result['ok'] = true;
		$result['status'] = 'Passed';
		$result['detail'] = 'HTTP ' . $httpStatus . '. Token: ' . testingV2MaskToken($token) . ($refreshToken !== '' ? '. Refresh token: ' . testingV2MaskToken($refreshToken) : '.');
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

testingV2JsonResponse(testingV2RunAdminAccessTokenTest());
