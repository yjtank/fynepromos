<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\View\View;

class PublicCollectionController extends Controller
{
    public function index(): View
    {
        return view('collections.public-index', [
            'collections' => Collection::where('is_active', true)
                ->withCount(['offers' => fn ($query) => $query->where('is_active', true)])
                ->orderByDesc('is_featured')
                ->latest()
                ->paginate(12),
            'categories' => \App\Models\Category::where('active', true)->orderBy('name')->get(),
        ]);
    }

    public function show(Collection $collection): View
    {
        abort_unless($collection->is_active, 404);

        return view('collections.public-show', [
            'collection' => $collection->load(['offers' => fn ($query) => $query
                ->where('is_active', true)
                ->where(fn ($offerQuery) => $offerQuery
                    ->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now()))]),
            'categories' => \App\Models\Category::where('active', true)->orderBy('name')->get(),
        ]);
    }
}
