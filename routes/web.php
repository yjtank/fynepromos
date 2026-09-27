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

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('offers', OfferController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
