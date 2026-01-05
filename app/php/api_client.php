<?php

declare(strict_types=1);

/**
 * Fetch monitoring JSON payload from a single API endpoint.
 *
 * @param string $url API endpoint URL.
 * @param string $token Bearer token for authentication.
 * @return array{error: string|null, status: int, data: array|null, raw: string|null}
 */
function fetch_monitoring_data(string $url, string $token): array {
    if ($url === '' || $token === '') {
        return [
            'error' => 'Missing API configuration.',
            'status' => 0,
            'data' => null,
            'raw' => null,
        ];
    }

    $ch = curl_init($url);
    if ($ch === false) {
        return [
            'error' => 'Failed to initialize cURL.',
            'status' => 0,
            'data' => null,
            'raw' => null,
        ];
    }

    $headers = [
        'Authorization: Bearer ' . $token,
        'Accept: application/json',
    ];

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT => 10,
    ]);

    $body = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($body === false || $curlError !== '') {
        return [
            'error' => $curlError !== '' ? $curlError : 'Unknown cURL error.',
            'status' => $status,
            'data' => null,
            'raw' => null,
        ];
    }

    $data = json_decode($body, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [
            'error' => 'Invalid JSON response.',
            'status' => $status,
            'data' => null,
            'raw' => $body,
        ];
    }

    $error = null;
    if ($status < 200 || $status >= 300) {
        $error = 'Request failed with status ' . $status . '.';
    }

    return [
        'error' => $error,
        'status' => $status,
        'data' => $data,
        'raw' => $body,
    ];
}

/**
 * Fetch monitoring data for a list of API endpoints.
 *
 * @param array<int, string> $urls List of API endpoint URLs.
 * @param string $token Bearer token for authentication.
 * @return array<int, array{index: int, url: string, response: array{error: string|null, status: int, data: array|null, raw: string|null}}>
 */
function fetch_monitoring_batch(array $urls, string $token): array {
    $results = [];

    foreach ($urls as $index => $url) {
        $results[] = [
            'index' => $index,
            'url' => (string) $url,
            'response' => fetch_monitoring_data((string) $url, $token),
        ];
    }

    return $results;
}
