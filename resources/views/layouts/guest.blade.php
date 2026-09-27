<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FynePromos') }}</title>
        <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="guest-body">
        <div class="guest-shell">
            <a href="{{ route('home') }}" class="brand brand--large"><x-application-logo /></a>
            <div class="guest-card">{{ $slot }}</div>
            <a class="guest-back" href="{{ route('home') }}">← Voltar para as ofertas</a>
        </div>
    </body>
</html>
