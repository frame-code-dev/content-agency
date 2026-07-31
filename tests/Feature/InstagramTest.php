<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstagramTest extends TestCase
{
    use RefreshDatabase;

    public function test_instagram_oauth_redirects_to_live_api_url_when_not_in_mock_mode(): void
    {
        config(['services.instagram.mock_mode' => false]);
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('instagram.connect'));
        $response->assertRedirectContains('https://www.facebook.com/v19.0/dialog/oauth');
        $response->assertRedirectContains('client_id=' . config('services.instagram.client_id'));
    }

    public function test_instagram_oauth_connect_and_login_flow_in_mock_mode(): void
    {
        config(['services.instagram.mock_mode' => true]);
        $user = User::factory()->create();

        // 1. Visit connect route as authenticated user
        $response = $this->actingAs($user)->get(route('instagram.connect'));
        $response->assertRedirect();

        // 2. Visit callback route
        $callbackResponse = $this->actingAs($user)->get(route('instagram.callback', ['code' => 'mock_demo_code']));
        $callbackResponse->assertRedirect(route('dashboard'));

        // 3. Assert user is authenticated and redirected to dashboard successfully
        $this->assertAuthenticated();

        // 4. Assert dashboard loads posts for authenticated user
        $dashboard = $this->actingAs($user)->get(route('dashboard'));
        $dashboard->assertStatus(200);
        $dashboard->assertSee('agency_demo_studio');
    }
}
