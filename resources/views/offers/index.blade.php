<x-app-layout>
    <x-slot name="title">Promoções</x-slot>
    <x-slot name="header"><div><div><span class="section-kicker">Catálogo</span><h1>Promoções</h1></div><a href="{{ route('offers.create') }}" class="button"><span>+</span> Nova promoção</a></div></x-slot>

    @if(session('status'))<div class="admin-notice is-success">{{ session('status') }}</div>@endif

    <section class="catalog-manager offer-manager">
        <header class="catalog-manager-header"><div><h2>Produtos publicados</h2><p>{{ $offers->total() }} {{ $offers->total() === 1 ? 'promoção cadastrada' : 'promoções cadastradas' }}</p></div></header>
        <div class="catalog-list">
            @forelse($offers as $offer)
                <article class="offer-manager-row">
                    @if($offer->image_url)<div class="offer-manager-image"><img src="{{ $offer->image_url }}" alt=""></div>@else<div class="offer-manager-image is-empty">{{ Str::upper(Str::substr($offer->title, 0, 1)) }}</div>@endif
                    <div class="offer-manager-copy"><strong>{{ $offer->title }}</strong><span>{{ $offer->store->name }} · {{ $offer->category->name }}</span></div>
                    <div class="offer-manager-price"><strong>R$ {{ number_format($offer->current_price, 2, ',', '.') }}</strong>@if($offer->old_price)<span>de R$ {{ number_format($offer->old_price, 2, ',', '.') }}</span>@endif</div>
                    <div class="offer-manager-status"><span class="status-badge {{ $offer->is_active && ! $offer->isExpired() ? 'is-active' : 'is-inactive' }}">{{ $offer->is_active && ! $offer->isExpired() ? 'Ativa' : 'Inativa' }}</span>@if($offer->is_featured)<small>Destaque</small>@endif</div>
                    <div class="catalog-row-actions"><a href="{{ route('offers.edit', $offer) }}">Editar</a><form method="POST" action="{{ route('offers.destroy', $offer) }}">@csrf @method('DELETE')<button type="submit" onclick="return confirm('Excluir esta promoção?')">Excluir</button></form></div>
                </article>
            @empty
                <div class="catalog-manager-empty"><h2>Seu catálogo está vazio</h2><p>Cadastre uma promoção para começar a montar a vitrine pública.</p><a href="{{ route('offers.create') }}" class="button">Criar promoção</a></div>
            @endforelse
        </div>
        @if($offers->hasPages())<div class="manager-pagination">{{ $offers->links() }}</div>@endif
    </section>
</x-app-layout>
