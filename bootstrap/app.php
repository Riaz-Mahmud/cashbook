<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule): void {
        $schedule->command('cashbook:recurring:process')->dailyAt('02:00');
    })
    ->withMiddleware(function (Middleware $middleware): void {
        // Route middleware aliases
        $middleware->alias([
            'active.business' => \App\Http\Middleware\SetActiveBusiness::class,
            'business.role' => \App\Http\Middleware\EnsureBusinessRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
