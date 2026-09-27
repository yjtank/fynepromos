<aside class="admin-sidebar" data-admin-menu>
    <a href="{{ route('dashboard') }}" class="brand"><x-application-logo /></a>
    <nav class="admin-nav" aria-label="Navegação administrativa">
        <p class="admin-nav-label">Visão geral</p>
        <a href="{{ route('dashboard') }}" class="admin-nav-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">
            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M4 13h6V4H4v9Zm0 7h6v-4H4v4Zm10 0h6v-9h-6v9Zm0-16v4h6V4h-6Z"/></svg>Dashboard
        </a>
        <p class="admin-nav-label">Catálogo</p>
        <a href="{{ route('offers.index') }}" class="admin-nav-link {{ request()->routeIs('offers.*') ? 'is-active' : '' }}">
            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="m20.6 13.6-7 7a2 2 0 0 1-2.8 0l-7.4-7.4A2 2 0 0 1 3 11.8V5a2 2 0 0 1 2-2h6.8a2 2 0 0 1 1.4.6l7.4 7.2a2 2 0 0 1 0 2.8ZM7.5 8A1.5 1.5 0 1 0 7.5 5a1.5 1.5 0 0 0 0 3Z"/></svg>Ofertas
        </a>
        <a href="{{ route('offers.create') }}" class="admin-nav-link {{ request()->routeIs('offers.create') ? 'is-active' : '' }}">
            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>Nova oferta
        </a>
        <p class="admin-nav-label">Conta</p>
        <a href="{{ route('profile.edit') }}" class="admin-nav-link {{ request()->routeIs('profile.*') ? 'is-active' : '' }}">
            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0M12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z"/></svg>Perfil
        </a>
    </nav>
    <div class="admin-sidebar-footer">
        <a href="{{ route('home') }}" class="admin-nav-link"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="M14 5h5v5M10 14 19 5M19 14v5H5V5h5"/></svg>Ver site</a>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button class="admin-nav-link admin-logout" type="submit"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="M10 17l5-5-5-5M15 12H3M15 4h5v16h-5"/></svg>Sair</button>
        </form>
    </div>
</aside>
<button class="admin-menu-backdrop" type="button" data-menu-close aria-label="Fechar menu"></button>
