<x-app-layout>
    <x-slot name="title">Editar categoria</x-slot>
    <x-slot name="header"><div><div><span class="section-kicker">Organização</span><h1>Editar categoria</h1></div></div></x-slot>

    <section class="admin-form-shell">
        <header><h2>{{ $category->name }}</h2><p>Altere o nome ou a disponibilidade desta categoria.</p></header>
        @include('categories.form', ['action' => route('categories.update', $category), 'method' => 'PUT'])
    </section>
</x-app-layout>
