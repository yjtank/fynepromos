<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ofertas selecionadas de tecnologia, hardware e periféricos.">
    <title>@yield('title', 'Ofertas de tecnologia') — FynePromos</title>
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="site-body">
    <header class="site-header">
        <div class="site-header-inner">
            <a href="{{ route('home') }}" class="brand"><x-application-logo /></a>
            @if(request()->routeIs('home'))
                <form action="{{ route('home') }}" method="GET" class="header-search">
                    <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
                    <input name="search" value="{{ request('search') }}" placeholder="Procurar produto..." aria-label="Procurar produto">
                </form>
            @endif
            <div class="site-header-actions">
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
