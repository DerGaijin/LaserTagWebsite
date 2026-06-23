<?php

const SIMPLYBOOK_API_URL = 'https://user-api.simplybook.me';
const SIMPLYBOOK_UNIT_ID = 1;

ob_start();
register_shutdown_function(function () {
	$error = error_get_last();
	$fatalTypes = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR];

	if ($error !== null && in_array($error['type'], $fatalTypes, true)) {
		while (ob_get_level() > 0) {
			ob_end_clean();
		}

		http_response_code(500);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(['error' => 'PHP error: ' . $error['message']]);
	}
});

// Local offer ids are the same ids used by SimplyBook events.
$offerIds = ['1', '2', '3', '4', '5', '6'];

function loadDotEnv($path)
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

function envValue($name)
{
	$value = getenv($name);

	return is_string($value) ? trim($value) : '';
}

function jsonResponse($data, $statusCode = 200)
{
	while (ob_get_level() > 0) {
		ob_end_clean();
	}

	http_response_code($statusCode);
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	exit;
}

function logSimplyBookCall($method, $statusCode, $startedAt, $success)
{
	$durationMs = round((microtime(true) - $startedAt) * 1000, 2);
	$status = $statusCode === null ? 'n/a' : (string) $statusCode;
	$result = $success ? 'success' : 'failed';

	// Logged to the PHP/server error log for simple API timing diagnostics.
	error_log('SimplyBook ' . $method . ' ' . $result . ' HTTP ' . $status . ' in ' . $durationMs . ' ms');
}

function jsonRpcCall($url, $method, $params = [], $headers = [])
{
	$startedAt = microtime(true);
	$statusCode = null;
	$payload = json_encode([
		'jsonrpc' => '2.0',
		'method' => $method,
		'params' => $params,
		'id' => uniqid('simplybook_', true),
	]);

	if ($payload === false) {
		throw new RuntimeException('Could not encode SimplyBook request.');
	}

	$curl = curl_init($url);

	if ($curl === false) {
		throw new RuntimeException('Could not initialize cURL.');
	}

	curl_setopt_array($curl, [
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $payload,
		CURLOPT_HTTPHEADER => array_merge([
			'Content-Type: application/json',
			'Content-Length: ' . strlen($payload),
		], $headers),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 20,
	]);

	// Optional local override for Windows PHP installations without a bundled CA file.
	$caCertPath = envValue('SIMPLYBOOK_CA_CERT_PATH');
	if ($caCertPath !== '') {
		curl_setopt($curl, CURLOPT_CAINFO, $caCertPath);
	} else {
		// Local PHP on Windows often has no CA bundle configured, which blocks HTTPS requests.
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	}

	$response = curl_exec($curl);
	$statusCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
	$error = curl_error($curl);

	if ($response === false) {
		logSimplyBookCall($method, $statusCode, $startedAt, false);
		throw new RuntimeException('SimplyBook request failed: ' . $error);
	}

	$decoded = json_decode($response, true);

	if (!is_array($decoded)) {
		logSimplyBookCall($method, $statusCode, $startedAt, false);
		throw new RuntimeException('SimplyBook returned invalid JSON.');
	}

	if (isset($decoded['error'])) {
		$message = is_array($decoded['error']) ? ($decoded['error']['message'] ?? 'Unknown API error') : (string) $decoded['error'];
		logSimplyBookCall($method, $statusCode, $startedAt, false);
		throw new RuntimeException($message);
	}

	if ($statusCode >= 400) {
		logSimplyBookCall($method, $statusCode, $startedAt, false);
		throw new RuntimeException('SimplyBook HTTP error: ' . $statusCode);
	}

	logSimplyBookCall($method, $statusCode, $startedAt, true);

	return $decoded['result'] ?? null;
}

try {
	loadDotEnv(dirname(__DIR__) . '/.env');

	$offerId = (string) ($_GET['offer_id'] ?? '6');
	$month = (string) ($_GET['month'] ?? date('Y-m'));

	if (!in_array($offerId, $offerIds, true) || !preg_match('/^\d{4}-\d{2}$/', $month)) {
		jsonResponse(['error' => 'Invalid availability request.'], 400);
	}

	$companyLogin = envValue('SIMPLYBOOK_COMPANY_LOGIN');
	$apiKey = envValue('SIMPLYBOOK_API_KEY');

	if ($companyLogin === '' || $apiKey === '') {
		jsonResponse(['error' => 'SimplyBook credentials are missing.'], 500);
	}

	if (!function_exists('curl_init')) {
		jsonResponse(['error' => 'PHP cURL extension is not enabled. SimplyBook requests need cURL.'], 500);
	}

	$monthStart = new DateTimeImmutable($month . '-01');
	$dateFrom = $monthStart->format('Y-m-d');
	$dateTo = $monthStart->modify('last day of this month')->format('Y-m-d');

	$token = jsonRpcCall(SIMPLYBOOK_API_URL . '/login', 'getToken', [$companyLogin, $apiKey]);
	$authHeaders = ['X-Company-Login: ' . $companyLogin, 'X-Token: ' . $token];
	$timesByDate = [];
	$matrix = jsonRpcCall(SIMPLYBOOK_API_URL, 'getStartTimeMatrix', [$dateFrom, $dateTo, $offerId, SIMPLYBOOK_UNIT_ID, 1], $authHeaders);

	if (is_array($matrix)) {
		foreach ($matrix as $date => $times) {
			if (!is_array($times)) {
				continue;
			}

			foreach ($times as $time) {
				$timesByDate[(string) $date][(string) $time] = true;
			}
		}
	}

	foreach ($timesByDate as $date => $times) {
		ksort($times);
		$timesByDate[$date] = array_keys($times);
	}

	jsonResponse(['dates' => $timesByDate]);
} catch (Throwable $exception) {
	jsonResponse(['error' => $exception->getMessage()], 500);
}
