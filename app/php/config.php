<?php

declare(strict_types=1);

/**
 * Monitoring API configuration.
 *
 * - api_urls: List of monitoring endpoints to query on the dashboard.
 * - api_token: Bearer token used to authenticate the requests.
 *
 * Update these values for your environment (or wire them to env variables).
 */
return [
    // One or more monitoring endpoints to call.
    'api_urls' => [
        'http://[::1]/verdincms/public/api/monitor',
        'http://[::1]/verdincms/public/api/monitor',
        'http://[::1]/verdincms/public/api/monitor',
        'http://[::1]/verdincms/public/api/monitor',
    ],
    // Bearer token for API authorization.
    'api_token' => 'ZT8pRxQmi4H4K8ZixZS3RoCh2CHiPxF9TfqkpJVbZaIGxLqKiwoqXLmhBH911UfH',
];
