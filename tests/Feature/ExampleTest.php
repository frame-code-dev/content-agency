<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertRedirect(route('dashboard'));

        // Unauthenticated request redirects to login
        $guestResponse = $this->get('/dashboard');
        $guestResponse->assertRedirect(route('login'));

        // Authenticated request reaches dashboard
        $user = User::factory()->create();
        $authResponse = $this->actingAs($user)->get('/dashboard');
        $authResponse->assertStatus(200);
    }
}
