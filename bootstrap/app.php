<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Ensure CORS is handled for API requests
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);
        
        // Escludi rotte dal CSRF per permettere test con Postman
        $middleware->validateCsrfTokens(except: [
            'login',
            'register',
            'pizzas',
            'pizzas/*',
            'categories',
            'categories/*',
            'ingredients',
            'ingredients/*',
            'allergens',
            'allergens/*',
            'appetizers',
            'appetizers/*',
            'beverages',
            'beverages/*',
            'desserts',
            'desserts/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
