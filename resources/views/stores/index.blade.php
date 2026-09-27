<x-app-layout>
    <x-slot name="title">Lojas</x-slot>
    <x-slot name="header"><div><div><span class="section-kicker">Organização</span><h1>Lojas</h1></div><a href="{{ route('stores.create') }}" class="button"><span>+</span> Nova loja</a></div></x-slot>
    @if(session('status'))<div class="admin-notice is-success">{{ session('status') }}</div>@endif
    @if(session('error'))<div class="admin-notice is-error">{{ session('error') }}</div>@endif
    <section class="catalog-manager">
        <header class="catalog-manager-header"><div><h2>Lojas parceiras</h2><p>{{ $stores->total() }} {{ $stores->total() === 1 ? 'loja cadastrada' : 'lojas cadastradas' }}</p></div></header>
        <div class="catalog-list">
            @forelse($stores as $store)
                <article class="catalog-row">
                    <div class="catalog-row-icon">{{ Str::upper(Str::substr($store->name, 0, 1)) }}</div>
                    <div class="catalog-row-copy"><strong>{{ $store->name }}</strong><span>{{ $store->website ? Str::replaceFirst('https://', '', $store->website) : 'Sem site informado' }} · {{ $store->offers_count }} {{ $store->offers_count === 1 ? 'promoção' : 'promoções' }}</span></div>
                    <span class="status-badge {{ $store->active ? 'is-active' : 'is-inactive' }}">{{ $store->active ? 'Ativa' : 'Inativa' }}</span>
                    <div class="catalog-row-actions"><a href="{{ route('stores.edit', $store) }}">Editar</a>@if($store->offers_count === 0)<form method="POST" action="{{ route('stores.destroy', $store) }}">@csrf @method('DELETE')<button type="submit" onclick="return confirm('Excluir esta loja?')">Excluir</button></form>@endif</div>
                </article>
            @empty
                <div class="catalog-manager-empty"><h2>Nenhuma loja ainda</h2><p>Cadastre as lojas que serão usadas nas promoções.</p><a href="{{ route('stores.create') }}" class="button">Criar loja</a></div>
            @endforelse
        </div>
        @if($stores->hasPages())<div class="manager-pagination">{{ $stores->links() }}</div>@endif
    </section>
</x-app-layout>
