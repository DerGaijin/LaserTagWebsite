<?php

require_once __DIR__ . '/Shared.php';

registerJsonFatalHandler();
requirePostRequest();
startReservationSession();
unset(
	$_SESSION['simplybook_client_token'],
	$_SESSION['simplybook_company_login'],
	$_SESSION['simplybook_client_id']
);

jsonResponse(['ok' => true]);
