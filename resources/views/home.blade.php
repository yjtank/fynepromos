@extends('layouts.public')

@section('title', 'Ofertas de tecnologia')

@section('content')
    <section class="catalog" id="ofertas">
        <div class="container">
            <div class="category-strip" aria-label="Categorias">
                <a href="{{ route('promos.index', request()->only('search')) }}#ofertas" class="category-chip {{ $activeCategory || $showingFeatured ? '' : 'is-active' }}">Todas</a>
                @foreach($categories as $category)
                    <a href="{{ route('promos.category', array_merge(['category' => $category], request()->only('search'))) }}#ofertas" class="category-chip {{ $activeCategory?->is($category) ? 'is-active' : '' }}">{{ $category->name }}</a>
                @endforeach
            </div>

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
                        <a href="{{ route('promos.show', $offer) }}" class="offer-card-content {{ $offer->image_url ? 'has-image' : 'has-no-image' }}">
                            @if($offer->image_url)<div class="offer-image">
                                <img src="{{ $offer->image_url }}" alt="{{ $offer->title }}" loading="lazy">
                                @if($discount)<strong>-{{ $discount }}%</strong>@endif
                            </div>@endif
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
                        <a href="{{ route('promos.show', $offer) }}" class="offer-cta">Ver promoção <span>→</span></a>
                    </article>
                @empty
                    <div class="empty-state">
                        <span class="empty-state-icon"><svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m19 19-3.8-3.8M8 10.5h5"/></svg></span>
                        @if(request('search'))
                            <h3>Nenhuma oferta para “{{ request('search') }}”</h3>
                            <p>Confira a escrita ou tente buscar pelo produto, pela loja ou pela categoria.</p>
                            <a href="{{ request()->fullUrlWithoutQuery(['search', 'page']) }}" class="button button--quiet">Limpar busca</a>
                        @elseif($activeCategory || $showingFeatured || request('store'))
                            <h3>Nenhuma oferta nesta seleção</h3>
                            <p>Esta categoria ainda não possui promoções disponíveis.</p>
                            <a href="{{ route('promos.index') }}" class="button button--quiet">Ver todas as ofertas</a>
                        @else
                            <h3>Ainda não há ofertas publicadas</h3>
                            <p>Novas promoções aparecerão aqui assim que forem adicionadas.</p>
                        @endif
                    </div>
                @endforelse
            </div>
            @if($offers->hasPages())<div class="pagination-wrap">{{ $offers->links() }}</div>@endif
        </div>
    </section>
@endsection
