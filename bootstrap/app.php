<?php

use Illuminate\Foundation\Application;

$app = Application::configure(basePath: dirname(__DIR__))
    // Bind http & console kernels (Laravel 11 “single kernel” default)
    ->withRouting(
        using: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        api: __DIR__ . '/../routes/api.php'
    )
    ->withMiddleware(function ($middleware) {
        // global HTTP middleware additions (none beyond default)
    })
    ->withExceptions()
    ->create();

return $app;
