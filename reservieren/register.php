<?php

const SIMPLYBOOK_API_URL = 'https://user-api.simplybook.me';

$requestId = uniqid('register_', true);

ob_start();
register_shutdown_function(function () {
	$error = error_get_last();
	$fatalTypes = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR];

	if ($error !== null && in_array($error['type'], $fatalTypes, true)) {
		global $requestId;
		debugLog('fatal_php_error', ['message' => $error['message'], 'file' => $error['file'] ?? '', 'line' => $error['line'] ?? '']);

		while (ob_get_level() > 0) {
			ob_end_clean();
		}

		http_response_code(500);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(['error' => 'PHP error: ' . $error['message'], 'request_id' => $requestId]);
	}
});

function debugLogPath()
{
	return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'simplybook_register_debug.log';
}

function debugLog($event, $context = [])
{
	global $requestId;

	$entry = [
		'time' => date('c'),
		'request_id' => $requestId,
		'event' => $event,
		'context' => $context,
	];

	file_put_contents(debugLogPath(), json_encode($entry, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND | LOCK_EX);
}

function redactedParams($method, $params)
{
	if ($method === 'getUserToken') {
		return [$params[0] ?? '', $params[1] ?? '', '[redacted]'];
	}

	if ($method === 'changeClientPassword') {
		return [$params[0] ?? '', '[redacted]', $params[2] ?? null];
	}

	return $params;
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

function envValue($name)
{
	$value = getenv($name);

	return is_string($value) ? trim($value) : '';
}

function jsonResponse($data, $statusCode = 200)
{
	global $requestId;

	while (ob_get_level() > 0) {
		ob_end_clean();
	}

	if ($statusCode >= 400) {
		$data['request_id'] = $requestId;
		$data['log_file'] = debugLogPath();
	}

	http_response_code($statusCode);
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	exit;
}

function jsonRpcCall($url, $method, $params = [], $headers = [])
{
	debugLog('simplybook_request', [
		'url' => $url,
		'method' => $method,
		'params' => redactedParams($method, $params),
	]);

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

	debugLog('simplybook_response', [
		'method' => $method,
		'http_status' => $statusCode,
		'curl_error' => $error,
		'body' => is_string($response) ? substr($response, 0, 1000) : '[no response]',
	]);

	if ($response === false) {
		throw new RuntimeException('SimplyBook request failed: ' . $error);
	}

	$decoded = json_decode($response, true);

	if (!is_array($decoded)) {
		throw new RuntimeException('SimplyBook returned invalid JSON.');
	}

	if (isset($decoded['error'])) {
		$message = is_array($decoded['error']) ? ($decoded['error']['message'] ?? 'Unknown API error') : (string) $decoded['error'];

		if ($method === 'getUserToken') {
			throw new RuntimeException('SimplyBook admin login failed: ' . $message . '. Check SIMPLYBOOK_ADMIN_LOGIN and SIMPLYBOOK_ADMIN_KEY. Use an API User Key if the admin account has 2FA or IP verification.');
		}

		throw new RuntimeException($message);
	}

	if ($statusCode >= 400) {
		throw new RuntimeException('SimplyBook HTTP error: ' . $statusCode);
	}

	return $decoded['result'] ?? null;
}

try {
	loadDotEnv(dirname(__DIR__) . '/.env');
	debugLog('register_start', ['method' => $_SERVER['REQUEST_METHOD'] ?? 'GET']);

	if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
		jsonResponse(['error' => 'Invalid request method.'], 405);
	}

	if (!function_exists('curl_init')) {
		jsonResponse(['error' => 'PHP cURL extension is not enabled. SimplyBook requests need cURL.'], 500);
	}

	$name = trim((string) ($_POST['name'] ?? ''));
	$phone = trim((string) ($_POST['phone'] ?? ''));
	$email = trim((string) ($_POST['email'] ?? ''));
	$password = (string) ($_POST['password'] ?? '');
	debugLog('register_input', [
		'name_present' => $name !== '',
		'phone_present' => $phone !== '',
		'email_hash' => $email === '' ? '' : hash('sha256', strtolower($email)),
		'password_length' => strlen($password),
	]);

	if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
		jsonResponse(['error' => 'Bitte Name, gueltige E-Mail und ein Passwort mit mindestens 6 Zeichen eingeben.'], 400);
	}

	$companyLogin = envValue('SIMPLYBOOK_COMPANY_LOGIN');
	$adminLogin = envValue('SIMPLYBOOK_ADMIN_LOGIN');
	$adminKey = envValue('SIMPLYBOOK_ADMIN_KEY');

	if ($companyLogin === '' || $adminLogin === '' || $adminKey === '') {
		jsonResponse(['error' => 'SimplyBook admin credentials are missing.'], 500);
	}

	$userToken = jsonRpcCall(SIMPLYBOOK_API_URL . '/login', 'getUserToken', [$companyLogin, $adminLogin, $adminKey]);
	$authHeaders = ['X-Company-Login: ' . $companyLogin, 'X-User-Token: ' . $userToken];
	$clientData = ['name' => $name, 'email' => $email];

	if ($phone !== '') {
		$clientData['phone'] = $phone;
	}

	$clientId = jsonRpcCall(SIMPLYBOOK_API_URL . '/admin/', 'addClient', [$clientData, true], $authHeaders);
	jsonRpcCall(SIMPLYBOOK_API_URL . '/admin/', 'changeClientPassword', [(int) $clientId, $password, false], $authHeaders);
	debugLog('register_success', ['client_id' => (string) $clientId]);

	jsonResponse([
		'client' => [
			'id' => (string) $clientId,
			'name' => $name,
			'email' => $email,
			'phone' => $phone,
		],
	]);
} catch (Throwable $exception) {
	debugLog('register_exception', ['message' => $exception->getMessage(), 'type' => get_class($exception)]);
	jsonResponse(['error' => $exception->getMessage()], 500);
}
