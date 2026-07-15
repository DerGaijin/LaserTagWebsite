<?php
declare(strict_types=1);

// This endpoint must never mix PHP diagnostics into its JSON response.
ini_set('display_errors', '0');
ini_set('html_errors', '0');
error_reporting(E_ALL);

const SERVICE_CACHE_TTL = 240;
require __DIR__ . '/Shared.php';

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

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        respond(405, ['error' => 'Method not allowed.']);
    }

    $cachedServices = readServiceCache();
    if ($cachedServices !== null) {
        respond(200, ['services' => $cachedServices], true);
    }

    $eventResponse = simplyBookRequest(SIMPLYBOOK_API_URL, 'getEventList', [], simplyBookHeaders());
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
