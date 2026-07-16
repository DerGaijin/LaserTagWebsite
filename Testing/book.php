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

    $serviceId = trim((string) ($_POST['service_id'] ?? ''));
    $unitId = trim((string) ($_POST['unit_id'] ?? ''));
    $dateInput = trim((string) ($_POST['date'] ?? ''));
    $time = trim((string) ($_POST['time'] ?? ''));
    $personCount = trim((string) ($_POST['person_count'] ?? '1'));
    $clientId = trim((string) ($_POST['client_id'] ?? ''));
    $dateValue = DateTimeImmutable::createFromFormat('!d.m.Y', $dateInput);

    if ($serviceId === '' || !ctype_digit($serviceId) || $unitId === '' || !ctype_digit($unitId) || $personCount === '' || !ctype_digit($personCount) || (int) $personCount < 1 || $clientId === '' || !ctype_digit($clientId) || $dateValue === false || $dateValue->format('d.m.Y') !== $dateInput || !preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $time)) {
        http_response_code(400);
        throw new RuntimeException('A service ID, unit ID, valid date and time, person count, and existing client ID are required.');
    }
    if (strlen($time) === 5) {
        $time .= ':00';
    }

    $companyLogin = testingEnvValue('SIMPLYBOOK_COMPANY_LOGIN');
    $adminLogin = testingEnvValue('SIMPLYBOOK_ADMIN_LOGIN');
    $adminPassword = testingEnvValue('SIMPLYBOOK_ADMIN_PASSWORD');
    if ($companyLogin === '' || $adminLogin === '' || $adminPassword === '') {
        throw new RuntimeException('SimplyBook admin login or password is missing.');
    }

    try {
        $userToken = (string) simplyBookTestingCall(SIMPLYBOOK_API_URL . '/login', 'getUserToken', [$companyLogin, $adminLogin, $adminPassword]);
    } catch (Throwable $exception) {
        throw new RuntimeException('SimplyBook admin authentication failed: ' . $exception->getMessage());
    }
    $headers = [
        'X-Company-Login: ' . $companyLogin,
        'X-User-Token: ' . $userToken,
    ];
    $startDate = $dateValue->format('Y-m-d');
    try {
        $endDateTime = simplyBookTestingCall(SIMPLYBOOK_API_URL . '/admin/', 'calculateEndTime', [$startDate . ' ' . $time, (int) $serviceId, (int) $unitId], $headers);
    } catch (Throwable $exception) {
        throw new RuntimeException('SimplyBook end-time calculation failed: ' . $exception->getMessage());
    }
    $endValue = is_string($endDateTime) ? DateTimeImmutable::createFromFormat('!Y-m-d H:i:s', $endDateTime) : false;
    if ($endValue === false) {
        throw new RuntimeException('SimplyBook returned an invalid booking end time.');
    }
    try {
        $booking = simplyBookTestingCall(SIMPLYBOOK_API_URL . '/admin/', 'book', [
            (int) $serviceId,
            (int) $unitId,
            (int) $clientId,
            $startDate,
            $time,
            $endValue->format('Y-m-d'),
            $endValue->format('H:i:s'),
            0,
            [],
            (int) $personCount,
        ], $headers);
    } catch (Throwable $exception) {
        throw new RuntimeException('SimplyBook booking creation failed: ' . $exception->getMessage());
    }

    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    echo json_encode([
        'booking' => $booking,
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
