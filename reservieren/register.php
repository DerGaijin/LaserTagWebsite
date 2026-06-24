<?php

require_once __DIR__ . '/shared.php';

$requestId = uniqid('register_', true);

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

setJsonErrorContextCallback(function () use ($requestId) {
	return ['request_id' => $requestId, 'log_file' => debugLogPath()];
});

setSimplyBookRpcLogger(function ($event, $url, $method, $params, $response, $statusCode, $error) {
	if ($event === 'request') {
		debugLog('simplybook_request', [
			'url' => $url,
			'method' => $method,
			'params' => redactedParams($method, $params),
		]);
		return;
	}

	debugLog('simplybook_response', [
		'method' => $method,
		'http_status' => $statusCode,
		'curl_error' => $error,
		'body' => is_string($response) ? substr($response, 0, 1000) : '[no response]',
	]);
});

registerJsonFatalHandler(function ($error) {
	debugLog('fatal_php_error', ['message' => $error['message'], 'file' => $error['file'] ?? '', 'line' => $error['line'] ?? '']);
});

try {
	loadReservationEnv();
	debugLog('register_start', ['method' => $_SERVER['REQUEST_METHOD'] ?? 'GET']);

	requirePostRequest();
	requireCurlExtension();

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

	try {
		$userToken = jsonRpcCall(SIMPLYBOOK_API_URL . '/login', 'getUserToken', [$companyLogin, $adminLogin, $adminKey]);
	} catch (RuntimeException $exception) {
		throw new RuntimeException('SimplyBook admin login failed: ' . $exception->getMessage() . '. Check SIMPLYBOOK_ADMIN_LOGIN and SIMPLYBOOK_ADMIN_KEY. Use an API User Key if the admin account has 2FA or IP verification.');
	}
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
