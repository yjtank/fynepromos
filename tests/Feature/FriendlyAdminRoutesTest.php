<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FriendlyAdminRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_use_portuguese_paths_and_remain_protected(): void
    {
        $this->get('/painel')->assertRedirect(route('login'));
        $this->get('/painel/promos')->assertRedirect(route('login'));

        $user = User::factory()->create();

        $this->actingAs($user)->get('/painel')->assertForbidden();
        $this->actingAs($user)->get('/painel/promos')->assertForbidden();

        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get('/painel')->assertOk();
        $this->actingAs($admin)->get('/painel/promos')->assertOk();
        $this->actingAs($admin)->get('/painel/promos/nova')
            ->assertOk()
            ->assertSee('Promoção ativa')
            ->assertSee('toggle-control', escape: false);
        $this->actingAs($user)->get('/painel/perfil')->assertOk();
    }

    public function test_old_admin_urls_redirect_to_the_new_paths(): void
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
        ]);

        $this->actingAs(User::factory()->admin()->create())
            ->get('/offers/'.$offer->id.'/edit')
            ->assertRedirect(route('offers.edit', $offer));
    }
}
