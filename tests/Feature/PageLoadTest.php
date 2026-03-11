<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageLoadTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_login_page_loads(): void
    {
        $response = $this->get('/connexion');
        $response->assertStatus(200);
    }

    public function test_register_page_loads(): void
    {
        $response = $this->get('/inscription');
        $response->assertStatus(200);
    }

    public function test_cart_page_loads(): void
    {
        $response = $this->get('/panier');
        $response->assertStatus(200);
    }

    public function test_mentions_legales_loads(): void
    {
        $response = $this->get('/mentions-legales');
        $response->assertStatus(200);
    }

    public function test_privacy_policy_loads(): void
    {
        $response = $this->get('/politique-de-confidentialite');
        $response->assertStatus(200);
    }

    public function test_cgv_loads(): void
    {
        $response = $this->get('/conditions-generales-de-vente');
        $response->assertStatus(200);
    }

    public function test_cookie_policy_loads(): void
    {
        $response = $this->get('/politique-cookies');
        $response->assertStatus(200);
    }
}
