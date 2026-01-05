<?php namespace App\Models;
use CodeIgniter\Model;

class AppModel extends Model {

/**
 * Fetch API configurations from apiCalls.json and return responses.
 *
 * @return array{cache_ttl: int|null, apis: array<int, array{index: int, url: string, response: array{error: string|null, status: int, data: array|null, raw: string|null}}>}|array{error: string, apis: array<int, mixed>}
 */
public function fetchApis(): array {
    $configPath = ROOTPATH . 'apiCalls.json';

    if (!is_file($configPath)) {
        return [
            'error' => 'Missing apiCalls.json.',
            'apis' => [],
        ];
    }

    $rawConfig = file_get_contents($configPath);
    if ($rawConfig === false) {
        return [
            'error' => 'Unable to read apiCalls.json.',
            'apis' => [],
        ];
    }

    $config = json_decode($rawConfig, true);
    if (!is_array($config)) {
        return [
            'error' => 'Invalid JSON in apiCalls.json.',
            'apis' => [],
        ];
    }

    $cacheTtl = isset($config['cache_ttl']) ? (int) $config['cache_ttl'] : 0;
    $cacheKey = 'api_results_' . sha1($rawConfig);
    $cache = cache();

    if ($cacheTtl > 0 && $cache !== null) {
        $cached = $cache->get($cacheKey);
        if (is_array($cached)) {
            return $cached;
        }
    }

    $apis = isset($config['apis']) && is_array($config['apis']) ? $config['apis'] : [];
    $results = [];

    foreach ($apis as $index => $api) {
        $url = isset($api['url']) ? (string) $api['url'] : '';
        $token = isset($api['token']) ? (string) $api['token'] : '';

        $results[] = [
            'index' => $index,
            'url' => $url,
            'response' => $this->fetchApiResponse($url, $token),
        ];
    }

    $payload = [
        'cache_ttl' => $cacheTtl > 0 ? $cacheTtl : null,
        'apis' => $results,
    ];

    if ($cacheTtl > 0 && $cache !== null) {
        $cache->save($cacheKey, $payload, $cacheTtl);
    }

    return $payload;
}

/**
 * Call a single API endpoint and normalize the response.
 *
 * @param string $url API endpoint URL.
 * @param string $token Bearer token for authentication.
 * @return array{error: string|null, status: int, data: array|null, raw: string|null}
 */
private function fetchApiResponse(string $url, string $token): array {
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

} // End of class
