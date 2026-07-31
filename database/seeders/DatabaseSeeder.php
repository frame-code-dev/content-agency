<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\InstagramAccount;
use App\Models\ContentPlan;
use App\Models\Competitor;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // 2. Create Super Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@agency.com'],
            [
                'name' => 'Isabella White',
                'password' => bcrypt('password'),
            ]
        );
        $admin->assignRole($superAdminRole);

        // 3. Create Demo Client User
        $client = User::firstOrCreate(
            ['email' => 'client@agency.com'],
            [
                'name' => 'Isabella White',
                'password' => bcrypt('password'),
            ]
        );
        $client->assignRole($clientRole);

        // 4. Create Instagram Account for Demo User
        $account = InstagramAccount::firstOrCreate(
            ['user_id' => $admin->id],
            [
                'instagram_account_id' => '17841400000000001',
                'username'             => 'isabella.white',
                'access_token'         => 'mock_access_token_demo_mode',
                'token_expires_at'     => now()->addDays(60),
            ]
        );

        // Ensure client also has account linked
        InstagramAccount::firstOrCreate(
            ['user_id' => $client->id],
            [
                'instagram_account_id' => '17841400000000002',
                'username'             => 'isabella.white',
                'access_token'         => 'mock_access_token_demo_mode',
                'token_expires_at'     => now()->addDays(60),
            ]
        );

        // 5. Seed Content Plans
        if (ContentPlan::count() === 0) {
            ContentPlan::create([
                'user_id'        => $admin->id,
                'title'          => 'Q3 Product Teaser Showcase',
                'topic'          => 'Product Launch',
                'concept'        => 'High energy video showcasing key product benefits',
                'caption'        => 'Discover the next evolution of AI content strategy! 🚀 #Launch',
                'tone'           => 'professional',
                'media_type'     => 'VIDEO',
                'scheduled_at'   => now()->addDays(3),
                'status'         => 'scheduled',
                'spk_score'      => 92,
                'priority_level' => 'Star Content',
            ]);

            ContentPlan::create([
                'user_id'        => $admin->id,
                'title'          => 'Customer Success Story Breakdown',
                'topic'          => 'Case Study',
                'concept'        => 'Carousel post with infographic metrics',
                'caption'        => 'How Brand X achieved 300% growth using our AI agency workflow 📊',
                'tone'           => 'informative',
                'media_type'     => 'CAROUSEL_ALBUM',
                'scheduled_at'   => now()->addDays(5),
                'status'         => 'scheduled',
                'spk_score'      => 88,
                'priority_level' => 'Star Content',
            ]);
        }

        // 6. Seed Competitors
        if (Competitor::count() === 0) {
            Competitor::create([
                'user_id'            => $admin->id,
                'username'           => '@techpulse_agency',
                'followers_count'    => 45200,
                'engagement_rate'    => 5.40,
                'avg_likes'          => 2100,
                'avg_comments'       => 180,
                'gap_analysis_notes' => 'High frequency video content; low response rate on comments.',
            ]);

            Competitor::create([
                'user_id'            => $admin->id,
                'username'           => '@creative_hub_id',
                'followers_count'    => 62100,
                'engagement_rate'    => 4.10,
                'avg_likes'          => 2450,
                'avg_comments'       => 120,
                'gap_analysis_notes' => 'Strong graphic carousel design, missing reel video optimization.',
            ]);
        }
    }
}
