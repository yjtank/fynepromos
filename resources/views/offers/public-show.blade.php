@extends('layouts.public')

@section('title', $offer->title)

@section('content')
    <div class="container product-page">
        <nav class="product-breadcrumb" aria-label="Caminho da página">
            <a href="{{ route('promos.index') }}">Promoções</a>
            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
            <a href="{{ route('promos.category', $offer->category) }}">{{ $offer->category->name }}</a>
            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
            <span>{{ $offer->title }}</span>
        </nav>

        <article class="product-hero">
            <section class="product-gallery" aria-label="Imagem do produto">
                <div class="product-gallery-main {{ $offer->image_url ? '' : 'is-empty' }}">
                    @if($offer->image_url)
                        <img src="{{ $offer->image_url }}" alt="{{ $offer->title }}">
                    @else
                        <svg aria-hidden="true" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="8.5" cy="9" r="1.4"/><path d="m21 15-4.6-4.6L6 20"/></svg>
                    @endif
                </div>
            </section>

            <section class="product-summary">
                <p class="product-category">{{ $offer->category->name }}</p>
                <h1>{{ $offer->title }}</h1>

                <div class="product-price-tabs" aria-label="Tipo de preço">
                    <span class="is-active">À vista</span>
                    @if($offer->installment_info)<span>Parcelado</span>@endif
                </div>

                <div class="product-price-card">
                    <p>Melhor preço à vista via <strong>{{ $offer->store->name }}</strong></p>
                    @if($offer->old_price)<del>R$ {{ number_format($offer->old_price, 2, ',', '.') }}</del>@endif
                    <strong class="product-current-price">R$ {{ number_format($offer->current_price, 2, ',', '.') }}</strong>
                    @if($offer->installment_info)<span>{{ $offer->installment_info }}</span>@endif
                    @if($offer->coupon)<div class="product-coupon"><span>Cupom disponível</span><strong>{{ $offer->coupon }}</strong><button type="button" data-copy="{{ $offer->coupon }}">Copiar cupom</button></div>@endif
                </div>

                <a href="{{ route('promos.click', $offer) }}" class="button product-cta">
                    Acessar oferta
                    <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M14 5h5v5M10 14 19 5M19 14v5H5V5h5"/></svg>
                </a>
                <p class="product-redirect-note">Você será direcionado para {{ $offer->store->name }}.</p>
            </section>
        </article>

        <nav class="product-tabs" aria-label="Seções do produto">
            <a href="#oferta" class="is-active">Oferta</a>
            @if($offer->description)<a href="#detalhes">Detalhes</a>@endif
        </nav>

        <section id="oferta" class="product-offer-section">
            <header>
                <div><span class="section-kicker">Opção de compra</span><h2>Oferta atual</h2></div>
                <span class="product-store-name">{{ $offer->store->name }}</span>
            </header>
            <div class="product-offer-row">
                @if($offer->image_url)<img src="{{ $offer->image_url }}" alt="">@else<div class="product-offer-placeholder">Produto</div>@endif
                <div class="product-offer-copy"><strong>{{ $offer->store->name }}</strong><span>Oferta verificada para este produto</span></div>
                <div class="product-offer-price"><strong>R$ {{ number_format($offer->current_price, 2, ',', '.') }}</strong>@if($offer->installment_info)<span>{{ $offer->installment_info }}</span>@endif</div>
                <a href="{{ route('promos.click', $offer) }}" class="button button--quiet">Acessar</a>
            </div>
        </section>

        @if($offer->description)
            <section id="detalhes" class="product-details-section">
                <span class="section-kicker">Informações</span>
                <h2>Detalhes do produto</h2>
                <p>{{ $offer->description }}</p>
            </section>
        @endif
    </div>
@endsection
