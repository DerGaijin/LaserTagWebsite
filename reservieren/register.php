<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('html_errors', '0');
require __DIR__ . '/Shared.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respond(405, ['error' => 'Method not allowed.']);
    }

    $name = trim((string) ($_POST['name'] ?? ''));
    $phone = trim((string) ($_POST['phone'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        respond(400, ['error' => 'Bitte Name, gültige E-Mail und ein Passwort mit mindestens 6 Zeichen eingeben.']);
    }

    $clientData = ['name' => $name, 'email' => $email];
    if ($phone !== '') {
        $clientData['phone'] = $phone;
    }
    $headers = simplyBookAdminHeaders();
    $clientId = simplyBookRequest(SIMPLYBOOK_API_URL . '/admin/', 'addClient', [$clientData, true], $headers)['result'] ?? null;
    if (!is_int($clientId) && !ctype_digit((string) $clientId)) {
        throw new RuntimeException('SimplyBook did not return a customer ID.');
    }
    simplyBookRequest(SIMPLYBOOK_API_URL . '/admin/', 'changeClientPassword', [(int) $clientId, $password, false], $headers);

    respond(201, ['client' => ['id' => (string) $clientId, 'name' => $name, 'email' => $email, 'phone' => $phone]]);
} catch (Throwable $exception) {
    error_log('SimplyBook register endpoint: ' . $exception->getMessage());
    respond(502, ['error' => 'Das Konto konnte momentan nicht erstellt werden. Bitte versucht es später erneut.']);
}
