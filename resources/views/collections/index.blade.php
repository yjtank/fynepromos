<x-app-layout>
    <x-slot name="title">Coleções</x-slot>
    <x-slot name="header"><div><div><span class="section-kicker">Catálogo</span><h1>Coleções</h1></div><a href="{{ route('collections.create') }}" class="button"><span>+</span> Nova coleção</a></div></x-slot>

    @if(session('status'))<div class="admin-notice is-success">{{ session('status') }}</div>@endif

    <section class="catalog-manager">
        <header class="catalog-manager-header">
            <div>
                <h2>Coleções de produtos</h2>
                <p>{{ $collections->total() }} {{ $collections->total() === 1 ? 'coleção cadastrada' : 'coleções cadastradas' }}</p>
            </div>
        </header>

        <div class="catalog-list">
            @forelse($collections as $collection)
                <article class="catalog-row">
                    <div class="catalog-row-icon">{{ Str::upper(Str::substr($collection->name, 0, 1)) }}</div>
                    <div class="catalog-row-copy">
                        <strong>{{ $collection->name }}</strong>
                        <span>/colecoes/{{ $collection->slug }} · {{ $collection->offers_count }} {{ $collection->offers_count === 1 ? 'produto' : 'produtos' }}</span>
                    </div>
                    <span class="status-badge {{ $collection->is_active ? 'is-active' : 'is-inactive' }}">{{ $collection->is_active ? 'Ativa' : 'Inativa' }}</span>
                    <div class="catalog-row-actions">
                        <a href="{{ route('collections.edit', $collection) }}">Editar</a>
                        <form method="POST" action="{{ route('collections.destroy', $collection) }}">@csrf @method('DELETE')<button type="submit" onclick="return confirm('Excluir esta coleção?')">Excluir</button></form>
                    </div>
                </article>
            @empty
                <div class="catalog-manager-empty">
                    <h2>Nenhuma coleção criada</h2>
                    <p>Organize produtos em listas temáticas para o público.</p>
                    <a href="{{ route('collections.create') }}" class="button">Criar coleção</a>
                </div>
            @endforelse
        </div>
        @if($collections->hasPages())<div class="manager-pagination">{{ $collections->links() }}</div>@endif
    </section>
</x-app-layout>
