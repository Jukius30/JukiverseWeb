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
        // Daftarkan route callback Midtrans agar lolos dari verifikasi CSRF
        $middleware->validateCsrfTokens(except: [
            'midtrans/callback', 
        ]);
        $middleware->alias([
        // 'nama_alias' => 'Lokasi\File\Middleware'
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();