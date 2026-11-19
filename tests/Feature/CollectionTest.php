<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Offer;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_collection_and_attach_ordered_offers(): void
    {
        $category = Category::create(['name' => 'Tecnologia', 'slug' => 'tecnologia', 'active' => true]);
        $store = Store::create(['name' => 'Loja teste', 'slug' => 'loja-teste', 'active' => true]);
        $firstOffer = Offer::create([
            'category_id' => $category->id,
            'store_id' => $store->id,
            'title' => 'Primeiro produto',
            'slug' => 'primeiro-produto',
            'current_price' => 100,
            'purchase_url' => 'https://example.com/primeiro',
            'is_active' => true,
        ]);
        $secondOffer = Offer::create([
            'category_id' => $category->id,
            'store_id' => $store->id,
            'title' => 'Segundo produto',
            'slug' => 'segundo-produto',
            'current_price' => 200,
            'purchase_url' => 'https://example.com/segundo',
            'is_active' => true,
        ]);

        $response = $this->actingAs(User::factory()->admin()->create())->post(route('collections.store'), [
            'name' => 'Setup recomendado',
            'description' => 'Produtos para montar um setup.',
            'offer_ids' => [$firstOffer->id, $secondOffer->id],
            'offer_positions' => [
                $firstOffer->id => 2,
                $secondOffer->id => 1,
            ],
            'is_featured' => '1',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('collections.index'));

        $collection = Collection::sole();
        $this->assertSame('setup-recomendado', $collection->slug);
        $this->assertSame([$secondOffer->id, $firstOffer->id], $collection->offers()->pluck('offers.id')->all());
        $this->assertTrue($collection->is_featured);
        $this->assertTrue($collection->is_active);

        $this->get(route('collections.public.show', $collection))
            ->assertOk()
            ->assertSee('Setup recomendado')
            ->assertSee('Segundo produto')
            ->assertSee('Primeiro produto');
    }
}
