<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title.' — ' : '' }}{{ config('app.name', 'FynePromos') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="admin-body">
        <div class="admin-shell">
            @include('layouts.navigation')
            <div class="admin-workspace">
                <header class="admin-topbar">
                    <button class="icon-button admin-menu-button" type="button" data-menu-toggle aria-label="Abrir menu" aria-expanded="false">
                        <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                    </button>
                    <div class="admin-topbar-copy"><span>Painel administrativo</span><strong>{{ Auth::user()->name }}</strong></div>
                </header>
                @isset($header)<header class="page-header">{{ $header }}</header>@endisset
                <main class="admin-content">{{ $slot }}</main>
            </div>
        </div>
    </body>
</html>
