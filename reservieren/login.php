<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('html_errors', '0');
require __DIR__ . '/Shared.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respond(405, ['error' => 'Method not allowed.']);
    }

    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        respond(400, ['error' => 'Bitte E-Mail und Passwort eingeben.']);
    }

    $client = simplyBookRequest(SIMPLYBOOK_API_URL, 'getClientInfoByLoginPassword', [$email, $password], simplyBookHeaders())['result'] ?? null;
    if (!is_array($client) || empty($client['id'])) {
        respond(401, ['error' => 'E-Mail oder Passwort ist nicht korrekt.']);
    }

    respond(200, ['client' => [
        'id' => (string) $client['id'],
        'name' => (string) ($client['name'] ?? ''),
        'email' => (string) ($client['email'] ?? $client['login'] ?? $email),
        'phone' => (string) ($client['phone'] ?? ''),
    ]]);
} catch (Throwable $exception) {
    error_log('SimplyBook login endpoint: ' . $exception->getMessage());
    respond(401, ['error' => 'E-Mail oder Passwort ist nicht korrekt.']);
}
