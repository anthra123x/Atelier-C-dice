<?php

declare(strict_types=1);

// Vercel Serverless Entrypoint for Laravel

if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    $bootstrapCache = '/tmp/bootstrap/cache';
    if (! is_dir($bootstrapCache)) {
        mkdir($bootstrapCache, 0755, true);
    }

    putenv("APP_PACKAGES_CACHE={$bootstrapCache}/packages.php");
    putenv("APP_SERVICES_CACHE={$bootstrapCache}/services.php");
    putenv("APP_CONFIG_CACHE={$bootstrapCache}/config.php");
    putenv("APP_ROUTES_CACHE={$bootstrapCache}/routes.php");
    putenv("APP_EVENTS_CACHE={$bootstrapCache}/events.php");

    $_ENV['APP_PACKAGES_CACHE'] = "{$bootstrapCache}/packages.php";
    $_ENV['APP_SERVICES_CACHE'] = "{$bootstrapCache}/services.php";
    $_ENV['APP_CONFIG_CACHE'] = "{$bootstrapCache}/config.php";
    $_ENV['APP_ROUTES_CACHE'] = "{$bootstrapCache}/routes.php";
    $_ENV['APP_EVENTS_CACHE'] = "{$bootstrapCache}/events.php";

    $_SERVER['APP_PACKAGES_CACHE'] = "{$bootstrapCache}/packages.php";
    $_SERVER['APP_SERVICES_CACHE'] = "{$bootstrapCache}/services.php";
    $_SERVER['APP_CONFIG_CACHE'] = "{$bootstrapCache}/config.php";
    $_SERVER['APP_ROUTES_CACHE'] = "{$bootstrapCache}/routes.php";
    $_SERVER['APP_EVENTS_CACHE'] = "{$bootstrapCache}/events.php";

    $storagePath = '/tmp/storage';
    $dirs = [
        $storagePath.'/framework/views',
        $storagePath.'/framework/cache',
        $storagePath.'/framework/cache/data',
        $storagePath.'/framework/sessions',
        $storagePath.'/logs',
        $storagePath.'/app/public',
    ];

    foreach ($dirs as $dir) {
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    putenv("APP_STORAGE={$storagePath}");
    $_ENV['APP_STORAGE'] = $storagePath;
    $_SERVER['APP_STORAGE'] = $storagePath;

    putenv("VIEW_COMPILED_PATH={$storagePath}/framework/views");
    $_ENV['VIEW_COMPILED_PATH'] = "{$storagePath}/framework/views";
    $_SERVER['VIEW_COMPILED_PATH'] = "{$storagePath}/framework/views";

    // Prevent Symfony Request from interpreting /api/index.php as a subdirectory base URL
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $_SERVER['PHP_SELF'] = '/index.php';

    // Ensure HTTPS is detected by PHP and Laravel
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = '443';
    $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'https';
}

// Normalize Vercel Serverless request URI
// If incoming request accessed /v1/... directly, normalize to /api/v1/...
if (isset($_SERVER['REQUEST_URI'])) {
    $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '';
    if (str_starts_with($requestPath, '/v1/') || $requestPath === '/v1') {
        $_SERVER['REQUEST_URI'] = '/api'.$_SERVER['REQUEST_URI'];
    }
}

require __DIR__.'/../public/index.php';
