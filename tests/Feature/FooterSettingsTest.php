<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FooterSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_customize_the_footer_and_social_links(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('settings.edit'))
            ->assertOk()
            ->assertSee('Rodapé e links')
            ->assertSee('whatsapp_url', escape: false);

        $this->actingAs($admin)->put(route('settings.update'), [
            'site_name' => 'Achados da Fyne',
            'footer_description' => 'Tecnologia escolhida com atenção para você economizar.',
            'whatsapp_url' => 'https://wa.me/5511999999999',
            'instagram_url' => 'https://instagram.com/fynepromos',
        ])->assertRedirect(route('settings.edit'));

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Achados da Fyne')
            ->assertSee('https://wa.me/5511999999999', escape: false)
            ->assertSee('https://instagram.com/fynepromos', escape: false);
    }

    public function test_non_admin_cannot_change_footer_settings(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('settings.edit'))
            ->assertForbidden();
    }
}
