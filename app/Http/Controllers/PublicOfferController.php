<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicOfferController extends Controller
{
    public function index(Request $request): View
    {
        $offers = Offer::with(['category', 'store'])
            ->where('is_active', true)
            ->where(fn ($query) => $query->whereNull('expires_at')->orWhere('expires_at', '>', now()))
            ->when($request->filled('search'), fn ($query) => $query->where('title', 'like', '%'.$request->string('search').'%'))
            ->when($request->filled('category'), fn ($query) => $query->where('category_id', $request->integer('category')))
            ->when($request->filled('store'), fn ($query) => $query->where('store_id', $request->integer('store')))
            ->when($request->boolean('featured'), fn ($query) => $query->where('is_featured', true))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('home', [
            'offers' => $offers,
            'categories' => Category::where('active', true)->orderBy('name')->get(),
            'stores' => Store::where('active', true)->orderBy('name')->get(),
        ]);
    }

    public function show(Offer $offer): View
    {
        abort_unless($offer->is_active && ! $offer->isExpired(), 404);

        return view('offers.public-show', compact('offer'));
    }

    public function click(Offer $offer): RedirectResponse
    {
        abort_unless($offer->is_active && ! $offer->isExpired(), 404);
        $offer->increment('clicks_count');

        return redirect()->away($offer->purchase_url);
    }
}
