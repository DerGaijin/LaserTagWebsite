<?php

require_once __DIR__ . '/shared.php';

registerJsonFatalHandler();

try {
	loadReservationEnv();
	requirePostRequest();
	requireCurlExtension();

	$offerId = (string) ($_POST['offer_id'] ?? '');
	$date = (string) ($_POST['start_date'] ?? '');
	$time = (string) ($_POST['start_time'] ?? '');
	$count = max(1, (int) ($_POST['count'] ?? 1));
	$clientId = trim((string) ($_POST['client_id'] ?? ''));
	$name = trim((string) ($_POST['client_name'] ?? ''));
	$email = trim((string) ($_POST['client_email'] ?? ''));
	$phone = trim((string) ($_POST['client_phone'] ?? ''));

	if (!in_array($offerId, validOfferIds(), true) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || !preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $time)) {
		jsonResponse(['error' => 'Bitte Angebot, Datum und Startzeit auswaehlen.'], 400);
	}

	if ($clientId === '' || $name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		jsonResponse(['error' => 'Bitte zuerst mit einem gueltigen Kundenkonto einloggen oder registrieren.'], 400);
	}

	[$companyLogin, $apiKey] = simplyBookCredentials();

	$clientData = [
		'id' => $clientId,
		'name' => $name,
		'email' => $email,
	];

	if ($phone !== '') {
		$clientData['phone'] = $phone;
	}

	$token = getSimplyBookToken($companyLogin, $apiKey);
	$authHeaders = ['X-Company-Login: ' . $companyLogin, 'X-Token: ' . $token];
	$result = jsonRpcCall(SIMPLYBOOK_API_URL, 'book', [$offerId, SIMPLYBOOK_UNIT_ID, $date, $time, $clientData, [], $count], $authHeaders);

	jsonResponse(['booking' => $result]);
} catch (Throwable $exception) {
	jsonResponse(['error' => $exception->getMessage()], 500);
}
