<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CashBook') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Custom CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Alpine.js -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body>
        <div class="auth-container">
            <div class="auth-card fade-in">
                <div class="auth-title">
                    <a href="/" class="app-logo">CashBook</a>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
