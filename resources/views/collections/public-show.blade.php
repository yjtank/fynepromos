@extends('layouts.public')

@section('title', $collection->name)

@section('content')
    <div class="container collection-public-page">
        <nav class="product-breadcrumb" aria-label="Caminho da página">
            <a href="{{ route('collections.public.index') }}">Coleções</a>
            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
            <span>{{ $collection->name }}</span>
        </nav>

        <header class="collection-detail-header">
            @if($collection->image_url)<img src="{{ $collection->image_url }}" alt="{{ $collection->name }}">@endif
            <div>
                @if($collection->is_featured)<span class="section-kicker">Coleção em destaque</span>@endif
                <h1>{{ $collection->name }}</h1>
                @if($collection->description)<p>{{ $collection->description }}</p>@endif
            </div>
        </header>

        <section class="collection-product-grid" aria-label="Produtos da coleção">
            @forelse($collection->offers as $offer)
                <article class="collection-product-card">
                    <a href="{{ route('promos.show', $offer) }}" class="collection-product-image">
                        @if($offer->image_url)
                            <img src="{{ $offer->image_url }}" alt="{{ $offer->title }}">
                        @else
                            <span>{{ Str::upper(Str::substr($offer->title, 0, 1)) }}</span>
                        @endif
                    </a>
                    <div class="collection-product-copy">
                        <span>{{ $offer->category->name }}</span>
                        <h2><a href="{{ route('promos.show', $offer) }}">{{ $offer->title }}</a></h2>
                        <small>{{ $offer->store->name }}</small>
                        <strong>R$ {{ number_format($offer->current_price, 2, ',', '.') }}</strong>
                        @if($offer->installment_info)<p>{{ $offer->installment_info }}</p>@endif
                    </div>
                    <a href="{{ route('promos.show', $offer) }}" class="button button--quiet">Ver promoção</a>
                </article>
            @empty
                <div class="empty-state">
                    <h2>Esta coleção ainda não possui produtos</h2>
                </div>
            @endforelse
        </section>
    </div>
@endsection
