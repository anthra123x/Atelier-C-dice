<?php

declare(strict_types=1);

// Vercel Serverless Entrypoint for Laravel

if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    // Ensure no stale local cache files interfere with serverless runtime
    @unlink(__DIR__.'/../bootstrap/cache/packages.php');
    @unlink(__DIR__.'/../bootstrap/cache/services.php');

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
}

require __DIR__.'/../public/index.php';
