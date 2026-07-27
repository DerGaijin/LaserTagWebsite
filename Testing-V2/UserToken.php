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

function testingV2RunUserAccessTokenTest(): array
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
		$widgetApiKey = testingV2EnvValue('SIMPLYBOOK_WIDGET_API_KEY');

		if ($companyLogin === '' || $widgetApiKey === '') {
			throw new RuntimeException('Missing SIMPLYBOOK_COMPANY_LOGIN/SIMPLYBOOK_COMPANY or SIMPLYBOOK_WIDGET_API_KEY.');
		}

		if (!function_exists('curl_init')) {
			throw new RuntimeException('PHP cURL extension is not enabled.');
		}

		$payload = json_encode([
			'company' => $companyLogin,
			'key' => $widgetApiKey,
		]);

		if ($payload === false) {
			throw new RuntimeException('Could not encode SimplyBook user auth request.');
		}

		$curl = curl_init('https://user-api-v2.simplybook.me/public/auth/token');

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
		curl_close($curl);

		$result['httpStatus'] = $httpStatus;

		if ($response === false) {
			throw new RuntimeException('SimplyBook user auth request failed: ' . $curlError);
		}


		$responseText = trim((string) $response);
		$decoded = json_decode($responseText, true);
		$jsonError = json_last_error();

		if ($jsonError !== JSON_ERROR_NONE && stripos($responseText, '<html') !== false) {
			throw new RuntimeException('SimplyBook user auth returned HTML instead of a token response.');
		}

		if ($jsonError !== JSON_ERROR_NONE && strpos($responseText, '<') === 0) {
			throw new RuntimeException('SimplyBook user auth returned markup instead of a token response.');
		}

		if ($httpStatus >= 400) {
			$message = is_array($decoded) ? ($decoded['message'] ?? $decoded['error'] ?? ('SimplyBook HTTP error: ' . $httpStatus)) : ('SimplyBook HTTP error: ' . $httpStatus);
			throw new RuntimeException(is_array($message) ? json_encode($message) : (string) $message);
		}

		$token = '';
		if (is_array($decoded)) {
			$token = (string) ($decoded['token'] ?? $decoded['access_token'] ?? '');
		} elseif (is_string($decoded)) {
			$token = trim($decoded);
		} elseif ($jsonError !== JSON_ERROR_NONE) {
			$token = $responseText;
		}

		if ($token === '') {
			throw new RuntimeException($jsonError === JSON_ERROR_NONE ? 'SimplyBook user auth response did not include a token.' : 'SimplyBook user auth returned invalid JSON and no token text.');
		}

		$result['ok'] = true;
		$result['status'] = 'Passed';
		$result['detail'] = 'HTTP ' . $httpStatus . '. Token: ' . testingV2MaskToken($token) . '.';
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

testingV2JsonResponse(testingV2RunUserAccessTokenTest());
