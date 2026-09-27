<x-app-layout>
    <x-slot name="title">Nova loja</x-slot>
    <x-slot name="header"><div><div><span class="section-kicker">Organização</span><h1>Nova loja</h1></div></div></x-slot>
    <section class="admin-form-shell"><header><h2>Adicione uma loja parceira</h2><p>Use a URL da loja para manter a base organizada.</p></header>@include('stores.form', ['store' => null, 'action' => route('stores.store'), 'method' => 'POST'])</section>
</x-app-layout>
