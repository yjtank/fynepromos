<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OfferController extends Controller
{
    public function index(): View
    {
        return view('offers.index', ['offers' => Offer::with(['category', 'store'])->latest()->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('offers.create', $this->formData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        Offer::create($data);
        return to_route('offers.index')->with('status', 'Oferta criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer): View
    {
        return view('offers.show', compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer): View
    {
        return view('offers.edit', array_merge(['offer' => $offer], $this->formData()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $offer->title !== $data['title'] ? $this->uniqueSlug($data['title'], $offer->id) : $offer->slug;
        $offer->update($data);
        return to_route('offers.index')->with('status', 'Oferta atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer): RedirectResponse
    {
        $offer->delete();
        return to_route('offers.index')->with('status', 'Oferta removida com sucesso.');
    }

    private function formData(): array
    {
        return [
            'categories' => Category::where('active', true)->orderBy('name')->get(),
            'stores' => Store::where('active', true)->orderBy('name')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'current_price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'installment_info' => ['nullable', 'string', 'max:255'],
            'coupon' => ['nullable', 'string', 'max:255'],
            'purchase_url' => ['required', 'url', 'max:2048'],
            'expires_at' => ['nullable', 'date'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ]) + ['is_featured' => $request->boolean('is_featured'), 'is_active' => $request->boolean('is_active')];
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'oferta';
        $slug = $base;
        $counter = 2;
        while (Offer::where('slug', $slug)->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$counter++;
        }
        return $slug;
    }
}
