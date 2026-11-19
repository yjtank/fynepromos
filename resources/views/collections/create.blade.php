<x-app-layout>
    <x-slot name="title">Nova coleção</x-slot>
    <x-slot name="header"><div><div><span class="section-kicker">Catálogo</span><h1>Nova coleção</h1></div></div></x-slot>

    <section class="admin-form-shell collection-editor">
        <header><h2>Crie uma coleção de produtos</h2><p>Selecione as promoções e defina a ordem em que aparecerão.</p></header>
        @include('collections.form', ['collection' => null, 'action' => route('collections.store'), 'method' => 'POST'])
    </section>
</x-app-layout>
