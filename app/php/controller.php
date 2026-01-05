<?php

declare(strict_types=1);

/**
 * Normalize API data into view-friendly values.
 *
 * @param array|null $data Raw API response data.
 * @return array{server: string, insights: array}
 */
function build_display_context(?array $data): array {
    $payload = is_array($data['data'] ?? null) ? $data['data'] : ($data ?? []);
    $server = $payload['server'] ?? 'Unknown server';
    $insights = is_array($payload['insights'] ?? null) ? $payload['insights'] : [];

    return [
        'server' => $server,
        'insights' => $insights,
    ];
}
