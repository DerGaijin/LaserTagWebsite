<?php

require_once __DIR__ . '/shared.php';

// Values not supplied by SimplyBook, keyed by service ID.
const SERVICE_DETAILS = [
	16 => ['price' => '27,90 €', 'priceNote' => 'pro Gast', 'note' => 'Bis zu 4 Runden möglich, 2 Runden garantiert.', 'category' => 'birthday'],
	17 => ['price' => '32,90 €', 'priceNote' => 'pro Gast', 'note' => 'Bis zu 4 Runden möglich, 2 Runden garantiert.', 'category' => 'birthday'],
	18 => ['price' => '15,00 €', 'priceNote' => 'pro Person', 'category' => 'weekend', 'label' => 'Samstag & Sonntag'],
	19 => ['price' => '27,00 €', 'priceNote' => 'pro Person', 'category' => 'weekend', 'label' => 'Samstag & Sonntag'],
	20 => ['price' => '18,50 €', 'priceNote' => 'pro Person', 'category' => 'standard'],
	21 => ['price' => '36,00 €', 'priceNote' => 'pro Person', 'category' => 'standard'],
];

const SERVICE_CATEGORIES = [
	'birthday' => ['eyebrow' => 'Feiern', 'title' => 'Geburtstagspakete'],
	'weekend' => ['eyebrow' => 'Aktionen', 'title' => 'Flats am Wochenende'],
	'standard' => ['eyebrow' => 'Spielzeit', 'title' => 'Standardbuchungen'],
	'other' => ['eyebrow' => 'Weitere Angebote', 'title' => 'Weitere Spielzeiten'],
];

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

registerJsonFatalHandler();

$apiCallResults = [];

setSimplyBookRpcLogger(function ($event, $url, $method, $params, $response) {
	global $apiCallResults;

	if ($event !== 'response' || !is_string($response)) {
		return;
	}

	$decoded = json_decode($response, true);
	$apiCallResults[] = [
		'method' => $method,
		'params' => $params,
		'success' => is_array($decoded) && !isset($decoded['error']),
		'error' => is_array($decoded) && isset($decoded['error']) ? $decoded['error'] : null,
	];
});

try {
	loadReservationEnv();
	requireCurlExtension();
	[$companyLogin, $apiKey] = simplyBookCredentials();
	$cachedServices = readCachedServices($companyLogin);
	$cached = $cachedServices !== null;
	$sourceServices = $cachedServices ?? getSimplyBookServices($companyLogin, $apiKey);
	$services = [];

	foreach ($sourceServices as $service) {
		if (!is_array($service) || !isset($service['id'])) {
			continue;
		}

		$serviceId = (int) $service['id'];
		$details = SERVICE_DETAILS[$serviceId] ?? [];
		$category = $details['category'] ?? 'other';
		$services[] = array_merge([
			'id' => (string) $service['id'],
			'title' => trim((string) ($service['name'] ?? '')),
			'duration' => formatSimplyBookServiceDuration($service['duration'] ?? ''),
			'description' => simplyBookServiceDescription($service),
			'category' => $category,
		], $details);
	}

	jsonResponse([
		'services' => $services,
		'categories' => SERVICE_CATEGORIES,
		'debug' => [
			'cached' => $cached,
			'serviceCount' => count($services),
			'apiCalls' => $apiCallResults,
		],
	]);
} catch (Throwable $exception) {
	jsonResponse([
		'error' => $exception->getMessage(),
		'debug' => ['apiCalls' => $apiCallResults],
	], 500);
}
