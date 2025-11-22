<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 1. PENGATURAN REDIRECT TAMU
        // (Agar error 'Route [login] not defined' tidak muncul)
        $middleware->redirectGuestsTo(function (Request $request) {
            return route('warga.login.form');
        });

        // 2. PENDAFTARAN ALIAS MIDDLEWARE
        // (Agar error 'Target class [role] does not exist' hilang)
        $middleware->alias([
            'role' => \App\Http\Middleware\CekRole::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();