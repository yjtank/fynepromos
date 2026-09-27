@extends('layouts.public')

@section('title', 'Ofertas de tecnologia')

@section('content')
    <section class="catalog" id="ofertas">
        <div class="container">
            <div class="catalog-heading">
                <div><span class="section-kicker">Atualizadas diariamente</span><h1>Ofertas de tecnologia</h1><p>Promoções selecionadas em lojas confiáveis.</p></div>
                <span class="result-count">{{ $offers->total() }} {{ $offers->total() === 1 ? 'resultado' : 'resultados' }}</span>
            </div>

            <div class="category-strip" aria-label="Categorias">
                <a href="{{ route('home', request()->except(['category', 'page'])) }}#ofertas" class="category-chip {{ request('category') ? '' : 'is-active' }}">Todas</a>
                @foreach($categories as $category)
                    <a href="{{ route('home', array_merge(request()->except('page'), ['category' => $category->id])) }}#ofertas" class="category-chip {{ request('category') == $category->id ? 'is-active' : '' }}">{{ $category->name }}</a>
                @endforeach
            </div>

            <form method="GET" action="{{ route('home') }}#ofertas" class="filter-toolbar">
                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                <div class="filter-toolbar-title">
                    <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M4 6h16M7 12h10M10 18h4"/></svg>
                    <span>Filtros</span>
                </div>
                <label class="filter-select">
                    <span>Loja</span>
                    <select name="store">
                        <option value="">Todas as lojas</option>
                        @foreach($stores as $store)<option value="{{ $store->id }}" @selected(request('store') == $store->id)>{{ $store->name }}</option>@endforeach
                    </select>
                </label>
                <label class="featured-filter">
                    <input type="checkbox" name="featured" value="1" @checked(request()->boolean('featured'))>
                    <span>Somente destaques</span>
                </label>
                <button class="button filter-apply" type="submit">Aplicar filtros</button>
                @if(request()->hasAny(['category', 'store', 'featured']))<a class="filter-clear" href="{{ route('home', request()->only('search')) }}#ofertas">Limpar</a>@endif
            </form>

            <div class="offer-grid">
                @forelse($offers as $offer)
                    @php
                        $discount = $offer->old_price && $offer->old_price > $offer->current_price
                            ? round((1 - ($offer->current_price / $offer->old_price)) * 100)
                            : null;
                    @endphp
                    <article class="offer-card">
                        <div class="offer-card-topline">
                            <span>{{ $offer->store->name }}</span>
                            <time datetime="{{ $offer->created_at->toIso8601String() }}">{{ $offer->created_at->locale('pt_BR')->diffForHumans() }}</time>
                        </div>
                        <a href="{{ route('offers.public.show', $offer) }}" class="offer-card-content">
                            <div class="offer-image">
                                @if($offer->image_url)<img src="{{ $offer->image_url }}" alt="{{ $offer->title }}" loading="lazy">@else<span>F<span>P</span></span>@endif
                                @if($discount)<strong>-{{ $discount }}%</strong>@endif
                            </div>
                            <div class="offer-info">
                                <span class="offer-category">{{ $offer->category->name }}</span>
                                <h3>{{ $offer->title }}</h3>
                                <div class="offer-price-line">
                                    <p><small>por</small> R$ {{ number_format($offer->current_price, 2, ',', '.') }}</p>
                                    @if($offer->old_price)<del>R$ {{ number_format($offer->old_price, 2, ',', '.') }}</del>@endif
                                </div>
                                @if($offer->installment_info)<span class="installments">{{ $offer->installment_info }}</span>@endif
                            </div>
                        </a>
                        @if($offer->coupon)
                            <button class="coupon" type="button" data-copy="{{ $offer->coupon }}"><span>Cupom</span><strong>{{ $offer->coupon }}</strong><svg aria-hidden="true" viewBox="0 0 24 24"><rect x="8" y="8" width="11" height="11" rx="2"/><path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3"/></svg></button>
                        @endif
                        <a href="{{ route('offers.public.show', $offer) }}" class="offer-cta">Ver promoção <span>→</span></a>
                    </article>
                @empty
                    <div class="empty-state"><span>⌁</span><h3>Nenhuma oferta por aqui</h3><p>Tente remover algum filtro ou buscar por outro produto.</p><a href="{{ route('home') }}" class="button">Ver todas</a></div>
                @endforelse
            </div>
            @if($offers->hasPages())<div class="pagination-wrap">{{ $offers->links() }}</div>@endif
        </div>
    </section>
@endsection
