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
    ->withMiddleware(function (Middleware $middleware): void {
        // Behind Render's load balancer, TLS is terminated at the proxy and
        // plain HTTP is forwarded to the container. Trust the proxy's
        // X-Forwarded-* headers so Laravel generates correct https:// URLs.
        $middleware->trustProxies(at: '*');

        $middleware->redirectGuestsTo(fn ($request) => $request->is('admin/*') ? route('admin.login') : route('login'));

        $middleware->redirectUsersTo(fn ($request) => $request->is('admin/*') ? route('admin.users.index') : route('shop.index'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
