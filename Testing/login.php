<?php
ob_start();

register_shutdown_function(function (): void {
    $error = error_get_last();
    $fatalErrors = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR];
    if ($error === null || !in_array($error['type'], $fatalErrors, true)) {
        return;
    }

    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => 'PHP error: ' . $error['message']]);
});

require_once __DIR__ . '/Shared.php';

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Content-Type: application/json; charset=utf-8');

try {
    $startedAt = microtime(true);
    loadTestingEnv();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        throw new RuntimeException('POST requests are required.');
    }
    if (!function_exists('curl_init')) {
        throw new RuntimeException('PHP cURL extension is not enabled.');
    }

    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        http_response_code(400);
        throw new RuntimeException('A valid email address and password are required.');
    }

    $companyLogin = testingEnvValue('SIMPLYBOOK_COMPANY_LOGIN');
    $apiKey = testingEnvValue('SIMPLYBOOK_API_KEY');
    if ($companyLogin === '' || $apiKey === '') {
        throw new RuntimeException('SimplyBook credentials are missing.');
    }

    $token = (string) simplyBookTestingCall(SIMPLYBOOK_API_URL . '/login', 'getToken', [$companyLogin, $apiKey]);
    $client = simplyBookTestingCall(SIMPLYBOOK_API_URL, 'getClientInfoByLoginPassword', [$email, $password], [
        'X-Company-Login: ' . $companyLogin,
        'X-Token: ' . $token,
    ]);
    if (!is_array($client) || empty($client['id'])) {
        http_response_code(401);
        throw new RuntimeException('The email address or password is incorrect.');
    }

    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    echo json_encode([
        'client' => [
            'id' => (string) $client['id'],
            'name' => (string) ($client['name'] ?? ''),
            'email' => (string) ($client['email'] ?? $client['login'] ?? ''),
            'phone' => (string) ($client['phone'] ?? ''),
        ],
        'apiCallTimeMs' => round((microtime(true) - $startedAt) * 1000, 1),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
} catch (Throwable $exception) {
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    if (http_response_code() < 400) {
        http_response_code(500);
    }
    echo json_encode(['error' => $exception->getMessage()], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
