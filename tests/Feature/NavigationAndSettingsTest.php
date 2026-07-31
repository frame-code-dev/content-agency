<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavigationAndSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_access_settings_page(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('settings'));
        $response->assertStatus(200);
        $response->assertSee('Studio Settings');
        $response->assertSee('Instagram Integration');
    }

    public function test_can_update_agency_settings(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('settings.update'), [
            'agency_name' => 'Nexus Creative Studio',
        ]);

        $response->assertRedirect(route('settings'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nexus Creative Studio',
        ]);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect();
        $this->assertGuest();
    }
}
