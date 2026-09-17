<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FynePromos — Ofertas de tecnologia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <header class="border-b border-slate-800">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
            <a href="{{ route('home') }}" class="text-2xl font-black">Fyne<span class="text-indigo-400">Promos</span></a>
            <a href="{{ route('login') }}" class="text-sm text-slate-300 hover:text-white">Área administrativa</a>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-10">


        <form method="GET" class="mb-8 grid gap-3 rounded-2xl border border-slate-800 bg-slate-900 p-4 md:grid-cols-[1fr_190px_190px_auto]">
            <input name="search" value="{{ request('search') }}" placeholder="Buscar produto..." class="rounded-lg border-slate-700 bg-slate-800 text-white placeholder-slate-400">
            <select name="category" class="rounded-lg border-slate-700 bg-slate-800 text-white">
                <option value="">Todas as categorias</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="store" class="rounded-lg border-slate-700 bg-slate-800 text-white">
                <option value="">Todas as lojas</option>
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" @selected(request('store') == $store->id)>{{ $store->name }}</option>
                @endforeach
            </select>
            <button class="rounded-lg bg-indigo-500 px-5 py-2 font-semibold text-white hover:bg-indigo-400">Buscar</button>
        </form>

        <div class="mb-5 flex items-center justify-between">
            <h2 class="text-2xl font-bold">Ofertas recentes</h2>
            <span class="text-sm text-slate-400">{{ $offers->total() }} encontrada(s)</span>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($offers as $offer)
                <article class="group overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg transition hover:-translate-y-1 hover:border-indigo-500">
                    <a href="{{ route('offers.public.show', $offer) }}" class="block">
                        @if($offer->image_url)
                            <img src="{{ $offer->image_url }}" alt="{{ $offer->title }}" class="h-52 w-full bg-white object-contain p-4">
                        @else
                            <div class="flex h-52 items-center justify-center bg-slate-800 text-slate-500">Sem imagem</div>
                        @endif
                        <div class="p-5">
                            <div class="mb-2 flex justify-between text-xs font-semibold uppercase tracking-wide text-indigo-300">
                                <span>{{ $offer->store->name }}</span>
                                @if($offer->is_featured)<span>Destaque</span>@endif
                            </div>
                            <h3 class="min-h-14 text-lg font-bold text-white">{{ $offer->title }}</h3>
                            @if($offer->old_price)<p class="mt-4 text-sm text-slate-500 line-through">R$ {{ number_format($offer->old_price, 2, ',', '.') }}</p>@endif
                            <p class="text-2xl font-black text-emerald-400">R$ {{ number_format($offer->current_price, 2, ',', '.') }}</p>
                            @if($offer->installment_info)<p class="mt-1 text-sm text-slate-400">{{ $offer->installment_info }}</p>@endif
                            @if($offer->coupon)<p class="mt-3 rounded bg-amber-400/10 px-3 py-2 text-sm text-amber-300">Cupom: {{ $offer->coupon }}</p>@endif
                        </div>
                    </a>
                </article>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-slate-700 p-12 text-center text-slate-400">Nenhuma oferta encontrada.</div>
            @endforelse
        </div>

        <div class="mt-8">{{ $offers->links() }}</div>
    </main>
</body>
</html>
