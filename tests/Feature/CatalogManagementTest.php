<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_verified_admin_can_manage_categories_and_stores(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('categories.store'), [
            'name' => 'Audio',
            'active' => '1',
        ])->assertRedirect(route('categories.index'));

        $category = Category::sole();
        $this->assertSame('audio', $category->slug);

        $this->actingAs($user)->put(route('categories.update', $category), [
            'name' => 'Áudio',
        ])->assertRedirect(route('categories.index'));

        $this->assertFalse($category->fresh()->active);

        $this->actingAs($user)->post(route('stores.store'), [
            'name' => 'Loja de áudio',
            'website' => 'https://example.com',
            'active' => '1',
        ])->assertRedirect(route('stores.index'));

        $store = Store::sole();
        $this->assertSame('loja-de-audio', $store->slug);
        $this->actingAs($user)->get(route('stores.index'))->assertOk()->assertSee('Loja de áudio');
    }
}
