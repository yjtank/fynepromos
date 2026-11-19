<x-app-layout>
    <x-slot name="title">Editar coleção</x-slot>
    <x-slot name="header"><div><div><span class="section-kicker">Catálogo</span><h1>Editar coleção</h1></div></div></x-slot>

    <section class="admin-form-shell collection-editor">
        <header><h2>{{ $collection->name }}</h2><p>Altere as informações e os produtos desta coleção.</p></header>
        @include('collections.form', ['action' => route('collections.update', $collection), 'method' => 'PUT'])
    </section>
</x-app-layout>
