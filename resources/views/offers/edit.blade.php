<x-app-layout>
    <x-slot name="title">Editar promoção</x-slot>
    <x-slot name="header"><div><div><span class="section-kicker">Catálogo</span><h1>Editar promoção</h1></div></div></x-slot>
    <section class="offer-editor">@include('offers.form', ['action' => route('offers.update', $offer), 'method' => 'PUT'])</section>
</x-app-layout>
