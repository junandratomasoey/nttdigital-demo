<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Di balik Cloudflare Tunnel / proxy: percayai header X-Forwarded-* agar URL memakai https
        $middleware->trustProxies(at: '*');

        // Tentukan demo aktif dari subdomain (demo-desa.nttdigital.site -> desa)
        $middleware->web(append: [
            \App\Http\Middleware\TentukanDemo::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
