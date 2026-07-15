<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('html_errors', '0');
error_reporting(E_ALL);
require __DIR__ . '/Shared.php';

function availableTimes(mixed $value): array
{
    if (!is_array($value)) {
        return [];
    }
    $times = [];
    foreach ($value as $key => $item) {
        if (is_string($key) && preg_match('/^([01]\d|2[0-3]):[0-5]\d/', $key, $match)) {
            $times[] = $match[0];
        } elseif (is_string($item) && preg_match('/^([01]\d|2[0-3]):[0-5]\d/', $item, $match)) {
            $times[] = $match[0];
        }
    }

    $times = array_values(array_unique($times));
    sort($times);
    return $times;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        respond(405, ['error' => 'Method not allowed.']);
    }
    $serviceId = filter_input(INPUT_GET, 'serviceId', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $count = filter_input(INPUT_GET, 'count', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 100]]);
    $date = $_GET['date'] ?? '';
    $dateTime = is_string($date) ? DateTimeImmutable::createFromFormat('!Y-m-d', $date) : false;
    if (!is_int($serviceId) || !is_int($count) || !$dateTime || $dateTime->format('Y-m-d') !== $date) {
        respond(400, ['error' => 'Ungültige Verfügbarkeitsanfrage.']);
    }

    $result = simplyBookRequest(SIMPLYBOOK_API_URL, 'getStartTimeMatrix', [$date, $date, $serviceId, null, $count], simplyBookHeaders())['result'] ?? [];
    $day = is_array($result) ? ($result[$date] ?? $result) : [];
    respond(200, ['times' => availableTimes($day)]);
} catch (Throwable $exception) {
    error_log('SimplyBook availability endpoint: ' . $exception->getMessage());
    respond(502, ['error' => 'Die Verfügbarkeit konnte momentan nicht geladen werden. Bitte versucht es später erneut.']);
}
