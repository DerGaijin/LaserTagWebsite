<?php

require_once __DIR__ . '/Shared.php';

registerJsonFatalHandler();

try {
	loadReservationEnv();
	requirePostRequest();
	requireCurlExtension();

	$email = trim((string) ($_POST['email'] ?? ''));
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		jsonResponse(['error' => 'Bitte eine gültige E-Mail-Adresse eingeben.'], 400);
	}

	[$companyLogin, $apiKey] = simplyBookCredentials();
	$auth = getSimplyBookAuth($companyLogin, $apiKey);
	simplyBookApiCall('/clients/remind-password', 'POST', [
		'X-Company-Login: ' . $auth['company_login'],
		'X-Token: ' . $auth['token'],
	], ['email' => $email]);

	jsonResponse(['message' => 'Falls ein Konto zu dieser E-Mail-Adresse existiert, wurde eine E-Mail zum Zurücksetzen des Passworts gesendet.']);
} catch (Throwable $exception) {
	// Keep the response identical when SimplyBook does not know the address.
	jsonResponse(['message' => 'Falls ein Konto zu dieser E-Mail-Adresse existiert, wurde eine E-Mail zum Zurücksetzen des Passworts gesendet.']);
}
