<?php

declare(strict_types=1);

/**
 * Escape a value for safe HTML output.
 *
 * @param mixed $value Value to escape.
 * @return string Escaped string.
 */
function esc($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
