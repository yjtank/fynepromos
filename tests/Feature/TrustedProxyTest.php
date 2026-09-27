<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrustedProxyTest extends TestCase
{
    use RefreshDatabase;

    public function test_https_links_are_generated_behind_a_trusted_proxy(): void
    {
        $response = $this
            ->withServerVariables(['REMOTE_ADDR' => '127.0.0.1'])
            ->withHeaders([
                'Host' => 'fynepromos.example.com',
                'X-Forwarded-Host' => 'fynepromos.example.com',
                'X-Forwarded-Proto' => 'https',
                'X-Forwarded-Port' => '443',
            ])
            ->get('/');

        $response
            ->assertOk()
            ->assertSee('https://fynepromos.example.com/css/app.css', escape: false)
            ->assertSee('https://fynepromos.example.com/js/app.js', escape: false);
    }
}
