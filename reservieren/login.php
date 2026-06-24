<?php

require_once __DIR__ . '/shared.php';

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

	$token = getSimplyBookToken($companyLogin, $apiKey);
	$authHeaders = ['X-Company-Login: ' . $companyLogin, 'X-Token: ' . $token];
	$client = jsonRpcCall(SIMPLYBOOK_API_URL, 'getClientInfoByLoginPassword', [$email, $password], $authHeaders);
	$clientData = publicClientData($client);

	if ($clientData === [] || $clientData['id'] === '') {
		jsonResponse(['error' => 'E-Mail oder Passwort ist nicht korrekt.'], 401);
	}

	jsonResponse(['client' => $clientData]);
} catch (Throwable $exception) {
	jsonResponse(['error' => 'E-Mail oder Passwort ist nicht korrekt.'], 401);
}
