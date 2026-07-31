<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlannerAndCompetitorsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_access_planner_page_and_create_plan()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('planner.index'));
        $response->assertStatus(200);
        $response->assertSee('AI Content Planner');

        $storeResponse = $this->post(route('planner.store'), [
            'title'        => 'Strategi Reels Viral 2026',
            'topic'        => 'Social Media Marketing',
            'concept'      => 'Trik membuat 3 detik pertama Reels lebih menarik',
            'tone'         => 'casual',
            'media_type'   => 'VIDEO',
            'c1_engagement' => 9,
            'c2_effort'     => 3,
            'c3_trend'      => 9,
            'c4_brand'      => 8,
        ]);

        $storeResponse->assertRedirect(route('planner.index'));
        $this->assertDatabaseHas('content_plans', [
            'title' => 'Strategi Reels Viral 2026',
        ]);
    }

    public function test_can_access_competitors_page_and_add_competitor()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('competitors.index'));
        $response->assertStatus(200);
        $response->assertSee('Competitor Intelligence');

        $storeResponse = $this->post(route('competitors.store'), [
            'username' => 'brand_kompetitor_a',
        ]);

        $storeResponse->assertRedirect(route('competitors.index'));
        $this->assertDatabaseHas('competitors', [
            'username' => '@brand_kompetitor_a',
        ]);
    }
}
