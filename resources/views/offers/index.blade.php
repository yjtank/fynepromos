<x-app-layout>
    <x-slot name="header"><div class="flex items-center justify-between"><h2 class="font-semibold text-xl text-gray-800">Ofertas</h2><a href="{{ route('offers.create') }}" class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Nova oferta</a></div></x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        @if (session('status')) <div class="mb-4 rounded bg-green-100 p-4 text-green-800">{{ session('status') }}</div> @endif
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg"><div class="overflow-x-auto p-6">
            <table class="w-full text-left text-sm"><thead><tr class="border-b"><th class="p-3">Oferta</th><th class="p-3">Categoria</th><th class="p-3">Loja</th><th class="p-3">Preço</th><th class="p-3">Status</th><th class="p-3"></th></tr></thead><tbody>
            @forelse ($offers as $offer)<tr class="border-b"><td class="p-3 font-medium">{{ $offer->title }}</td><td class="p-3">{{ $offer->category->name }}</td><td class="p-3">{{ $offer->store->name }}</td><td class="p-3">R$ {{ number_format($offer->current_price, 2, ',', '.') }}</td><td class="p-3">{{ $offer->is_active ? 'Ativa' : 'Inativa' }}</td><td class="p-3 text-right"><a class="text-indigo-600" href="{{ route('offers.edit', $offer) }}">Editar</a><form class="inline" method="POST" action="{{ route('offers.destroy', $offer) }}">@csrf @method('DELETE')<button class="ml-3 text-red-600" onclick="return confirm('Remover esta oferta?')">Excluir</button></form></td></tr>@empty<tr><td class="p-3" colspan="6">Nenhuma oferta cadastrada.</td></tr>@endforelse
            </tbody></table>{{ $offers->links() }}
        </div></div>
    </div></div>
</x-app-layout>
