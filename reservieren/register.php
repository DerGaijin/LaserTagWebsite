<?php

require_once __DIR__ . '/Shared.php';

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

setJsonErrorContextCallback(function () use ($requestId) {
	return ['request_id' => $requestId, 'log_file' => debugLogPath()];
});

setSimplyBookApiLogger(function ($event, $url, $method, $params, $response, $statusCode, $error) {
	if ($event === 'request') {
		debugLog('simplybook_request', [
			'url' => $url,
			'method' => $method,
			'has_payload' => $params !== null,
		]);
		return;
	}

	debugLog('simplybook_response', [
		'method' => $method,
		'http_status' => $statusCode,
		'curl_error' => $error,
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

	if ($name === '' || $phone === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
		jsonResponse(['error' => 'Bitte Name, Telefon, gültige E-Mail und ein Passwort mit mindestens 6 Zeichen eingeben.'], 400);
	}

	[$companyLogin, $apiKey] = simplyBookCredentials();
	$auth = getSimplyBookAuth($companyLogin, $apiKey);
	$authHeaders = ['X-Company-Login: ' . $auth['company_login'], 'X-Token: ' . $auth['token']];
	simplyBookApiCall('/clients/register', 'POST', $authHeaders, [
		'name' => $name,
		'phone' => $phone,
		'login' => $email,
		'email' => $email,
		'password' => $password,
		'terms' => ['user_terms' => 1],
	]);
	$loginResponse = simplyBookApiCall('/clients/login', 'POST', $authHeaders, [
		'login' => $email,
		'password' => $password,
		'remember' => false,
	]);
	storeSimplyBookClientSession($auth['company_login'], $loginResponse);
	$client = simplyBookExtractClient($loginResponse);
	$clientId = (string) ($client['id'] ?? $client['client_id'] ?? '');
	if ($clientId === '') {
		throw new RuntimeException('SimplyBook login did not return a client ID.');
	}
	debugLog('register_success', ['client_id' => $clientId]);

	jsonResponse([
		'client' => [
			'id' => $clientId,
			'name' => $name,
			'email' => $email,
			'phone' => $phone,
		],
	]);
} catch (Throwable $exception) {
	debugLog('register_exception', ['message' => $exception->getMessage(), 'type' => get_class($exception)]);
	jsonResponse(['error' => $exception->getMessage()], 500);
}
