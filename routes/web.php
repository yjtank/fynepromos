<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicOfferController;
use App\Models\Offer;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicOfferController::class, 'index'])->name('home');

Route::prefix('promos')->name('promos.')->group(function () {
    Route::get('/', [PublicOfferController::class, 'index'])->name('index');
    Route::get('/destaques', [PublicOfferController::class, 'featured'])->name('featured');
    Route::get('/categoria/{category:slug}', [PublicOfferController::class, 'category'])->name('category');
    Route::get('/{offer:slug}/ir-para-loja', [PublicOfferController::class, 'click'])->name('click');
    Route::get('/{offer:slug}', [PublicOfferController::class, 'show'])->name('show');
});

Route::get('/oferta/{offer:slug}', fn (Offer $offer) => to_route('promos.show', $offer, 301));
Route::get('/oferta/{offer:slug}/clique', fn (Offer $offer) => to_route('promos.click', $offer, 301));

Route::prefix('painel')->group(function () {
    Route::get('/', DashboardController::class)
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/promos', [OfferController::class, 'index'])->name('offers.index');
        Route::get('/promos/nova', [OfferController::class, 'create'])->name('offers.create');
        Route::post('/promos', [OfferController::class, 'store'])->name('offers.store');
        Route::get('/promos/{offer:slug}', [OfferController::class, 'show'])->name('offers.show');
        Route::get('/promos/{offer:slug}/editar', [OfferController::class, 'edit'])->name('offers.edit');
        Route::match(['put', 'patch'], '/promos/{offer:slug}', [OfferController::class, 'update'])->name('offers.update');
        Route::delete('/promos/{offer:slug}', [OfferController::class, 'destroy'])->name('offers.destroy');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => to_route('dashboard', status: 301));
    Route::get('/offers', fn () => to_route('offers.index', status: 301));
    Route::get('/offers/create', fn () => to_route('offers.create', status: 301));
    Route::get('/offers/{offer}/edit', fn (Offer $offer) => to_route('offers.edit', $offer, 301));
    Route::get('/offers/{offer}', fn (Offer $offer) => to_route('offers.show', $offer, 301));
    Route::get('/profile', fn () => to_route('profile.edit', status: 301));
});

require __DIR__.'/auth.php';
