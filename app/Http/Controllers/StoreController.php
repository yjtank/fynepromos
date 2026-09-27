<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(): View
    {
        return view('stores.index', [
            'stores' => Store::withCount('offers')->orderBy('name')->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('stores.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        Store::create($data);

        return to_route('stores.index')->with('status', 'Loja criada com sucesso.');
    }

    public function edit(Store $store): View
    {
        return view('stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $store->name === $data['name'] ? $store->slug : $this->uniqueSlug($data['name'], $store->id);
        $store->update($data);

        return to_route('stores.index')->with('status', 'Loja atualizada com sucesso.');
    }

    public function destroy(Store $store): RedirectResponse
    {
        if ($store->offers()->exists()) {
            return to_route('stores.index')->with('error', 'Não é possível excluir uma loja que possui promoções. Desative-a ou mova as promoções antes.');
        }

        $store->delete();

        return to_route('stores.index')->with('status', 'Loja excluída com sucesso.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:2048'],
            'active' => ['boolean'],
        ]) + ['active' => $request->boolean('active')];
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'loja';
        $slug = $base;
        $counter = 2;

        while (Store::where('slug', $slug)->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
