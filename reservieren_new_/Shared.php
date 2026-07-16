<?php

const SIMPLYBOOK_API_URL = 'https://user-api.simplybook.me';
const SIMPLYBOOK_UNIT_ID = 1;
const SIMPLYBOOK_TOKEN_CACHE_SECONDS = 3600;
const SIMPLYBOOK_SERVICE_CACHE_SECONDS = 300;

$jsonErrorContextCallback = null;
$simplyBookRpcLogger = null;

function setJsonErrorContextCallback($callback)
{
	global $jsonErrorContextCallback;

	$jsonErrorContextCallback = is_callable($callback) ? $callback : null;
}

function setSimplyBookRpcLogger($callback)
{
	global $simplyBookRpcLogger;

	$simplyBookRpcLogger = is_callable($callback) ? $callback : null;
}

function registerJsonFatalHandler($callback = null)
{
	ob_start();
	register_shutdown_function(function () use ($callback) {
		global $jsonErrorContextCallback;

		$error = error_get_last();
		$fatalTypes = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR];

		if ($error !== null && in_array($error['type'], $fatalTypes, true)) {
			if (is_callable($callback)) {
				$callback($error);
			}

			while (ob_get_level() > 0) {
				ob_end_clean();
			}

			$data = ['error' => 'PHP error: ' . $error['message']];
			if (is_callable($jsonErrorContextCallback)) {
				$data = array_merge($data, (array) $jsonErrorContextCallback($data, 500));
			}

			http_response_code(500);
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
	});
}

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

function loadReservationEnv()
{
	loadDotEnv(dirname(__DIR__) . '/.env');
}

function envValue($name)
{
	$value = getenv($name);

	return is_string($value) ? trim($value) : '';
}

function jsonResponse($data, $statusCode = 200)
{
	global $jsonErrorContextCallback;

	while (ob_get_level() > 0) {
		ob_end_clean();
	}

	if ($statusCode >= 400 && is_callable($jsonErrorContextCallback)) {
		$data = array_merge($data, (array) $jsonErrorContextCallback($data, $statusCode));
	}

	http_response_code($statusCode);
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	exit;
}

function requirePostRequest()
{
	if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
		jsonResponse(['error' => 'Invalid request method.'], 405);
	}
}

function requireCurlExtension()
{
	if (!function_exists('curl_init')) {
		jsonResponse(['error' => 'PHP cURL extension is not enabled. SimplyBook requests need cURL.'], 500);
	}
}

function validOfferIds()
{
	return ['16', '17', '18', '19', '20', '21'];
}

function simplyBookCredentials()
{
	$companyLogin = envValue('SIMPLYBOOK_COMPANY_LOGIN');
	$apiKey = envValue('SIMPLYBOOK_API_KEY');

	if ($companyLogin === '' || $apiKey === '') {
		jsonResponse(['error' => 'SimplyBook credentials are missing.'], 500);
	}

	return [$companyLogin, $apiKey];
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

function serviceCachePath($companyLogin)
{
	return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'simplybook_services_' . md5($companyLogin) . '.json';
}

function readCachedServices($companyLogin)
{
	$path = serviceCachePath($companyLogin);

	if (!is_readable($path)) {
		return null;
	}

	$data = json_decode((string) file_get_contents($path), true);

	if (!is_array($data) || empty($data['expires_at']) || time() >= (int) $data['expires_at'] || !isset($data['services']) || !is_array($data['services'])) {
		return null;
	}

	return $data['services'];
}

function writeCachedServices($companyLogin, $services)
{
	$data = json_encode([
		'expires_at' => time() + SIMPLYBOOK_SERVICE_CACHE_SECONDS,
		'services' => $services,
	]);

	if ($data !== false) {
		file_put_contents(serviceCachePath($companyLogin), $data, LOCK_EX);
	}
}

function getSimplyBookServices($companyLogin, $apiKey)
{
	$services = readCachedServices($companyLogin);

	if ($services !== null) {
		return $services;
	}

	$token = getSimplyBookToken($companyLogin, $apiKey);
	$services = jsonRpcCall(SIMPLYBOOK_API_URL, 'getEventList', [], [
		'X-Company-Login: ' . $companyLogin,
		'X-Token: ' . $token,
	]);
	$services = is_array($services) ? $services : [];
	writeCachedServices($companyLogin, $services);

	return $services;
}

function formatSimplyBookServiceDuration($duration)
{
	$duration = trim((string) $duration);

	if (!ctype_digit($duration)) {
		return $duration;
	}

	$minutes = (int) $duration;
	if ($minutes > 0 && $minutes % 60 === 0) {
		$hours = (int) ($minutes / 60);
		return $hours . ' ' . ($hours === 1 ? 'Stunde' : 'Stunden');
	}

	return $minutes > 0 ? $minutes . ' Minuten' : '';
}

function simplyBookServiceDescription($service)
{
	$description = $service['description'] ?? $service['desc'] ?? '';
	$description = strip_tags((string) $description, '<p><br><strong><b><em><i><u><ul><ol><li><h1><h2><h3><h4><h5><h6><blockquote>');
	$description = preg_replace('/<(p|br|strong|b|em|i|u|ul|ol|li|h[1-6]|blockquote)\b[^>]*>/i', '<$1>', $description);

	return trim($description);
}

function jsonRpcCall($url, $method, $params = [], $headers = [])
{
	global $simplyBookRpcLogger;

	if (is_callable($simplyBookRpcLogger)) {
		$simplyBookRpcLogger('request', $url, $method, $params, null, null, '');
	}

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

	$caCertPath = envValue('SIMPLYBOOK_CA_CERT_PATH');
	if ($caCertPath !== '') {
		curl_setopt($curl, CURLOPT_CAINFO, $caCertPath);
	} else {
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	}

	$response = curl_exec($curl);
	$statusCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
	$error = curl_error($curl);

	if (is_callable($simplyBookRpcLogger)) {
		$simplyBookRpcLogger('response', $url, $method, $params, $response, $statusCode, $error);
	}

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

function publicClientData($client)
{
	if (!is_array($client)) {
		return [];
	}

	return [
		'id' => (string) ($client['id'] ?? ''),
		'name' => (string) ($client['name'] ?? ''),
		'email' => (string) ($client['email'] ?? $client['login'] ?? ''),
		'phone' => (string) ($client['phone'] ?? ''),
	];
}
