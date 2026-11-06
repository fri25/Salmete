<?php

use App\Http\Middleware\EnsureAdmin;
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
    ->withMiddleware(function (Middleware $middleware): void {
        // Derrière Traefik : ne faire confiance qu'aux plages privées
        // (Docker/Traefik), jamais '*' qui permettrait d'usurper l'IP client
        // via X-Forwarded-For. Voir TRUSTED_PROXIES dans .env.docker.example.
        $trustedProxies = array_values(array_filter(array_map(
            'trim',
            explode(',', (string) env(
                'TRUSTED_PROXIES',
                '127.0.0.1,10.0.0.0/8,172.16.0.0/12,192.168.0.0/16',
            )),
        )));

        $middleware->trustProxies(at: $trustedProxies);

        $middleware->alias([
            'admin' => EnsureAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
