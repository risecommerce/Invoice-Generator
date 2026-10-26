<?php
// includes/env.php
// Minimal .env loader. Real environment variables take precedence over the file.
// Looks for .env one level ABOVE the project first (outside public_html on Hostinger),
// then in the project root (blocked from the web by .htaccess).

function loadEnv(): array {
    static $vars = null;
    if ($vars !== null) return $vars;

    $vars = [];
    $candidates = [
        dirname(__DIR__, 2) . '/.env',
        dirname(__DIR__) . '/.env',
    ];

    foreach ($candidates as $path) {
        if (!is_readable($path)) continue;

        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) continue;

            [$key, $value] = array_map('trim', explode('=', $line, 2));

            // Strip matching surrounding quotes: KEY="value" or KEY='value'
            if (strlen($value) >= 2 && ($value[0] === '"' || $value[0] === "'") && $value[-1] === $value[0]) {
                $value = substr($value, 1, -1);
            }

            $vars[$key] = $value;
        }
        break;
    }

    return $vars;
}

function env(string $key, ?string $default = null): ?string {
    $value = getenv($key);
    if ($value !== false && $value !== '') return $value;

    $vars = loadEnv();
    return isset($vars[$key]) && $vars[$key] !== '' ? $vars[$key] : $default;
}
