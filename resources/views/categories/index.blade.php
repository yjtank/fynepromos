<x-app-layout>
    <x-slot name="title">Categorias</x-slot>
    <x-slot name="header"><div><div><span class="section-kicker">Organização</span><h1>Categorias</h1></div><a href="{{ route('categories.create') }}" class="button"><span>+</span> Nova categoria</a></div></x-slot>

    @if(session('status'))<div class="admin-notice is-success">{{ session('status') }}</div>@endif
    @if(session('error'))<div class="admin-notice is-error">{{ session('error') }}</div>@endif

    <section class="catalog-manager">
        <header class="catalog-manager-header"><div><h2>Estrutura do catálogo</h2><p>{{ $categories->total() }} {{ $categories->total() === 1 ? 'categoria cadastrada' : 'categorias cadastradas' }}</p></div></header>
        <div class="catalog-list">
            @forelse($categories as $category)
                <article class="catalog-row">
                    <div class="catalog-row-icon">{{ Str::upper(Str::substr($category->name, 0, 1)) }}</div>
                    <div class="catalog-row-copy"><strong>{{ $category->name }}</strong><span>/promos/categoria/{{ $category->slug }} · {{ $category->offers_count }} {{ $category->offers_count === 1 ? 'promoção' : 'promoções' }}</span></div>
                    <span class="status-badge {{ $category->active ? 'is-active' : 'is-inactive' }}">{{ $category->active ? 'Ativa' : 'Inativa' }}</span>
                    <div class="catalog-row-actions"><a href="{{ route('categories.edit', $category) }}">Editar</a>@if($category->offers_count === 0)<form method="POST" action="{{ route('categories.destroy', $category) }}">@csrf @method('DELETE')<button type="submit" onclick="return confirm('Excluir esta categoria?')">Excluir</button></form>@endif</div>
                </article>
            @empty
                <div class="catalog-manager-empty"><h2>Nenhuma categoria ainda</h2><p>Crie a primeira categoria para organizar o catálogo.</p><a href="{{ route('categories.create') }}" class="button">Criar categoria</a></div>
            @endforelse
        </div>
        @if($categories->hasPages())<div class="manager-pagination">{{ $categories->links() }}</div>@endif
    </section>
</x-app-layout>
