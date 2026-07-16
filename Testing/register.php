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

    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $phone = trim((string) ($_POST['phone'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        http_response_code(400);
        throw new RuntimeException('A name, valid email address, and password with at least 6 characters are required.');
    }

    $companyLogin = testingEnvValue('SIMPLYBOOK_COMPANY_LOGIN');
    $adminLogin = testingEnvValue('SIMPLYBOOK_ADMIN_LOGIN');
    $adminKey = testingEnvValue('SIMPLYBOOK_ADMIN_KEY');
    if ($companyLogin === '' || $adminLogin === '' || $adminKey === '') {
        throw new RuntimeException('SimplyBook admin credentials are missing.');
    }

    $userToken = (string) simplyBookTestingCall(SIMPLYBOOK_API_URL . '/login', 'getUserToken', [$companyLogin, $adminLogin, $adminKey]);
    $clientData = ['name' => $name, 'email' => $email];
    if ($phone !== '') {
        $clientData['phone'] = $phone;
    }

    $headers = [
        'X-Company-Login: ' . $companyLogin,
        'X-User-Token: ' . $userToken,
    ];
    $clientId = simplyBookTestingCall(SIMPLYBOOK_API_URL . '/admin/', 'addClient', [$clientData, true], $headers);
    simplyBookTestingCall(SIMPLYBOOK_API_URL . '/admin/', 'changeClientPassword', [(int) $clientId, $password, false], $headers);

    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    echo json_encode([
        'client' => [
            'id' => (string) $clientId,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
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
