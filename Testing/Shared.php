<?php

const SIMPLYBOOK_API_URL = 'https://user-api.simplybook.me';

function loadTestingEnv(): void
{
    $path = dirname(__DIR__) . '/.env';
    if (!is_readable($path)) {
        return;
    }

    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$name, $value] = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value, " \t\n\r\0\x0B\"'");
        if ($name !== '' && getenv($name) === false) {
            putenv($name . '=' . $value);
        }
    }
}

function testingEnvValue(string $name): string
{
    $value = getenv($name);
    return is_string($value) ? trim($value) : '';
}

function simplyBookTestingCall(string $url, string $method, array $params, array $headers = []): mixed
{
    $payload = json_encode(['jsonrpc' => '2.0', 'method' => $method, 'params' => $params, 'id' => uniqid('simplybook_', true)]);
    $curl = curl_init($url);
    if ($curl === false || $payload === false) {
        throw new RuntimeException('Could not initialize the SimplyBook request.');
    }

    curl_setopt_array($curl, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => array_merge(['Content-Type: application/json'], $headers),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 20,
    ]);
    $responseHeaders = [];
    curl_setopt($curl, CURLOPT_HEADERFUNCTION, static function ($curl, string $header) use (&$responseHeaders): int {
        $separator = strpos($header, ':');
        if ($separator !== false) {
            $name = strtolower(trim(substr($header, 0, $separator)));
            if ($name === 'x-iplb-request-id') {
                $responseHeaders[$name] = trim(substr($header, $separator + 1));
            }
        }
        return strlen($header);
    });
    $caCertPath = testingEnvValue('SIMPLYBOOK_CA_CERT_PATH');
    if ($caCertPath !== '') {
        curl_setopt($curl, CURLOPT_CAINFO, $caCertPath);
    } else {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    }
    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
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
        $error = $decoded['error'];
        if (!is_array($error)) {
            throw new RuntimeException((string) $error);
        }

        $message = (string) ($error['message'] ?? 'Unknown SimplyBook error.');
        if (isset($error['code'])) {
            $message .= ' (code ' . $error['code'] . ')';
        }
        if (isset($error['data']) && $error['data'] !== '') {
            $data = json_encode($error['data'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            if ($data !== false) {
                $message .= ': ' . $data;
            }
        }
        if (!empty($responseHeaders['x-iplb-request-id'])) {
            $message .= ' [SimplyBook request ID: ' . $responseHeaders['x-iplb-request-id'] . ']';
        }
        throw new RuntimeException($message);
    }
    if ($status >= 400) {
        throw new RuntimeException('SimplyBook HTTP error: ' . $status);
    }

    return $decoded['result'] ?? null;
}

function getTestingServices(string $companyLogin, string $apiKey): array
{
    $token = (string) simplyBookTestingCall(SIMPLYBOOK_API_URL . '/login', 'getToken', [$companyLogin, $apiKey]);

    $services = simplyBookTestingCall(SIMPLYBOOK_API_URL, 'getEventList', [], [
        'X-Company-Login: ' . $companyLogin,
        'X-Token: ' . $token,
    ]);
    return is_array($services) ? array_values($services) : [];
}
