<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('html_errors', '0');
require __DIR__ . '/Shared.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respond(405, ['error' => 'Method not allowed.']);
    }

    $serviceId = filter_input(INPUT_POST, 'serviceId', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $count = filter_input(INPUT_POST, 'count', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 100]]);
    $date = (string) ($_POST['date'] ?? '');
    $time = (string) ($_POST['time'] ?? '');
    $clientId = trim((string) ($_POST['clientId'] ?? ''));
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $phone = trim((string) ($_POST['phone'] ?? ''));
    $dateTime = DateTimeImmutable::createFromFormat('!Y-m-d', $date);
    if (!is_int($serviceId) || !is_int($count) || !$dateTime || $dateTime->format('Y-m-d') !== $date || $dateTime < new DateTimeImmutable('today') || !preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $time) || $clientId === '' || $name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        respond(400, ['error' => 'Bitte prüft Angebot, Termin und Kundendaten.']);
    }

    $client = ['id' => $clientId, 'name' => $name, 'email' => $email];
    if ($phone !== '') {
        $client['phone'] = $phone;
    }
    simplyBookRequest(SIMPLYBOOK_API_URL, 'book', [$serviceId, SIMPLYBOOK_UNIT_ID, $date, $time, $client, [], $count], simplyBookHeaders());
    respond(201, ['success' => true]);
} catch (Throwable $exception) {
    error_log('SimplyBook booking endpoint: ' . $exception->getMessage());
    respond(502, ['error' => 'Die Buchung konnte nicht abgeschlossen werden. Bitte prüft die Verfügbarkeit und versucht es erneut.']);
}
