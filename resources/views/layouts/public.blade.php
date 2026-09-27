<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ofertas selecionadas de tecnologia, hardware e periféricos.">
    <title>@yield('title', 'Ofertas de tecnologia') — FynePromos</title>
    <script>document.documentElement.dataset.theme = localStorage.getItem('fyne-theme') || 'dark';</script>
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="site-body">
    <header class="site-header">
        <div class="site-header-inner">
            <a href="{{ route('home') }}" class="brand"><x-application-logo /></a>
            <div class="site-header-actions">
                <a href="{{ route('home') }}#ofertas" class="header-link">Ofertas</a>
                <button class="icon-button" type="button" data-theme-toggle aria-label="Alternar tema"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="M20 15.3A8.5 8.5 0 1 1 8.7 4a7 7 0 0 0 11.3 11.3Z"/></svg></button>
                @auth<a href="{{ route('dashboard') }}" class="button button--quiet">Dashboard</a>@else<a href="{{ route('login') }}" class="button button--quiet">Entrar</a>@endauth
            </div>
        </div>
    </header>
    <main>@yield('content')</main>
    <footer class="site-footer">
        <div class="container site-footer-inner">
            <a href="{{ route('home') }}" class="brand"><x-application-logo /></a>
            <p>Curadoria direta ao ponto para você pagar menos.</p>
            <span>© {{ date('Y') }} FynePromos</span>
        </div>
    </footer>
</body>
</html>
