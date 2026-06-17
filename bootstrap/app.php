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
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        $middleware->redirectGuestsTo(function ($request) {
            if ($request->expectsJson()) {
                return null;
            }
            if ($request->is('marketing*')) {
                return route('marketing.login');
            }
            if ($request->is('accounting*')) {
                return route('accounting.login');
            }
            if ($request->is('koordinator-lapangan*')) {
                return route('koordinator_lapangan.login');
            }
            if ($request->is('manajer*')) {
                return route('manajer.login');
            }
            if ($request->is('admin*')) {
                return route('marketing.login');
            }
            return route('login');
        });

        $middleware->redirectUsersTo(function ($request) {
            $user = $request->user();
            if ($user) {
                if ($user->role === 'marketing') {
                    return route('marketing.dashboard');
                } elseif ($user->role === 'manajer') {
                    return route('manajer.dashboard');
                } elseif ($user->role === 'accounting') {
                    return route('accounting.dashboard');
                } elseif ($user->role === 'koordinator_lapangan') {
                    return route('koordinator_lapangan.dashboard');
                } elseif ($user->role === 'pembeli') {
                    return route('home');
                }
            }
            return route('home');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
