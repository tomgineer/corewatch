<?php

if (!function_exists('formatNumber')) {
    function formatNumber(float $number, int $maxDecimals = 2): string {
        $acceptLanguage = service('request')->getHeaderLine('Accept-Language');
        $locale = \Locale::acceptFromHttp($acceptLanguage) ?: 'en_US';

        $locale = str_replace('-', '_', $locale);

        $fmt = new \NumberFormatter($locale, \NumberFormatter::DECIMAL);
        $fmt->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $maxDecimals);
        $fmt->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, 0);

        return $fmt->format($number);
    }
}
