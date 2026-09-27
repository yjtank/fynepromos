<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicOfferSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_finds_offers_by_product_store_category_description_and_coupon(): void
    {
        $category = Category::create(['name' => 'Notebooks', 'slug' => 'notebooks']);
        $store = Store::create(['name' => 'Mercado Livre', 'slug' => 'mercado-livre']);

        Offer::create([
            'category_id' => $category->id,
            'store_id' => $store->id,
            'title' => 'Notebok LOQ',
            'slug' => 'notebok-loq',
            'description' => 'Computador gamer com placa dedicada',
            'coupon' => 'FYNE20',
            'current_price' => 4299.90,
            'purchase_url' => 'https://example.com/notebook',
            'is_active' => true,
        ]);

        foreach (['LOQ', 'notebook', 'mercado', 'placa dedicada', 'FYNE20'] as $search) {
            $this->get(route('home', ['search' => $search]))
                ->assertOk()
                ->assertSee('Notebok LOQ');
        }
    }

    public function test_empty_search_result_explains_what_was_searched(): void
    {
        $this->get(route('home', ['search' => 'produto inexistente']))
            ->assertOk()
            ->assertSee('Nenhuma oferta para “produto inexistente”')
            ->assertSee('Limpar busca');
    }
}
