<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Alias de middlewares personnalisés
        $middleware->alias([
            'is_admin' => IsAdmin::class,
        ]);

        // Tu peux ajouter d’autres middlewares ici si besoin
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
