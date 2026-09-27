<x-app-layout>
    <x-slot name="title">Nova categoria</x-slot>
    <x-slot name="header"><div><div><span class="section-kicker">Organização</span><h1>Nova categoria</h1></div></div></x-slot>

    <section class="admin-form-shell">
        <header><h2>Organize as promoções</h2><p>Crie uma categoria para agrupar produtos semelhantes.</p></header>
        @include('categories.form', ['category' => null, 'action' => route('categories.store'), 'method' => 'POST'])
    </section>
</x-app-layout>
