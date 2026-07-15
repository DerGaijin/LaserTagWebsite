<?php
declare(strict_types=1);

const SIMPLYBOOK_API_URL = 'https://user-api.simplybook.me';
const SIMPLYBOOK_UNIT_ID = 1;

function respond(int $statusCode, array $payload, bool $cacheable = false): never
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    header($cacheable ? 'Cache-Control: public, max-age=240' : 'Cache-Control: no-store');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
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

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return null;
    }

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        if (trim($key) !== $name) {
            continue;
        }
        $value = trim($value);
        if (strlen($value) >= 2 && (($value[0] === '"' && $value[-1] === '"') || ($value[0] === "'" && $value[-1] === "'"))) {
            $value = substr($value, 1, -1);
        }
        return $value !== '' ? $value : null;
    }

    return null;
}

function simplyBookRequest(string $url, string $method, array $params, array $headers = []): array
{
    $payload = json_encode(['jsonrpc' => '2.0', 'method' => $method, 'params' => $params, 'id' => bin2hex(random_bytes(8))], JSON_THROW_ON_ERROR);
    $curl = curl_init($url);
    if ($curl === false) {
        throw new RuntimeException('Could not initialize the request.');
    }

    curl_setopt_array($curl, [CURLOPT_POST => true, CURLOPT_POSTFIELDS => $payload, CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPHEADER => array_merge(['Content-Type: application/json'], $headers), CURLOPT_TIMEOUT => 20]);
    $configuredPath = environmentValue('SIMPLYBOOK_CA_CERT_PATH') ?? dotEnvValue('SIMPLYBOOK_CA_CERT_PATH');
    $caCertificatePath = $configuredPath === null ? false : (realpath($configuredPath) ?: realpath(dirname(__DIR__) . DIRECTORY_SEPARATOR . $configuredPath));
    if ($caCertificatePath !== false && is_readable($caCertificatePath)) {
        curl_setopt($curl, CURLOPT_CAINFO, $caCertificatePath);
    } else {
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

function simplyBookHeaders(): array
{
    if (!function_exists('curl_init')) {
        throw new RuntimeException('PHP cURL is not available.');
    }
    $companyLogin = environmentValue('SIMPLYBOOK_COMPANY_LOGIN') ?? dotEnvValue('SIMPLYBOOK_COMPANY_LOGIN');
    $apiKey = environmentValue('SIMPLYBOOK_API_KEY') ?? dotEnvValue('SIMPLYBOOK_API_KEY');
    if ($companyLogin === null || $apiKey === null) {
        throw new RuntimeException('SimplyBook is not configured.');
    }
    $token = simplyBookRequest(SIMPLYBOOK_API_URL . '/login', 'getToken', [$companyLogin, $apiKey])['result'] ?? null;
    if (!is_string($token) || $token === '') {
        throw new RuntimeException('SimplyBook authentication failed.');
    }

    return ['X-Company-Login: ' . $companyLogin, 'X-Token: ' . $token];
}

function simplyBookAdminHeaders(): array
{
    if (!function_exists('curl_init')) {
        throw new RuntimeException('PHP cURL is not available.');
    }
    $companyLogin = environmentValue('SIMPLYBOOK_COMPANY_LOGIN') ?? dotEnvValue('SIMPLYBOOK_COMPANY_LOGIN');
    $adminLogin = environmentValue('SIMPLYBOOK_ADMIN_LOGIN') ?? dotEnvValue('SIMPLYBOOK_ADMIN_LOGIN');
    $adminKey = environmentValue('SIMPLYBOOK_ADMIN_KEY') ?? dotEnvValue('SIMPLYBOOK_ADMIN_KEY');
    if ($companyLogin === null || $adminLogin === null || $adminKey === null) {
        throw new RuntimeException('SimplyBook administration is not configured.');
    }

    $token = simplyBookRequest(SIMPLYBOOK_API_URL . '/login', 'getUserToken', [$companyLogin, $adminLogin, $adminKey])['result'] ?? null;
    if (!is_string($token) || $token === '') {
        throw new RuntimeException('SimplyBook administration authentication failed.');
    }

    return ['X-Company-Login: ' . $companyLogin, 'X-User-Token: ' . $token];
}
