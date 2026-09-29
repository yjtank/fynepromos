<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class OfferImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_upload_an_offer_image(): void
    {
        Storage::fake('public');

        $category = Category::create(['name' => 'Tecnologia', 'slug' => 'tecnologia']);
        $store = Store::create(['name' => 'Loja teste', 'slug' => 'loja-teste']);
        $image = UploadedFile::fake()->createWithContent(
            'produto.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=')
        );

        $response = $this->actingAs(User::factory()->admin()->create())->post(route('offers.store'), [
            'category_id' => $category->id,
            'store_id' => $store->id,
            'title' => 'Produto com imagem',
            'image_file' => $image,
            'current_price' => 99.90,
            'purchase_url' => 'https://example.com/produto',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('offers.index'));

        $offer = Offer::sole();

        $this->assertStringStartsWith('/storage/offers/', $offer->image_url);
        Storage::disk('public')->assertExists(Str::after($offer->image_url, '/storage/'));
    }
}
