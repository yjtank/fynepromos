<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FriendlyPublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_catalog_uses_friendly_portuguese_urls(): void
    {
        $category = Category::create(['name' => 'Notebooks', 'slug' => 'notebooks']);
        $store = Store::create(['name' => 'Loja teste', 'slug' => 'loja-teste']);
        $offer = Offer::create([
            'category_id' => $category->id,
            'store_id' => $store->id,
            'title' => 'Notebook gamer',
            'slug' => 'notebook-gamer',
            'current_price' => 3999,
            'purchase_url' => 'https://example.com/notebook',
            'is_featured' => true,
            'is_active' => true,
        ]);

        $this->get('/promos')->assertOk()->assertSee('/promos/notebook-gamer', escape: false);
        $this->get('/promos/destaques')->assertOk()->assertSee('Notebook gamer');
        $this->get('/promos/categoria/notebooks')->assertOk()->assertSee('Notebook gamer');
        $this->get('/promos/notebook-gamer')->assertOk()->assertSee('Notebook gamer');
        $this->get('/oferta/notebook-gamer')->assertRedirect(route('promos.show', $offer));
    }
}
