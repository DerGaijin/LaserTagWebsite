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

    if (!function_exists('curl_init')) {
        throw new RuntimeException('PHP cURL extension is not enabled.');
    }

    $companyLogin = testingEnvValue('SIMPLYBOOK_COMPANY_LOGIN');
    $apiKey = testingEnvValue('SIMPLYBOOK_API_KEY');
    if ($companyLogin === '' || $apiKey === '') {
        throw new RuntimeException('SimplyBook credentials are missing.');
    }

    $services = getTestingServices($companyLogin, $apiKey);
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    echo json_encode([
        'services' => $services,
        'apiCallTimeMs' => round((microtime(true) - $startedAt) * 1000, 1),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
} catch (Throwable $exception) {
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    http_response_code(500);
    echo json_encode(['error' => $exception->getMessage()], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
