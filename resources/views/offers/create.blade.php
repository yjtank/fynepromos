<x-app-layout>
    <x-slot name="title">Nova promoção</x-slot>
    <x-slot name="header"><div><div><span class="section-kicker">Catálogo</span><h1>Nova promoção</h1></div></div></x-slot>
    <section class="offer-editor">@include('offers.form', ['offer' => null, 'action' => route('offers.store'), 'method' => 'POST'])</section>
</x-app-layout>
