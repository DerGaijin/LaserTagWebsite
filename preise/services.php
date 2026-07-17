<?php

ob_start();
require '../resources/news.php';

const SIMPLYBOOK_API_URL = 'https://user-api.simplybook.me';
const SIMPLYBOOK_TOKEN_CACHE_SECONDS = 3600;
const SIMPLYBOOK_SERVICE_CACHE_SECONDS = 300;

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

function serviceResponse(array $data, int $statusCode = 200): void
{
	while (ob_get_level() > 0) {
		ob_end_clean();
	}
	http_response_code($statusCode);
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	exit;
}

function serviceEnvValue(string $name): string
{
	$value = getenv($name);
	return is_string($value) ? trim($value) : '';
}

function loadServiceEnv(): void
{
	$path = dirname(__DIR__) . '/.env';
	if (!is_readable($path)) {
		return;
	}

	foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
		$line = trim($line);
		if ($line === '' || strpos($line, '#') === 0 || strpos($line, '=') === false) {
			continue;
		}
		[$name, $value] = explode('=', $line, 2);
		$name = trim($name);
		if ($name !== '' && getenv($name) === false) {
			putenv($name . '=' . trim($value, " \t\n\r\0\x0B\"'"));
		}
	}
}

function serviceCachePath(string $name, string $companyLogin): string
{
	return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'lasertag_' . $name . '_' . md5($companyLogin) . '.json';
}

function readServiceCache(string $name, string $companyLogin): ?array
{
	$path = serviceCachePath($name, $companyLogin);
	if (!is_readable($path)) {
		return null;
	}
	$data = json_decode((string) file_get_contents($path), true);
	return is_array($data) && !empty($data['expires_at']) && time() < (int) $data['expires_at'] ? $data : null;
}

function writeServiceCache(string $name, string $companyLogin, array $data, int $seconds): void
{
	$data['expires_at'] = time() + $seconds;
	$encoded = json_encode($data);
	if ($encoded !== false) {
		file_put_contents(serviceCachePath($name, $companyLogin), $encoded, LOCK_EX);
	}
}

function simplyBookCall(string $url, string $method, array $params = [], array $headers = [])
{
	$payload = json_encode(['jsonrpc' => '2.0', 'method' => $method, 'params' => $params, 'id' => uniqid('simplybook_', true)]);
	if ($payload === false) {
		throw new RuntimeException('SimplyBook request could not be created.');
	}
	$curl = curl_init($url);
	if ($curl === false) {
		throw new RuntimeException('Could not initialize SimplyBook connection.');
	}
	curl_setopt_array($curl, [
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $payload,
		CURLOPT_HTTPHEADER => array_merge(['Content-Type: application/json', 'Content-Length: ' . strlen($payload)], $headers),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 20,
	]);
	$caCertPath = serviceEnvValue('SIMPLYBOOK_CA_CERT_PATH');
	if ($caCertPath !== '') {
		curl_setopt($curl, CURLOPT_CAINFO, $caCertPath);
	} else {
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	}
	$response = curl_exec($curl);
	$statusCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
	$error = curl_error($curl);
	curl_close($curl);
	if ($response === false) {
		throw new RuntimeException('SimplyBook request failed: ' . $error);
	}
	$decoded = json_decode($response, true);
	if (!is_array($decoded)) {
		throw new RuntimeException('SimplyBook returned invalid JSON.');
	}
	if (isset($decoded['error'])) {
		$message = is_array($decoded['error']) ? ($decoded['error']['message'] ?? 'Unknown API error') : (string) $decoded['error'];
		throw new RuntimeException($message);
	}
	if ($statusCode >= 400) {
		throw new RuntimeException('SimplyBook HTTP error: ' . $statusCode);
	}
	return $decoded['result'] ?? null;
}

function serviceDuration($duration): string
{
	$duration = trim((string) $duration);
	if (!ctype_digit($duration)) {
		return $duration;
	}
	$minutes = (int) $duration;
	if ($minutes > 0 && $minutes % 60 === 0) {
		$hours = (int) ($minutes / 60);
		return $hours . ' ' . ($hours === 1 ? 'Stunde' : 'Stunden');
	}
	return $minutes > 0 ? $minutes . ' Minuten' : '';
}

function serviceDescription(array $service): string
{
	$description = strip_tags((string) ($service['description'] ?? $service['desc'] ?? ''), '<p><br><strong><b><em><i><u><ul><ol><li><h1><h2><h3><h4><h5><h6><blockquote>');
	return trim((string) preg_replace('/<(p|br|strong|b|em|i|u|ul|ol|li|h[1-6]|blockquote)\b[^>]*>/i', '<$1>', $description));
}

function serviceDiscountedPrice(string $price, int $discountPercent): string
{
	$normalized = str_replace(['€', '.', ','], ['', '', '.'], $price);
	$amount = (float) trim($normalized);
	$discountedAmount = round($amount * (100 - $discountPercent) / 100, 2);
	return number_format($discountedAmount, 2, ',', '.') . ' €';
}

try {
	if (!function_exists('curl_init')) {
		throw new RuntimeException('PHP cURL extension is not enabled.');
	}
	loadServiceEnv();
	$activeNews = activeNewsForPage('prices');
	$discountPercent = max(array_map(static fn(array $newsItem): int => (int) ($newsItem['discountPercent'] ?? 0), $activeNews) ?: [0]);
	$companyLogin = serviceEnvValue('SIMPLYBOOK_COMPANY_LOGIN');
	$apiKey = serviceEnvValue('SIMPLYBOOK_API_KEY');
	if ($companyLogin === '' || $apiKey === '') {
		throw new RuntimeException('SimplyBook credentials are missing.');
	}
	$serviceCache = readServiceCache('services', $companyLogin);
	$sourceServices = $serviceCache['services'] ?? null;
	if (!is_array($sourceServices)) {
		$tokenCache = readServiceCache('token', $companyLogin);
		$token = $tokenCache['token'] ?? '';
		if (!is_string($token) || $token === '') {
			$token = (string) simplyBookCall(SIMPLYBOOK_API_URL . '/login', 'getToken', [$companyLogin, $apiKey]);
			writeServiceCache('token', $companyLogin, ['token' => $token], SIMPLYBOOK_TOKEN_CACHE_SECONDS);
		}
		$sourceServices = simplyBookCall(SIMPLYBOOK_API_URL, 'getEventList', [], ['X-Company-Login: ' . $companyLogin, 'X-Token: ' . $token]);
		$sourceServices = is_array($sourceServices) ? $sourceServices : [];
		writeServiceCache('services', $companyLogin, ['services' => $sourceServices], SIMPLYBOOK_SERVICE_CACHE_SECONDS);
	}
	$services = [];
	foreach ($sourceServices as $service) {
		if (!is_array($service) || !isset($service['id'])) {
			continue;
		}
		$details = SERVICE_DETAILS[(int) $service['id']] ?? [];
		$serviceData = array_merge([
			'id' => (string) $service['id'],
			'title' => trim((string) ($service['name'] ?? '')),
			'duration' => serviceDuration($service['duration'] ?? ''),
			'description' => serviceDescription($service),
			'category' => $details['category'] ?? 'other',
		], $details);
		if ($discountPercent > 0 && isset($serviceData['price'])) {
			$serviceData['originalPrice'] = $serviceData['price'];
			$serviceData['price'] = serviceDiscountedPrice($serviceData['price'], $discountPercent);
			$serviceData['discountPercent'] = $discountPercent;
		}
		$services[] = $serviceData;
	}
	serviceResponse(['services' => $services, 'categories' => SERVICE_CATEGORIES]);
} catch (Throwable $exception) {
	serviceResponse(['error' => $exception->getMessage()], 500);
}
