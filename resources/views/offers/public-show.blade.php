@extends('layouts.public')

@section('title', $offer->title)

@section('content')
    <div class="container detail-wrap">
        <a href="{{ route('home') }}#ofertas" class="detail-back">← Voltar para as ofertas</a>
        <article class="offer-detail {{ $offer->image_url ? '' : 'offer-detail--without-image' }}">
            @if($offer->image_url)<div class="detail-image"><img src="{{ $offer->image_url }}" alt="{{ $offer->title }}"></div>@endif
            <div class="detail-content">
                <div class="detail-meta"><span>{{ $offer->category->name }}</span><i></i><span>{{ $offer->store->name }}</span>@if($offer->is_featured)<strong>Destaque</strong>@endif</div>
                <h1>{{ $offer->title }}</h1>
                <div class="detail-price">
                    @if($offer->old_price)<del>de R$ {{ number_format($offer->old_price, 2, ',', '.') }}</del>@endif
                    <p><small>por</small> R$ {{ number_format($offer->current_price, 2, ',', '.') }}</p>
                    @if($offer->installment_info)<span>{{ $offer->installment_info }}</span>@endif
                </div>
                @if($offer->coupon)<button class="detail-coupon" type="button" data-copy="{{ $offer->coupon }}"><span>Use o cupom</span><strong>{{ $offer->coupon }}</strong><em>Clique para copiar</em></button>@endif
                <a href="{{ route('offers.click', $offer) }}" class="button detail-cta">Ir para {{ $offer->store->name }} <span>↗</span></a>
                <p class="redirect-note">Você será redirecionado para o site da loja.</p>
            </div>
        </article>
        @if($offer->description)<section class="detail-description"><span class="section-kicker">Sobre a oferta</span><h2>Detalhes do produto</h2><p>{{ $offer->description }}</p></section>@endif
    </div>
@endsection
