<?php

require_once __DIR__ . '/Shared.php';

const SIMPLYBOOK_AVAILABILITY_CACHE_SECONDS = 60;

$apiCallResults = [];

registerJsonFatalHandler();

setSimplyBookApiLogger(function ($event, $url, $method, $params, $response) {
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
		'result' => strpos($url, '/auth/token') !== false ? '[redacted]' : $decoded,
	];
});

function availabilityCachePath($offerId, $date, $count)
{
	$key = md5($offerId . '|' . $date . '|' . $count . '|' . SIMPLYBOOK_UNIT_ID);

	return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'simplybook_v2_availability_' . $key . '.json';
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

function timesFromResponse($response)
{
	$times = [];
	$slots = is_array($response) ? ($response['data'] ?? $response['slots'] ?? $response['times'] ?? $response['available_times'] ?? $response) : [];
	$collect = function ($value, $key = null) use (&$times, &$collect) {
		if (is_string($value) && preg_match('/(?:^|T|\s)(\d{1,2}):(\d{2})(?::(\d{2}))?/', $value, $match)) {
			$times[sprintf('%02d:%s%s', (int) $match[1], $match[2], isset($match[3]) ? ':' . $match[3] : '')] = true;
			return;
		}
		if (!is_array($value)) {
			return;
		}
		$time = $value['time'] ?? $value['start_time'] ?? $value['start'] ?? $value['from'] ?? null;
		if (is_string($time) && preg_match('/(?:^|T|\s)(\d{1,2}):(\d{2})(?::(\d{2}))?/', $time, $match)) {
			$times[sprintf('%02d:%s%s', (int) $match[1], $match[2], isset($match[3]) ? ':' . $match[3] : '')] = true;
			return;
		}
		if (is_string($key) && preg_match('/^(\d{1,2}:\d{2}(?::\d{2})?)/', $key, $match)) {
			$times[$match[1]] = true;
		}
		foreach ($value as $childKey => $child) {
			$collect($child, $childKey);
		}
	};
	$collect($slots);

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

	$auth = getSimplyBookAuth($companyLogin, $apiKey);
	$authHeaders = ['X-Company-Login: ' . $auth['company_login'], 'X-Token: ' . $auth['token']];
	$response = simplyBookApiCall('/timeline/slots', 'GET', $authHeaders, null, [
		'service_id' => $offerId,
		'provider_id' => SIMPLYBOOK_UNIT_ID,
		'from' => $date,
		'to' => $date,
		'count' => $count,
	]);
	$availableTimes = timesFromResponse($response);
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
