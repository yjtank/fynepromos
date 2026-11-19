@extends('layouts.public')

@section('title', 'Coleções')

@section('content')
    <div class="container collection-public-page">
        <header class="collection-public-header">
            <div><span class="section-kicker">Seleções especiais</span><h1>Coleções de produtos</h1></div>
            <p>Encontre promoções organizadas por tema, uso ou ocasião.</p>
        </header>

        <div class="collection-public-grid">
            @forelse($collections as $collection)
                <a href="{{ route('collections.public.show', $collection) }}" class="collection-public-card">
                    @if($collection->image_url)
                        <img src="{{ $collection->image_url }}" alt="{{ $collection->name }}">
                    @else
                        <div class="collection-public-placeholder">{{ Str::upper(Str::substr($collection->name, 0, 1)) }}</div>
                    @endif
                    <div>
                        @if($collection->is_featured)<span>Destaque</span>@endif
                        <h2>{{ $collection->name }}</h2>
                        @if($collection->description)<p>{{ $collection->description }}</p>@endif
                        <small>{{ $collection->offers_count }} {{ $collection->offers_count === 1 ? 'produto' : 'produtos' }}</small>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <h2>Nenhuma coleção disponível</h2>
                    <p>Novas seleções de produtos aparecerão aqui.</p>
                </div>
            @endforelse
        </div>

        @if($collections->hasPages())<div class="manager-pagination">{{ $collections->links() }}</div>@endif
    </div>
@endsection
