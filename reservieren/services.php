<?php
declare(strict_types=1);

// This endpoint must never mix PHP diagnostics into its JSON response.
ini_set('display_errors', '0');
ini_set('html_errors', '0');
error_reporting(E_ALL);

const SIMPLYBOOK_API_URL = 'https://user-api.simplybook.me';
const SERVICE_CACHE_TTL = 240;

// Values not supplied by SimplyBook belong here, keyed by its service ID.
const SERVICE_DETAILS = [
    16 => [
        'price' => '27,90 €',
        'priceNote' => 'pro Gast',
        'note' => 'Bis zu 4 Runden möglich, 2 Runden garantiert.',
        'category' => 'birthday',
    ],
    17 => [
        'price' => '32,90 €',
        'priceNote' => 'pro Gast',
        'note' => 'Bis zu 4 Runden möglich, 2 Runden garantiert.',
        'category' => 'birthday',
    ],
    18 => [
        'price' => '15,00 €',
        'priceNote' => 'pro Person',
        'category' => 'weekend',
        'label' => 'Samstag & Sonntag',
    ],
    19 => [
        'price' => '27,00 €',
        'priceNote' => 'pro Person',
        'category' => 'weekend',
        'label' => 'Samstag & Sonntag',
    ],
    20 => [
        'price' => '18,50 €',
        'priceNote' => 'pro Person',
        'category' => 'standard',
    ],
    21 => [
        'price' => '36,00 €',
        'priceNote' => 'pro Person',
        'category' => 'standard',
    ],
];

const SERVICE_CATEGORIES = [
    'birthday' => ['eyebrow' => 'Feiern', 'title' => 'Geburtstagspakete'],
    'weekend' => ['eyebrow' => 'Aktionen', 'title' => 'Flats am Wochenende'],
    'standard' => ['eyebrow' => 'Spielzeit', 'title' => 'Standardbuchungen'],
    'other' => ['eyebrow' => 'Weitere Angebote', 'title' => 'Weitere Spielzeiten'],
];

function respond(int $statusCode, array $payload, bool $cacheable = false): never
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    header($cacheable ? 'Cache-Control: public, max-age=' . SERVICE_CACHE_TTL : 'Cache-Control: no-store');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
}

function serviceCachePath(): string
{
    return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'lasertag-simplybook-services.json';
}

function readServiceCache(): ?array
{
    $path = serviceCachePath();
    clearstatcache(true, $path);
    if (!is_file($path) || filemtime($path) < time() - SERVICE_CACHE_TTL) {
        return null;
    }

    $contents = file_get_contents($path);
    if ($contents === false) {
        return null;
    }

    try {
        $services = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        return null;
    }

    return is_array($services) ? $services : null;
}

function writeServiceCache(array $services): void
{
    file_put_contents(
        serviceCachePath(),
        json_encode($services, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
        LOCK_EX,
    );
}

function environmentValue(string $name): ?string
{
    $value = getenv($name);

    if ($value === false && isset($_SERVER[$name])) {
        $value = $_SERVER[$name];
    }

    return is_string($value) && $value !== '' ? $value : null;
}

function dotEnvValue(string $name): ?string
{
    $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
    if (!is_file($path) || !is_readable($path)) {
        return null;
    }

    // Do not use parse_ini_file: secrets may contain characters that are valid
    // in .env files but produce PHP warnings under INI parsing.
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return null;
    }

    $value = null;
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$key, $candidate] = explode('=', $line, 2);
        if (trim($key) !== $name) {
            continue;
        }

        $value = trim($candidate);
        if (strlen($value) >= 2 && (($value[0] === '"' && $value[-1] === '"') || ($value[0] === "'" && $value[-1] === "'"))) {
            $value = substr($value, 1, -1);
        }
        break;
    }

    return is_string($value) && $value !== '' ? $value : null;
}

function caCertificatePath(): ?string
{
    $configuredPath = environmentValue('SIMPLYBOOK_CA_CERT_PATH') ?? dotEnvValue('SIMPLYBOOK_CA_CERT_PATH');
    if ($configuredPath === null) {
        return null;
    }

    $path = realpath($configuredPath) ?: realpath(dirname(__DIR__) . DIRECTORY_SEPARATOR . $configuredPath);

    return $path !== false && is_readable($path) ? $path : null;
}

function formattedDescription(string $description): string
{
    $description = strip_tags($description, '<br><p><strong><b><em><i><ul><ol><li>');

    // Keep only the approved tag names, never attributes from an API response.
    return preg_replace_callback('/<\/?([a-z0-9]+)(?:\s[^>]*)?>/i', static function (array $match): string {
        $tag = strtolower($match[1]);
        $isClosingTag = str_starts_with($match[0], '</');

        return $isClosingTag ? '</' . $tag . '>' : '<' . $tag . '>';
    }, $description) ?? '';
}

function simplyBookRequest(string $url, string $method, array $params, array $headers = []): array
{
    $payload = json_encode([
        'jsonrpc' => '2.0',
        'method' => $method,
        'params' => $params,
        'id' => bin2hex(random_bytes(8)),
    ], JSON_THROW_ON_ERROR);
    $curl = curl_init($url);

    if ($curl === false) {
        throw new RuntimeException('Could not initialize the request.');
    }

    curl_setopt_array($curl, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array_merge(['Content-Type: application/json'], $headers),
        CURLOPT_TIMEOUT => 20,
    ]);

    $caCertificatePath = caCertificatePath();
    if ($caCertificatePath !== null) {
        curl_setopt($curl, CURLOPT_CAINFO, $caCertificatePath);
    } else {
        // Some Windows PHP deployments have no bundled CA store. Configure
        // SIMPLYBOOK_CA_CERT_PATH in production to retain certificate checks.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    }

    $response = curl_exec($curl);
    $statusCode = (int) curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    $error = curl_error($curl);
    curl_close($curl);

    if ($response === false || $statusCode < 200 || $statusCode >= 300) {
        throw new RuntimeException($error !== '' ? $error : 'SimplyBook request failed.');
    }

    $data = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    if (!is_array($data) || isset($data['error'])) {
        throw new RuntimeException('SimplyBook returned an invalid response.');
    }

    return $data;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        respond(405, ['error' => 'Method not allowed.']);
    }

    $cachedServices = readServiceCache();
    if ($cachedServices !== null) {
        respond(200, ['services' => $cachedServices], true);
    }

    if (!function_exists('curl_init')) {
        throw new RuntimeException('PHP cURL is not available.');
    }

    $companyLogin = environmentValue('SIMPLYBOOK_COMPANY_LOGIN') ?? dotEnvValue('SIMPLYBOOK_COMPANY_LOGIN');
    $apiKey = environmentValue('SIMPLYBOOK_API_KEY') ?? dotEnvValue('SIMPLYBOOK_API_KEY');
    if ($companyLogin === null || $apiKey === null) {
        throw new RuntimeException('SimplyBook is not configured.');
    }

    $tokenResponse = simplyBookRequest(SIMPLYBOOK_API_URL . '/login', 'getToken', [$companyLogin, $apiKey]);
    $token = $tokenResponse['result'] ?? null;
    if (!is_string($token) || $token === '') {
        throw new RuntimeException('SimplyBook authentication failed.');
    }

    $eventResponse = simplyBookRequest(SIMPLYBOOK_API_URL, 'getEventList', [], [
        'X-Company-Login: ' . $companyLogin,
        'X-Token: ' . $token,
    ]);
    $events = $eventResponse['result'] ?? [];
    if (!is_array($events)) {
        throw new RuntimeException('SimplyBook returned no services.');
    }

    $services = [];
    foreach ($events as $event) {
        if (!is_array($event) || empty($event['is_active']) || !isset($event['id'], $event['name'])) {
            continue;
        }

        $id = (int) $event['id'];
        $details = SERVICE_DETAILS[$id] ?? [];
        $category = $details['category'] ?? 'other';
        $services[] = [
            'id' => $id,
            'name' => (string) $event['name'],
            'duration' => (string) ($event['duration'] ?? ''),
            'description' => formattedDescription((string) ($event['description'] ?? '')),
            'price' => $details['price'] ?? null,
            'priceNote' => $details['priceNote'] ?? null,
            'note' => $details['note'] ?? null,
            'label' => $details['label'] ?? null,
            'category' => SERVICE_CATEGORIES[$category],
        ];
    }

    writeServiceCache($services);
    respond(200, ['services' => $services], true);
} catch (Throwable $exception) {
    error_log('SimplyBook services endpoint: ' . $exception->getMessage());
    respond(502, ['error' => 'Die Angebote konnten momentan nicht geladen werden. Bitte versucht es später erneut.']);
}
