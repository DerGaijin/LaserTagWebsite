<?php

const SIMPLYBOOK_API_URL = 'https://user-api.simplybook.me';
const SIMPLYBOOK_UNIT_ID = 1;
const SIMPLYBOOK_TOKEN_CACHE_SECONDS = 3600;
const SIMPLYBOOK_AVAILABILITY_CACHE_SECONDS = 60;

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
$apiCallResults = [];

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

function availabilityCachePath($offerId, $date, $count)
{
	$key = md5($offerId . '|' . $date . '|' . $count . '|' . SIMPLYBOOK_UNIT_ID);

	return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'simplybook_availability_' . $key . '.json';
}

function availabilityLockPath($offerId, $date, $count)
{
	return availabilityCachePath($offerId, $date, $count) . '.lock';
}

function readCachedAvailability($offerId, $date, $count)
{
	$path = availabilityCachePath($offerId, $date, $count);

	if (!is_readable($path)) {
		return null;
	}

	$data = json_decode((string) file_get_contents($path), true);

	if (!is_array($data) || empty($data['expires_at']) || time() >= (int) $data['expires_at'] || !isset($data['dates'])) {
		return null;
	}

	return $data['dates'];
}

function writeCachedAvailability($offerId, $date, $count, $dates)
{
	$data = json_encode([
		'expires_at' => time() + SIMPLYBOOK_AVAILABILITY_CACHE_SECONDS,
		'dates' => $dates,
	]);

	if ($data !== false) {
		file_put_contents(availabilityCachePath($offerId, $date, $count), $data, LOCK_EX);
	}
}

function acquireAvailabilityLock($offerId, $date, $count)
{
	$lock = fopen(availabilityLockPath($offerId, $date, $count), 'c');

	if ($lock === false) {
		return null;
	}

	if (flock($lock, LOCK_EX | LOCK_NB)) {
		return $lock;
	}

	fclose($lock);

	return null;
}

function releaseAvailabilityLock($lock)
{
	if ($lock !== null) {
		flock($lock, LOCK_UN);
		fclose($lock);
	}
}

function waitForCachedAvailability($offerId, $date, $count)
{
	$deadline = microtime(true) + 8;

	while (microtime(true) < $deadline) {
		usleep(100000);
		$cachedDates = readCachedAvailability($offerId, $date, $count);

		if ($cachedDates !== null) {
			return $cachedDates;
		}
	}

	return null;
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
	global $apiCallResults;

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

	$result = $decoded['result'] ?? null;
	$apiCallResults[] = [
		'method' => $method,
		'params' => $params,
		'result' => $method === 'getToken' ? '[redacted]' : $result,
	];

	return $result;
}

try {
	set_time_limit(90);
	loadDotEnv(dirname(__DIR__) . '/.env');

	$offerId = (string) ($_GET['offer_id'] ?? '6');
	$date = (string) ($_GET['date'] ?? date('Y-m-d'));
	$count = max(1, (int) ($_GET['count'] ?? 1));

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

	$cachedDates = readCachedAvailability($offerId, $date, $count);

	if ($cachedDates !== null) {
		jsonResponse(['dates' => $cachedDates, 'apiCalls' => [], 'cached' => true]);
	}

	$availabilityLock = acquireAvailabilityLock($offerId, $date, $count);

	if ($availabilityLock === null) {
		$cachedDates = waitForCachedAvailability($offerId, $date, $count);

		if ($cachedDates !== null) {
			jsonResponse(['dates' => $cachedDates, 'apiCalls' => [], 'cached' => true]);
		}
	} else {
		$cachedDates = readCachedAvailability($offerId, $date, $count);

		if ($cachedDates !== null) {
			releaseAvailabilityLock($availabilityLock);
			jsonResponse(['dates' => $cachedDates, 'apiCalls' => [], 'cached' => true]);
		}
	}

	// Keep getStartTimeMatrix fast by asking SimplyBook for one selected day only.
	$dateFrom = $date;
	$dateTo = $date;

	$token = getSimplyBookToken($companyLogin, $apiKey);
	$authHeaders = ['X-Company-Login: ' . $companyLogin, 'X-Token: ' . $token];
	$matrix = jsonRpcCall(SIMPLYBOOK_API_URL, 'getStartTimeMatrix', [$dateFrom, $dateTo, $offerId, SIMPLYBOOK_UNIT_ID, $count], $authHeaders);
	$availableTimes = timesFromMatrix($matrix, $date);
	$timesByDate = [$date => []];

	ksort($availableTimes);

	foreach (array_keys($availableTimes) as $time) {
		$timesByDate[$date][] = [
			'time' => $time,
			'count' => $count,
		];
	}

	writeCachedAvailability($offerId, $date, $count, $timesByDate);
	releaseAvailabilityLock($availabilityLock);

	jsonResponse(['dates' => $timesByDate, 'apiCalls' => $apiCallResults, 'cached' => false]);
} catch (Throwable $exception) {
	if (isset($availabilityLock)) {
		releaseAvailabilityLock($availabilityLock);
	}

	jsonResponse(['error' => $exception->getMessage()], 500);
}
