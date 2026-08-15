<?php

require_once __DIR__ . '/Shared.php';

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
		jsonResponse(['error' => 'Bitte Angebot, Datum und Startzeit auswählen.'], 400);
	}

	$minimumParticipants = minimumParticipantsForOffer($offerId);
	if ($count < $minimumParticipants) {
		jsonResponse(['error' => 'Dieses Geburtstagspaket ist ab ' . $minimumParticipants . ' Personen buchbar.'], 400);
	}

	if ($clientId === '' || $name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		jsonResponse(['error' => 'Bitte zuerst mit einem gültigen Kundenkonto einloggen oder registrieren.'], 400);
	}

	[$companyLogin] = simplyBookCredentials();
	startReservationSession();
	$sessionClientId = (string) ($_SESSION['simplybook_client_id'] ?? '');
	$clientToken = (string) ($_SESSION['simplybook_client_token'] ?? '');
	$clientCompanyLogin = (string) ($_SESSION['simplybook_company_login'] ?? $companyLogin);
	if ($sessionClientId === '' || $clientToken === '' || !hash_equals($sessionClientId, $clientId)) {
		jsonResponse(['error' => 'Die Anmeldung ist abgelaufen. Bitte erneut einloggen.'], 401);
	}

	$clientData = [
		'id' => $clientId,
		'name' => $name,
		'email' => $email,
	];

	if ($phone !== '') {
		$clientData['phone'] = $phone;
	}

	$result = simplyBookApiCall('/booking/item', 'POST', [
		'X-Company-Login: ' . $clientCompanyLogin,
		'X-Token: ' . $clientToken,
	], [
		'service_id' => (int) $offerId,
		'provider_id' => SIMPLYBOOK_UNIT_ID,
		'start_datetime' => $date . ' ' . (strlen($time) === 5 ? $time . ':00' : $time),
		'count' => $count,
		'client_id' => (int) $clientId,
		'client' => $clientData,
		'additional_fields' => [],
		'terms' => [
			'simplybook_terms' => true,
			'user_terms' => true,
			'cancellation_terms' => true,
			'privacy_policy' => true,
		],
	]);

	jsonResponse(['booking' => $result]);
} catch (Throwable $exception) {
	jsonResponse(['error' => $exception->getMessage()], 500);
}
