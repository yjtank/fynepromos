<x-app-layout>
    <x-slot name="header"><div class="flex items-center justify-between"><h2 class="text-xl font-semibold text-gray-800">Dashboard</h2><a href="{{ route('offers.create') }}" class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Nova oferta</a></div></x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-lg bg-white p-6 shadow-sm"><p class="text-sm text-gray-500">Total de ofertas</p><p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalOffers }}</p></div>
            <div class="rounded-lg bg-white p-6 shadow-sm"><p class="text-sm text-gray-500">Ofertas ativas</p><p class="mt-2 text-3xl font-bold text-emerald-600">{{ $activeOffers }}</p></div>
            <div class="rounded-lg bg-white p-6 shadow-sm"><p class="text-sm text-gray-500">Ofertas expiradas</p><p class="mt-2 text-3xl font-bold text-amber-600">{{ $expiredOffers }}</p></div>
            <div class="rounded-lg bg-white p-6 shadow-sm"><p class="text-sm text-gray-500">Cliques nas ofertas</p><p class="mt-2 text-3xl font-bold text-indigo-600">{{ number_format($totalClicks, 0, ',', '.') }}</p></div>
        </div>
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-lg bg-white p-6 shadow-sm"><h3 class="font-semibold text-gray-900">Base do catálogo</h3><div class="mt-4 flex justify-between text-sm text-gray-600"><span>Categorias</span><strong>{{ $categoriesCount }}</strong></div><div class="mt-2 flex justify-between text-sm text-gray-600"><span>Lojas</span><strong>{{ $storesCount }}</strong></div><a href="{{ route('offers.index') }}" class="mt-6 inline-block text-sm font-semibold text-indigo-600">Gerenciar ofertas →</a></div>
            <div class="rounded-lg bg-white p-6 shadow-sm lg:col-span-2"><div class="flex items-center justify-between"><h3 class="font-semibold text-gray-900">Ofertas recentes</h3><a href="{{ route('offers.index') }}" class="text-sm text-indigo-600">Ver todas</a></div><div class="mt-4 divide-y">@forelse($recentOffers as $offer)<div class="flex items-center justify-between py-3"><div><p class="font-medium text-gray-900">{{ $offer->title }}</p><p class="text-sm text-gray-500">{{ $offer->store->name }} · {{ $offer->category->name }}</p></div><span class="font-semibold text-emerald-600">R$ {{ number_format($offer->current_price, 2, ',', '.') }}</span></div>@empty<p class="py-6 text-sm text-gray-500">Nenhuma oferta cadastrada ainda. Clique em “Nova oferta” para começar.</p>@endforelse</div></div>
        </div>
    </div></div>
</x-app-layout>
