<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ofertas selecionadas de tecnologia, hardware e periféricos.">
    <title>@yield('title', 'Ofertas de tecnologia') — FynePromos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="site-body">
    <header class="site-header">
        <div class="site-header-inner">
            <button class="icon-button site-menu-toggle" type="button" data-site-menu-toggle aria-label="Abrir menu" aria-expanded="false">
                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
            <a href="{{ route('home') }}" class="brand"><x-application-logo /></a>
            <nav class="site-navigation" aria-label="Navegação principal">
                <a href="{{ route('promos.index') }}" class="{{ request()->routeIs('home', 'promos.index', 'promos.category') ? 'is-active' : '' }}">Promos</a>
                <a href="{{ route('promos.featured') }}" class="{{ request()->routeIs('promos.featured') ? 'is-active' : '' }}">Destaques</a>
                @if(isset($categories) && $categories->isNotEmpty())
                    <a href="{{ route('promos.category', $categories->first()) }}">Categorias</a>
                @endif
            </nav>
            @if(request()->routeIs('home', 'promos.*'))
                <form action="{{ route('promos.index') }}" method="GET" class="header-search">
                    <svg class="header-search-icon" aria-hidden="true" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Busque produto, loja ou categoria" aria-label="Buscar ofertas" autocomplete="off">
                    @if(request('search'))<a href="{{ request()->fullUrlWithoutQuery(['search', 'page']) }}" class="header-search-clear" aria-label="Limpar busca">×</a>@endif
                    <button type="submit">Buscar</button>
                </form>
            @endif
            @if(Auth::check() && Auth::user()->is_admin)<div class="site-header-actions"><a href="{{ route('dashboard') }}" class="button button--quiet">Painel</a></div>@endif
        </div>
    </header>
    <aside class="site-menu" data-site-menu aria-label="Menu principal">
        <div class="site-menu-header">
            <a href="{{ route('home') }}" class="brand"><x-application-logo /></a>
            <button class="icon-button" type="button" data-site-menu-close aria-label="Fechar menu">
                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <nav class="site-menu-nav">
            <span class="site-menu-label">Navegação</span>
            <a href="{{ route('home') }}"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="m3 11 9-8 9 8v10h-6v-6H9v6H3V11Z"/></svg>Início</a>
            <a href="{{ route('promos.index') }}"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="m20 13-7 7-9-9V4h7l9 9Z"/><circle cx="8" cy="8" r="1"/></svg>Todas as ofertas</a>
            <a href="{{ route('promos.featured') }}"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3Z"/></svg>Destaques</a>
            @if(Auth::check() && Auth::user()->is_admin)<a href="{{ route('dashboard') }}"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="M4 13h6V4H4v9Zm0 7h6v-4H4v4Zm10 0h6v-9h-6v9Zm0-16v4h6V4h-6Z"/></svg>Painel</a>@endif

            @isset($categories)
                <span class="site-menu-label site-menu-label--spaced">Categorias</span>
                @foreach($categories as $category)
                    <a href="{{ route('promos.category', $category) }}" class="site-menu-category"><span></span>{{ $category->name }}</a>
                @endforeach
            @endisset
        </nav>
        <p class="site-menu-note">Ofertas de tecnologia selecionadas diariamente.</p>
    </aside>
    <button class="site-menu-backdrop" type="button" data-site-menu-close aria-label="Fechar menu"></button>
    <main>@yield('content')</main>
    <footer class="site-footer">
        <div class="container site-footer-grid">
            <section class="site-footer-intro">
                <a href="{{ route('home') }}" class="footer-brand">{{ $siteSettings->site_name }}</a>
                <p>{{ $siteSettings->footer_description }}</p>
                <div class="footer-socials" aria-label="Redes sociais">
                    <a href="{{ $siteSettings->whatsapp_url }}" aria-label="WhatsApp" @if($siteSettings->whatsapp_url !== '#') target="_blank" rel="noopener noreferrer" @endif>
                        <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M20.5 11.8a8.5 8.5 0 0 1-12.6 7.5L3.5 20.5l1.2-4.2A8.5 8.5 0 1 1 20.5 11.8Z"/><path d="M8.3 7.7c.2-.4.4-.4.7-.4h.5c.2 0 .4 0 .5.4l.7 1.6c.1.3.1.5 0 .7l-.5.6c-.2.2-.2.4 0 .7.5.9 1.3 1.7 2.2 2.2.3.2.5.2.7 0l.6-.7c.2-.2.4-.2.7-.1l1.6.7c.3.1.4.3.4.5v.5c0 .3-.1.5-.4.7-.5.3-1.1.4-1.7.3-1.1-.2-2.3-.8-3.7-2.1-1.2-1.1-2-2.4-2.3-3.5-.2-.7-.1-1.4.3-2Z"/></svg>
                    </a>
                    <a href="{{ $siteSettings->instagram_url }}" aria-label="Instagram" @if($siteSettings->instagram_url !== '#') target="_blank" rel="noopener noreferrer" @endif>
                        <svg aria-hidden="true" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.3" cy="6.8" r=".8" fill="currentColor" stroke="none"/></svg>
                    </a>
                </div>
            </section>
            <section class="site-footer-links"><h2>Explorar</h2><a href="{{ route('promos.index') }}">Todas as promoções</a><a href="{{ route('promos.featured') }}">Destaques</a><a href="{{ route('home') }}">Início</a></section>
            <section class="site-footer-links"><h2>Categorias</h2>@foreach(($categories ?? collect())->take(4) as $category)<a href="{{ route('promos.category', $category) }}">{{ $category->name }}</a>@endforeach</section>
            <section class="site-footer-callout"><span class="section-kicker">Ofertas atualizadas</span><h2>Encontre a próxima oportunidade.</h2><a href="{{ route('promos.index') }}" class="button button--quiet">Ver promoções</a></section>
        </div>
        <div class="container site-footer-bottom"><span>© {{ date('Y') }} {{ $siteSettings->site_name }}</span><span>Todos os direitos reservados.</span></div>
    </footer>
</body>
</html>
