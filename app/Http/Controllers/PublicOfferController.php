<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Offer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicOfferController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('search')->toString());

        $offers = Offer::with(['category', 'store'])
            ->where('is_active', true)
            ->where(fn ($query) => $query->whereNull('expires_at')->orWhere('expires_at', '>', now()))
            ->when($search !== '', function ($query) use ($search) {
                foreach (preg_split('/\s+/', $search, flags: PREG_SPLIT_NO_EMPTY) as $term) {
                    $term = '%'.addcslashes($term, '\\%_').'%';

                    $query->where(fn ($searchQuery) => $searchQuery
                        ->where('title', 'like', $term)
                        ->orWhere('description', 'like', $term)
                        ->orWhere('coupon', 'like', $term)
                        ->orWhereHas('store', fn ($storeQuery) => $storeQuery->where('name', 'like', $term))
                        ->orWhereHas('category', fn ($categoryQuery) => $categoryQuery->where('name', 'like', $term))
                    );
                }
            })
            ->when($request->filled('category'), fn ($query) => $query->where('category_id', $request->integer('category')))
            ->when($request->filled('store'), fn ($query) => $query->where('store_id', $request->integer('store')))
            ->when($request->boolean('featured'), fn ($query) => $query->where('is_featured', true))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('home', [
            'offers' => $offers,
            'categories' => Category::where('active', true)->orderBy('name')->get(),
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
