<?php

use App\Console\Commands\sendNotification;
use App\Http\Middleware\Admin;
use App\Http\Middleware\User;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api'
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => Admin::class,
            'user' => User::class,
            'previous_history' => \App\Http\Middleware\PreventBackHistory::class,

        ]);
    })
    ->withCommands([
        sendNotification::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
