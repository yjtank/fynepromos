<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Store;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'totalOffers' => Offer::count(),
            'activeOffers' => Offer::where('is_active', true)->where(fn ($query) => $query->whereNull('expires_at')->orWhere('expires_at', '>', now()))->count(),
            'expiredOffers' => Offer::whereNotNull('expires_at')->where('expires_at', '<=', now())->count(),
            'totalClicks' => Offer::sum('clicks_count'),
            'categoriesCount' => Category::count(),
            'storesCount' => Store::count(),
            'recentOffers' => Offer::with(['category', 'store'])->latest()->limit(5)->get(),
        ]);
    }
}
