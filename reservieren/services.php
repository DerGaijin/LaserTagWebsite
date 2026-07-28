<?php

require_once __DIR__ . '/Shared.php';
require_once dirname(__DIR__) . '/resources/news.php';

// Values not supplied by SimplyBook, keyed by service ID.
const SERVICE_DETAILS = [
	16 => ['price' => '27,90 €', 'priceNote' => 'pro Gast', 'note' => 'Bis zu 4 Runden möglich, 2 Runden garantiert.', 'category' => 'birthday'],
	17 => ['price' => '32,90 €', 'priceNote' => 'pro Gast', 'note' => 'Bis zu 6 Runden möglich, 4 Runden garantiert.', 'category' => 'birthday', 'bestseller' => true],
	18 => ['price' => '15,00 €', 'priceNote' => 'pro Person', 'category' => 'weekend', 'label' => 'Samstag & Sonntag'],
	19 => ['price' => '27,00 €', 'priceNote' => 'pro Person', 'category' => 'weekend', 'label' => 'Samstag & Sonntag'],
	20 => ['price' => '22,00 €', 'priceNote' => 'pro Person', 'category' => 'standard'],
	21 => ['price' => '27,00 €', 'priceNote' => 'pro Person', 'category' => 'standard'],
];

const SERVICE_CATEGORIES = [
	'birthday' => ['eyebrow' => 'Feiern', 'title' => 'Geburtstagspakete', 'note' => 'Bitte seid 10 Minuten vor Beginn da.'],
	'weekend' => ['eyebrow' => 'Aktionen', 'title' => 'Flats am Wochenende'],
	'standard' => ['eyebrow' => 'Spielzeit', 'title' => 'Standardbuchungen', 'note' => 'Bitte seid 10 Minuten vor Beginn da.'],
	'other' => ['eyebrow' => 'Weitere Angebote', 'title' => 'Weitere Spielzeiten'],
];

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

registerJsonFatalHandler();

$apiCallResults = [];

setSimplyBookApiLogger(function ($event, $url, $method, $params, $response) {
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
	$activeNews = activeNewsForPage('prices');
	$discountPercent = max(array_map(static fn(array $newsItem): int => (int) ($newsItem['discountPercent'] ?? 0), $activeNews) ?: [0]);
	$services = [];

	foreach ($sourceServices as $key => $service) {
		if (!is_array($service)) {
			continue;
		}

		$rawServiceId = $service['id'] ?? $service['event_id'] ?? (is_int($key) ? '' : $key);
		$serviceId = (int) $rawServiceId;
		if (!in_array((string) $serviceId, validOfferIds(), true)) {
			continue;
		}
		$details = SERVICE_DETAILS[$serviceId] ?? [];
		$category = $details['category'] ?? 'other';
		$serviceData = array_merge([
			'id' => (string) $serviceId,
			'title' => trim((string) ($service['name'] ?? $service['title'] ?? '')),
			'duration' => formatSimplyBookServiceDuration($service['duration'] ?? ''),
			'description' => simplyBookServiceDescription($service),
			'category' => $category,
		], $details);
		if ($discountPercent > 0 && isset($serviceData['price'])) {
			$serviceData['originalPrice'] = $serviceData['price'];
			$normalizedPrice = str_replace(['€', '.', ','], ['', '', '.'], $serviceData['price']);
			$discountedPrice = round((float) trim($normalizedPrice) * (100 - $discountPercent) / 100, 2);
			$serviceData['price'] = number_format($discountedPrice, 2, ',', '.') . ' €';
			$serviceData['discountPercent'] = $discountPercent;
		}
		$services[] = $serviceData;
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
