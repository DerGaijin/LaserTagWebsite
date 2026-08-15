<?php

const SIMPLYBOOK_API_URL = 'https://user-api-v2.simplybook.me/public';
const SIMPLYBOOK_UNIT_ID = 1;
const SIMPLYBOOK_TOKEN_CACHE_SECONDS = 3600;
const SIMPLYBOOK_SERVICE_CACHE_SECONDS = 300;
const SIMPLYBOOK_MAXIMUM_PARTICIPANTS = 30;
const MINIMUM_PARTICIPANTS_BY_OFFER = [
	'16' => 6,
	'17' => 6,
];

$jsonErrorContextCallback = null;
$simplyBookApiLogger = null;

function setJsonErrorContextCallback($callback)
{
	global $jsonErrorContextCallback;

	$jsonErrorContextCallback = is_callable($callback) ? $callback : null;
}

function setSimplyBookApiLogger($callback)
{
	global $simplyBookApiLogger;

	$simplyBookApiLogger = is_callable($callback) ? $callback : null;
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

function minimumParticipantsForOffer($offerId)
{
	return MINIMUM_PARTICIPANTS_BY_OFFER[(string) $offerId] ?? 1;
}

function simplyBookCredentials()
{
	$companyLogin = envValue('SIMPLYBOOK_COMPANY_LOGIN');
	if ($companyLogin === '') {
		$companyLogin = envValue('SIMPLYBOOK_COMPANY');
	}
	$apiKey = envValue('SIMPLYBOOK_WIDGET_API_KEY');

	if ($companyLogin === '' || $apiKey === '') {
		jsonResponse(['error' => 'SimplyBook company or widget API key is missing.'], 500);
	}

	return [$companyLogin, $apiKey];
}

function tokenCachePath($companyLogin)
{
	return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'simplybook_v2_token_' . md5($companyLogin) . '.json';
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

function readCachedTokenCompany($companyLogin)
{
	$path = tokenCachePath($companyLogin);
	$data = is_readable($path) ? json_decode((string) file_get_contents($path), true) : null;

	return is_array($data) ? (string) ($data['company_login'] ?? $companyLogin) : $companyLogin;
}

function tokenExpiration($token)
{
	$segments = explode('.', (string) $token);
	if (count($segments) === 3) {
		$payload = strtr($segments[1], '-_', '+/');
		$payload .= str_repeat('=', (4 - strlen($payload) % 4) % 4);
		$claims = json_decode((string) base64_decode($payload, true), true);
		if (is_array($claims) && isset($claims['exp']) && is_numeric($claims['exp'])) {
			return max(time() + 60, (int) $claims['exp'] - 30);
		}
	}

	return time() + SIMPLYBOOK_TOKEN_CACHE_SECONDS;
}

function writeCachedToken($companyLogin, $token, $tokenCompanyLogin = '')
{
	$data = json_encode([
		'token' => $token,
		'company_login' => $tokenCompanyLogin !== '' ? $tokenCompanyLogin : $companyLogin,
		'expires_at' => tokenExpiration($token),
	]);

	if ($data !== false) {
		file_put_contents(tokenCachePath($companyLogin), $data, LOCK_EX);
	}
}

function getSimplyBookToken($companyLogin, $apiKey)
{
	return getSimplyBookAuth($companyLogin, $apiKey)['token'];
}

function getSimplyBookAuth($companyLogin, $apiKey)
{
	$token = readCachedToken($companyLogin);

	if ($token !== '') {
		return ['token' => $token, 'company_login' => readCachedTokenCompany($companyLogin)];
	}

	$response = simplyBookApiCall('/auth/token', 'POST', [], [
		'company' => $companyLogin,
		'key' => $apiKey,
	]);
	$token = simplyBookExtractToken($response);
	$tokenCompanyLogin = trim((string) ($response['company_login'] ?? $response['company'] ?? $companyLogin));
	writeCachedToken($companyLogin, $token, $tokenCompanyLogin);

	return ['token' => $token, 'company_login' => $tokenCompanyLogin];
}

function serviceCachePath($companyLogin)
{
	return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'simplybook_v2_services_' . md5($companyLogin) . '.json';
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

	$auth = getSimplyBookAuth($companyLogin, $apiKey);
	$response = simplyBookApiCall('/services', 'GET', [
		'X-Company-Login: ' . $auth['company_login'],
		'X-Token: ' . $auth['token'],
	]);
	$services = $response['data'] ?? $response['services'] ?? $response;
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

function simplyBookErrorMessage($response, $fallback)
{
	if (!is_array($response)) {
		return $fallback;
	}

	foreach (['message', 'error', 'detail', 'title'] as $key) {
		if (!isset($response[$key])) {
			continue;
		}

		$value = $response[$key];
		return is_scalar($value) ? (string) $value : (json_encode($value) ?: $fallback);
	}

	return $fallback;
}

function simplyBookApiCall($path, $method = 'GET', $headers = [], $payload = null, $query = [])
{
	global $simplyBookApiLogger;

	$url = SIMPLYBOOK_API_URL . $path;
	if ($query !== []) {
		$url .= '?' . http_build_query($query);
	}

	if (is_callable($simplyBookApiLogger)) {
		$simplyBookApiLogger('request', $url, $method, $payload, null, null, '');
	}

	$body = null;
	if ($payload !== null) {
		$body = json_encode($payload);
	}

	if ($body === false) {
		throw new RuntimeException('Could not encode SimplyBook request.');
	}

	$curl = curl_init($url);

	if ($curl === false) {
		throw new RuntimeException('Could not initialize cURL.');
	}

	curl_setopt_array($curl, [
		CURLOPT_CUSTOMREQUEST => strtoupper($method),
		CURLOPT_HTTPHEADER => array_merge(['Accept: application/json'], $headers, $body === null ? [] : [
			'Content-Type: application/json',
			'Content-Length: ' . strlen($body),
		]),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 20,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_USERAGENT => 'Lasertag-Reservation/2.0',
	]);
	if ($body !== null) {
		curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
	}

	$caCertPath = envValue('SIMPLYBOOK_CA_CERT_PATH');
	if ($caCertPath !== '') {
		curl_setopt($curl, CURLOPT_CAINFO, $caCertPath);
	} else {
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	}

	$response = curl_exec($curl);
	$statusCode = (int) curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
	$error = curl_error($curl);

	if (is_callable($simplyBookApiLogger)) {
		$simplyBookApiLogger('response', $url, $method, $payload, $response, $statusCode, $error);
	}

	if ($response === false) {
		throw new RuntimeException('SimplyBook request failed: ' . $error);
	}

	$decoded = json_decode($response, true);

	if (!is_array($decoded)) {
		throw new RuntimeException('SimplyBook returned invalid JSON.');
	}

	if ($statusCode >= 400) {
		throw new RuntimeException(simplyBookErrorMessage($decoded, 'SimplyBook HTTP error: ' . $statusCode));
	}

	return $decoded;
}

function simplyBookExtractToken($response)
{
	$token = is_array($response) ? (string) ($response['token'] ?? $response['access_token'] ?? '') : '';
	if ($token === '') {
		throw new RuntimeException('SimplyBook response did not include a token.');
	}

	return $token;
}

function simplyBookExtractClient($response)
{
	if (!is_array($response)) {
		return [];
	}

	$client = is_array($response['client'] ?? null) ? $response['client'] : (is_array($response['data'] ?? null) ? $response['data'] : $response);
	if (empty($client['id']) && empty($client['client_id'])) {
		$token = (string) ($response['token'] ?? $response['access_token'] ?? '');
		$segments = explode('.', $token);
		if (count($segments) === 3) {
			$payload = strtr($segments[1], '-_', '+/');
			$payload .= str_repeat('=', (4 - strlen($payload) % 4) % 4);
			$claims = json_decode((string) base64_decode($payload, true), true);
			$claimId = is_array($claims['data'] ?? null) ? ($claims['data']['client'] ?? null) : null;
			if (is_numeric($claimId)) {
				$client['id'] = (int) $claimId;
			}
		}
	}

	return is_array($client) ? $client : [];
}

function startReservationSession()
{
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
}

function storeSimplyBookClientSession($companyLogin, $response)
{
	startReservationSession();
	session_regenerate_id(true);
	$_SESSION['simplybook_client_token'] = simplyBookExtractToken($response);
	$_SESSION['simplybook_company_login'] = (string) ($response['company_login'] ?? $response['company'] ?? $companyLogin);
	$client = simplyBookExtractClient($response);
	$_SESSION['simplybook_client_id'] = (string) ($client['id'] ?? $client['client_id'] ?? '');
}

function publicClientData($client)
{
	if (!is_array($client)) {
		return [];
	}
	$name = trim((string) ($client['name'] ?? $client['full_name'] ?? ''));
	if ($name === '') {
		$firstName = (string) ($client['first_name'] ?? $client['firstname'] ?? '');
		$lastName = (string) ($client['last_name'] ?? $client['lastname'] ?? '');
		$name = trim($firstName . ' ' . $lastName);
	}

	return [
		'id' => (string) ($client['id'] ?? $client['client_id'] ?? ''),
		'name' => $name,
		'email' => (string) ($client['email'] ?? $client['login'] ?? ''),
		'phone' => (string) ($client['phone'] ?? ''),
	];
}
