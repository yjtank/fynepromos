<x-app-layout>
    <x-slot name="title">Editar loja</x-slot>
    <x-slot name="header"><div><div><span class="section-kicker">Organização</span><h1>Editar loja</h1></div></div></x-slot>
    <section class="admin-form-shell"><header><h2>{{ $store->name }}</h2><p>Atualize as informações da loja.</p></header>@include('stores.form', ['action' => route('stores.update', $store), 'method' => 'PUT'])</section>
</x-app-layout>
