<?php

require_once __DIR__ . '/shared.php';

const SIMPLYBOOK_AVAILABILITY_CACHE_SECONDS = 60;

$apiCallResults = [];

registerJsonFatalHandler();

setSimplyBookRpcLogger(function ($event, $url, $method, $params, $response) {
	global $apiCallResults;

	if ($event !== 'response' || !is_string($response)) {
		return;
	}

	$decoded = json_decode($response, true);
	if (!is_array($decoded) || isset($decoded['error'])) {
		return;
	}

	$apiCallResults[] = [
		'method' => $method,
		'params' => $params,
		'result' => $method === 'getToken' ? '[redacted]' : ($decoded['result'] ?? null),
	];
});

function availabilityCachePath($offerId, $date, $count)
{
	$key = md5($offerId . '|' . $date . '|' . $count . '|' . SIMPLYBOOK_UNIT_ID);

	return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'simplybook_availability_' . $key . '.json';
}

function availabilityLockPath($offerId, $date, $count)
{
	return availabilityCachePath($offerId, $date, $count) . '.lock';
}

function readCachedAvailability($offerId, $date, $count)
{
	$path = availabilityCachePath($offerId, $date, $count);

	if (!is_readable($path)) {
		return null;
	}

	$data = json_decode((string) file_get_contents($path), true);

	if (!is_array($data) || empty($data['expires_at']) || time() >= (int) $data['expires_at'] || !isset($data['dates'])) {
		return null;
	}

	return $data['dates'];
}

function writeCachedAvailability($offerId, $date, $count, $dates)
{
	$data = json_encode([
		'expires_at' => time() + SIMPLYBOOK_AVAILABILITY_CACHE_SECONDS,
		'dates' => $dates,
	]);

	if ($data !== false) {
		file_put_contents(availabilityCachePath($offerId, $date, $count), $data, LOCK_EX);
	}
}

function acquireAvailabilityLock($offerId, $date, $count)
{
	$lock = fopen(availabilityLockPath($offerId, $date, $count), 'c');

	if ($lock === false) {
		return null;
	}

	if (flock($lock, LOCK_EX | LOCK_NB)) {
		return $lock;
	}

	fclose($lock);

	return null;
}

function releaseAvailabilityLock($lock)
{
	if ($lock !== null) {
		flock($lock, LOCK_UN);
		fclose($lock);
	}
}

function waitForCachedAvailability($offerId, $date, $count)
{
	$deadline = microtime(true) + 8;

	while (microtime(true) < $deadline) {
		usleep(100000);
		$cachedDates = readCachedAvailability($offerId, $date, $count);

		if ($cachedDates !== null) {
			return $cachedDates;
		}
	}

	return null;
}

function timesFromMatrix($matrix, $date)
{
	$times = [];

	if (!is_array($matrix) || !isset($matrix[$date]) || !is_array($matrix[$date])) {
		return $times;
	}

	foreach ($matrix[$date] as $time) {
		$times[(string) $time] = true;
	}

	return $times;
}

try {
	set_time_limit(90);
	loadReservationEnv();

	$offerId = (string) ($_GET['offer_id'] ?? '6');
	$date = (string) ($_GET['date'] ?? date('Y-m-d'));
	$count = max(1, (int) ($_GET['count'] ?? 1));

	if (!in_array($offerId, validOfferIds(), true) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
		jsonResponse(['error' => 'Invalid availability request.'], 400);
	}

	[$companyLogin, $apiKey] = simplyBookCredentials();
	requireCurlExtension();

	$cachedDates = readCachedAvailability($offerId, $date, $count);

	if ($cachedDates !== null) {
		jsonResponse(['dates' => $cachedDates, 'apiCalls' => [], 'cached' => true]);
	}

	$availabilityLock = acquireAvailabilityLock($offerId, $date, $count);

	if ($availabilityLock === null) {
		$cachedDates = waitForCachedAvailability($offerId, $date, $count);

		if ($cachedDates !== null) {
			jsonResponse(['dates' => $cachedDates, 'apiCalls' => [], 'cached' => true]);
		}
	} else {
		$cachedDates = readCachedAvailability($offerId, $date, $count);

		if ($cachedDates !== null) {
			releaseAvailabilityLock($availabilityLock);
			jsonResponse(['dates' => $cachedDates, 'apiCalls' => [], 'cached' => true]);
		}
	}

	// Keep getStartTimeMatrix fast by asking SimplyBook for one selected day only.
	$dateFrom = $date;
	$dateTo = $date;

	$token = getSimplyBookToken($companyLogin, $apiKey);
	$authHeaders = ['X-Company-Login: ' . $companyLogin, 'X-Token: ' . $token];
	$matrix = jsonRpcCall(SIMPLYBOOK_API_URL, 'getStartTimeMatrix', [$dateFrom, $dateTo, $offerId, SIMPLYBOOK_UNIT_ID, $count], $authHeaders);
	$availableTimes = timesFromMatrix($matrix, $date);
	$timesByDate = [$date => []];

	ksort($availableTimes);

	foreach (array_keys($availableTimes) as $time) {
		$timesByDate[$date][] = [
			'time' => $time,
			'count' => $count,
		];
	}

	writeCachedAvailability($offerId, $date, $count, $timesByDate);
	releaseAvailabilityLock($availabilityLock);

	jsonResponse(['dates' => $timesByDate, 'apiCalls' => $apiCallResults, 'cached' => false]);
} catch (Throwable $exception) {
	if (isset($availabilityLock)) {
		releaseAvailabilityLock($availabilityLock);
	}

	jsonResponse(['error' => $exception->getMessage()], 500);
}
