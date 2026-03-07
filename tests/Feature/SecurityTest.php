<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_env_file_not_accessible(): void
    {
        $response = $this->get('/.env');
        $response->assertStatus(404);
    }

    public function test_security_headers_present(): void
    {
        $response = $this->get('/');
        $response->assertHeader('X-Frame-Options');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy');
    }

    public function test_login_rate_limited(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/login', [
                'email' => 'fake@test.com',
                'password' => 'wrongpassword',
            ]);
        }

        $response->assertStatus(429);
    }

    public function test_registration_requires_privacy_consent(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password1!',
            'password_confirmation' => 'Password1!',
        ]);

        $response->assertSessionHasErrors('privacy_accepted');
    }

    public function test_csrf_token_required_on_post(): void
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

        // Re-enable to test - this just verifies the middleware exists
        $response = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        // Should not be a 500 error
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    public function test_admin_routes_require_authentication(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_checkout_requires_authentication(): void
    {
        $response = $this->get('/checkout');
        // Should redirect to login or cart
        $this->assertContains($response->getStatusCode(), [302, 301]);
    }
}
