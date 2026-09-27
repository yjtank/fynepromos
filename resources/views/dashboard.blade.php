<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="header">
        <div>
            <div><span class="section-kicker">Visão geral</span><h1>Dashboard</h1></div>
            <a href="{{ route('offers.create') }}" class="button"><span>+</span> Nova oferta</a>
        </div>
    </x-slot>

    <section class="dashboard-welcome">
        <div><h2>Olá, {{ Str::before(Auth::user()->name, ' ') }}.</h2><p>Acompanhe o catálogo e veja o que precisa da sua atenção.</p></div>
        <span>{{ now()->locale('pt_BR')->translatedFormat('l, d \d\e F') }}</span>
    </section>

    <section class="metric-grid" aria-label="Métricas do catálogo">
        <article class="metric-card metric-card--purple">
            <div class="metric-icon"><svg viewBox="0 0 24 24"><path d="m20.6 13.6-7 7a2 2 0 0 1-2.8 0l-7.4-7.4A2 2 0 0 1 3 11.8V5a2 2 0 0 1 2-2h6.8a2 2 0 0 1 1.4.6l7.4 7.2a2 2 0 0 1 0 2.8Z"/><circle cx="7.5" cy="7.5" r="1"/></svg></div>
            <div class="metric-label"><span>Total de ofertas</span><small>Catálogo completo</small></div>
            <strong>{{ number_format($totalOffers, 0, ',', '.') }}</strong>
        </article>
        <article class="metric-card metric-card--green">
            <div class="metric-icon"><svg viewBox="0 0 24 24"><path d="m5 12 4 4L19 6"/></svg></div>
            <div class="metric-label"><span>Ofertas ativas</span><small>{{ $activePercentage }}% do catálogo</small></div>
            <strong>{{ number_format($activeOffers, 0, ',', '.') }}</strong>
        </article>
        <article class="metric-card metric-card--amber">
            <div class="metric-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
            <div class="metric-label"><span>Expiradas</span><small>Precisam de revisão</small></div>
            <strong>{{ number_format($expiredOffers, 0, ',', '.') }}</strong>
        </article>
        <article class="metric-card metric-card--blue">
            <div class="metric-icon"><svg viewBox="0 0 24 24"><path d="m5 3 14 8-6 2-2 6L5 3Z"/></svg></div>
            <div class="metric-label"><span>Cliques gerados</span><small>Em todas as ofertas</small></div>
            <strong>{{ number_format($totalClicks, 0, ',', '.') }}</strong>
        </article>
    </section>

    <div class="dashboard-grid">
        <section class="dashboard-panel dashboard-panel--wide">
            <header class="panel-heading"><div><span class="section-kicker">Movimentação</span><h2>Ofertas recentes</h2></div><a href="{{ route('offers.index') }}">Ver todas <span>→</span></a></header>
            <div class="recent-list">
                @forelse($recentOffers as $offer)
                    <article class="recent-offer {{ $offer->image_url ? '' : 'recent-offer--without-image' }}">
                        @if($offer->image_url)<div class="recent-thumb"><img src="{{ $offer->image_url }}" alt=""></div>@endif
                        <div class="recent-copy"><strong>{{ $offer->title }}</strong><span>{{ $offer->store->name }} · {{ $offer->category->name }}</span></div>
                        <span class="status-badge {{ $offer->is_active && ! $offer->isExpired() ? 'is-active' : 'is-inactive' }}">{{ $offer->is_active && ! $offer->isExpired() ? 'Ativa' : 'Inativa' }}</span>
                        <div class="recent-price"><strong>R$ {{ number_format($offer->current_price, 2, ',', '.') }}</strong><span>{{ $offer->clicks_count }} cliques</span></div>
                        <a href="{{ route('offers.edit', $offer) }}" class="row-action" aria-label="Editar {{ $offer->title }}">→</a>
                    </article>
                @empty
                    <div class="panel-empty"><p>Nenhuma oferta cadastrada ainda.</p><a href="{{ route('offers.create') }}" class="button">Cadastrar primeira oferta</a></div>
                @endforelse
            </div>
        </section>

        <aside class="dashboard-stack">
            <section class="dashboard-panel catalog-health">
                <header class="panel-heading"><div><span class="section-kicker">Catálogo</span><h2>Saúde da base</h2></div></header>
                <div class="health-score"><div><strong>{{ $activePercentage }}%</strong><span>ativas</span></div><svg viewBox="0 0 44 44"><circle cx="22" cy="22" r="18"/><circle class="health-progress" cx="22" cy="22" r="18" style="--progress: {{ $activePercentage }}"/></svg></div>
                <dl class="catalog-summary">
                    <div><dt>Categorias</dt><dd>{{ $categoriesCount }}</dd></div>
                    <div><dt>Lojas</dt><dd>{{ $storesCount }}</dd></div>
                    <div><dt>Destaques</dt><dd>{{ $featuredOffers }}</dd></div>
                </dl>
                <a href="{{ route('offers.index') }}" class="panel-button">Gerenciar catálogo <span>→</span></a>
            </section>

            <section class="dashboard-panel top-panel">
                <header class="panel-heading"><div><span class="section-kicker">Desempenho</span><h2>Mais acessadas</h2></div></header>
                <ol class="top-list">
                    @forelse($topOffers as $offer)
                        <li><span>{{ $loop->iteration }}</span><div><strong>{{ $offer->title }}</strong><small>{{ $offer->store->name }}</small></div><b>{{ $offer->clicks_count }}</b></li>
                    @empty<li class="top-empty">Os acessos aparecerão aqui.</li>@endforelse
                </ol>
            </section>
        </aside>
    </div>
</x-app-layout>
