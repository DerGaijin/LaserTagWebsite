<?php

const SIMPLYBOOK_API_URL = 'https://user-api.simplybook.me';
const SIMPLYBOOK_UNIT_ID = 1;
const SIMPLYBOOK_TOKEN_CACHE_SECONDS = 3600;
const SIMPLYBOOK_MAX_PARTICIPANTS = 12;

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

function tokenCachePath($companyLogin)
{
	return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'simplybook_token_' . md5($companyLogin) . '.json';
}

function readCachedToken($companyLogin)
{
	$path = tokenCachePath($companyLogin);

	if (!is_readable($path)) {
		return '';
	}

	$data = json_decode((string) file_get_contents($path), true);

	if (!is_array($data) || empty($data['token']) || empty($data['expires_at']) || time() >= (int) $data['expires_at']) {
		return '';
	}

	return (string) $data['token'];
}

function writeCachedToken($companyLogin, $token)
{
	$data = json_encode([
		'token' => $token,
		'expires_at' => time() + SIMPLYBOOK_TOKEN_CACHE_SECONDS,
	]);

	if ($data !== false) {
		file_put_contents(tokenCachePath($companyLogin), $data, LOCK_EX);
	}
}

function getSimplyBookToken($companyLogin, $apiKey)
{
	$token = readCachedToken($companyLogin);

	if ($token !== '') {
		return $token;
	}

	$token = jsonRpcCall(SIMPLYBOOK_API_URL . '/login', 'getToken', [$companyLogin, $apiKey]);
	writeCachedToken($companyLogin, (string) $token);

	return (string) $token;
}

function timesFromMatrix($matrix, $date)
{
	$times = [];

	if (!is_array($matrix) || !isset($matrix[$date]) || !is_array($matrix[$date])) {
		return $times;
	}

	foreach ($matrix[$date] as $time) {
		$times[(string) $time] = true;
	}

	return $times;
}

function jsonRpcCall($url, $method, $params = [], $headers = [])
{
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
		throw new RuntimeException('SimplyBook request failed: ' . $error);
	}

	$decoded = json_decode($response, true);

	if (!is_array($decoded)) {
		throw new RuntimeException('SimplyBook returned invalid JSON.');
	}

	if (isset($decoded['error'])) {
		$message = is_array($decoded['error']) ? ($decoded['error']['message'] ?? 'Unknown API error') : (string) $decoded['error'];
		throw new RuntimeException($message);
	}

	if ($statusCode >= 400) {
		throw new RuntimeException('SimplyBook HTTP error: ' . $statusCode);
	}

	return $decoded['result'] ?? null;
}

try {
	loadDotEnv(dirname(__DIR__) . '/.env');

	$offerId = (string) ($_GET['offer_id'] ?? '6');
	$date = (string) ($_GET['date'] ?? date('Y-m-d'));

	if (!in_array($offerId, $offerIds, true) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
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

	// Keep getStartTimeMatrix fast by asking SimplyBook for one selected day only.
	$dateFrom = $date;
	$dateTo = $date;

	$token = getSimplyBookToken($companyLogin, $apiKey);
	$authHeaders = ['X-Company-Login: ' . $companyLogin, 'X-Token: ' . $token];
	$matrix = jsonRpcCall(SIMPLYBOOK_API_URL, 'getStartTimeMatrix', [$dateFrom, $dateTo, $offerId, SIMPLYBOOK_UNIT_ID, 1], $authHeaders);
	$availableTimes = timesFromMatrix($matrix, $date);
	$freeByTime = [];

	foreach (array_keys($availableTimes) as $time) {
		$freeByTime[$time] = 1;
	}

	// SimplyBook only tells us whether a start time is available for a requested count.
	// To show free spots, test larger counts and keep the highest working count per time.
	$pendingTimes = $availableTimes;
	for ($count = SIMPLYBOOK_MAX_PARTICIPANTS; $count >= 2 && $pendingTimes !== []; $count--) {
		$matrix = jsonRpcCall(SIMPLYBOOK_API_URL, 'getStartTimeMatrix', [$dateFrom, $dateTo, $offerId, SIMPLYBOOK_UNIT_ID, $count], $authHeaders);
		$countTimes = timesFromMatrix($matrix, $date);

		foreach (array_keys($pendingTimes) as $time) {
			if (isset($countTimes[$time])) {
				$freeByTime[$time] = $count;
				unset($pendingTimes[$time]);
			}
		}
	}

	ksort($freeByTime);
	$timesByDate = [$date => []];

	foreach ($freeByTime as $time => $free) {
		$timesByDate[$date][] = [
			'time' => $time,
			'free' => $free,
			'hasMore' => $free >= SIMPLYBOOK_MAX_PARTICIPANTS,
		];
	}

	jsonResponse(['dates' => $timesByDate]);
} catch (Throwable $exception) {
	jsonResponse(['error' => $exception->getMessage()], 500);
}
