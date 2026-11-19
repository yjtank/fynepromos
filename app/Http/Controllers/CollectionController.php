<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Offer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function index(): View
    {
        return view('collections.index', [
            'collections' => Collection::withCount('offers')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('collections.create', [
            'offers' => $this->availableOffers(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        [$data, $offerIds, $positions] = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);

        $collection = Collection::create($data);
        $collection->offers()->sync($this->pivotData($offerIds, $positions));

        return to_route('collections.index')->with('status', 'Coleção criada com sucesso.');
    }

    public function edit(Collection $collection): View
    {
        return view('collections.edit', [
            'collection' => $collection->load('offers'),
            'offers' => $this->availableOffers(),
        ]);
    }

    public function update(Request $request, Collection $collection): RedirectResponse
    {
        [$data, $offerIds, $positions] = $this->validated($request);
        $data['slug'] = $collection->name === $data['name']
            ? $collection->slug
            : $this->uniqueSlug($data['name'], $collection->id);

        $collection->update($data);
        $collection->offers()->sync($this->pivotData($offerIds, $positions));

        return to_route('collections.index')->with('status', 'Coleção atualizada com sucesso.');
    }

    public function destroy(Collection $collection): RedirectResponse
    {
        $collection->delete();

        return to_route('collections.index')->with('status', 'Coleção excluída com sucesso.');
    }

    private function availableOffers()
    {
        return Offer::with(['category', 'store'])
            ->orderBy('title')
            ->get();
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'offer_ids' => ['nullable', 'array'],
            'offer_ids.*' => ['integer', 'exists:offers,id'],
            'offer_positions' => ['nullable', 'array'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        $data = collect($validated)
            ->except(['offer_ids', 'offer_positions'])
            ->all();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');

        $offerIds = array_map('intval', $validated['offer_ids'] ?? []);
        $positions = $validated['offer_positions'] ?? [];

        return [$data, $offerIds, $positions];
    }

    private function pivotData(array $offerIds, array $positions): array
    {
        $data = [];

        foreach ($offerIds as $index => $offerId) {
            $data[$offerId] = [
                'position' => (int) ($positions[$offerId] ?? ($index + 1)),
            ];
        }

        return $data;
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'colecao';
        $slug = $base;
        $counter = 2;

        while (Collection::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
