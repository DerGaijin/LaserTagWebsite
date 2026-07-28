<?php

require_once __DIR__ . '/Shared.php';

registerJsonFatalHandler();

try {
	loadReservationEnv();
	requirePostRequest();
	requireCurlExtension();

	$email = trim((string) ($_POST['email'] ?? ''));
	$password = (string) ($_POST['password'] ?? '');

	if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
		jsonResponse(['error' => 'Bitte E-Mail und Passwort eingeben.'], 400);
	}

	[$companyLogin, $apiKey] = simplyBookCredentials();

	$auth = getSimplyBookAuth($companyLogin, $apiKey);
	$authHeaders = ['X-Company-Login: ' . $auth['company_login'], 'X-Token: ' . $auth['token']];
	$loginResponse = simplyBookApiCall('/clients/login', 'POST', $authHeaders, [
		'login' => $email,
		'password' => $password,
		'remember' => false,
	]);
	storeSimplyBookClientSession($auth['company_login'], $loginResponse);
	$client = simplyBookExtractClient($loginResponse);
	$clientData = publicClientData($client);
	$clientData['email'] = $clientData['email'] !== '' ? $clientData['email'] : $email;

	if ($clientData === [] || $clientData['id'] === '') {
		jsonResponse(['error' => 'E-Mail oder Passwort ist nicht korrekt.'], 401);
	}

	jsonResponse(['client' => $clientData]);
} catch (Throwable $exception) {
	jsonResponse(['error' => 'E-Mail oder Passwort ist nicht korrekt.'], 401);
}
