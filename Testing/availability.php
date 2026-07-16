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

    $serviceId = trim((string) ($_GET['service_id'] ?? ''));
    $dateInput = trim((string) ($_GET['date'] ?? ''));
    $personCount = trim((string) ($_GET['person_count'] ?? '1'));
    $dateValue = DateTimeImmutable::createFromFormat('!d.m.Y', $dateInput);
    if ($serviceId === '' || !ctype_digit($serviceId) || $personCount === '' || !ctype_digit($personCount) || (int) $personCount < 1 || $dateValue === false || $dateValue->format('d.m.Y') !== $dateInput) {
        http_response_code(400);
        throw new RuntimeException('A numeric service ID, person count of at least 1, and a valid date in DD.MM.YYYY format are required.');
    }
    $date = $dateValue->format('Y-m-d');

    $companyLogin = testingEnvValue('SIMPLYBOOK_COMPANY_LOGIN');
    $apiKey = testingEnvValue('SIMPLYBOOK_API_KEY');
    if ($companyLogin === '' || $apiKey === '') {
        throw new RuntimeException('SimplyBook credentials are missing.');
    }

    $token = (string) simplyBookTestingCall(SIMPLYBOOK_API_URL . '/login', 'getToken', [$companyLogin, $apiKey]);
    $matrix = simplyBookTestingCall(SIMPLYBOOK_API_URL, 'getStartTimeMatrix', [$date, $date, $serviceId, 1, (int) $personCount], [
        'X-Company-Login: ' . $companyLogin,
        'X-Token: ' . $token,
    ]);
    $times = is_array($matrix) && isset($matrix[$date]) && is_array($matrix[$date]) ? array_values(array_unique($matrix[$date])) : [];
    sort($times);

    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    echo json_encode([
        'times' => $times,
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
