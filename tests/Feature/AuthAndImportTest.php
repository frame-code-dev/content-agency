<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\InstagramAccount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuthAndImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_username_email_and_password(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'Agus Pratama',
            'username'              => 'aguspratama',
            'email'                 => 'agus@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'username' => 'aguspratama',
            'email'    => 'agus@example.com',
        ]);
    }

    public function test_user_can_login_with_username(): void
    {
        $user = User::factory()->create([
            'username' => 'clientusername',
            'email'    => 'client@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/login', [
            'email'    => 'clientusername',
            'password' => 'secret123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard'));
    }

    public function test_user_can_login_with_email(): void
    {
        $user = User::factory()->create([
            'username' => 'clientusername',
            'email'    => 'client@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/login', [
            'email'    => 'client@example.com',
            'password' => 'secret123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard'));
    }

    public function test_user_can_import_instagram_json_export(): void
    {
        $user = User::factory()->create([
            'username' => 'igclient',
            'email'    => 'igclient@example.com',
        ]);

        $jsonPayload = [
            'username'        => 'brand.agency.id',
            'name'            => 'Brand Agency ID',
            'followers_count' => 5400,
            'follows_count'   => 410,
            'posts'           => [
                [
                    'id'             => 'post_101',
                    'caption'        => 'Peluncuran produk AI Marketing Cineart',
                    'media_type'     => 'IMAGE',
                    'media_url'      => 'https://example.com/img1.jpg',
                    'like_count'     => 320,
                    'comments_count' => 42,
                    'timestamp'      => now()->toIso8601String(),
                ],
                [
                    'id'             => 'post_102',
                    'caption'        => 'Tips UI/UX modern untuk agensi',
                    'media_type'     => 'IMAGE',
                    'media_url'      => 'https://example.com/img2.jpg',
                    'like_count'     => 510,
                    'comments_count' => 68,
                    'timestamp'      => now()->subDays(2)->toIso8601String(),
                ],
            ],
        ];

        $jsonFile = UploadedFile::fake()->createWithContent('instagram_export.json', json_encode($jsonPayload));

        $response = $this->actingAs($user)->postJson('/auth/instagram/import-zip', [
            'export_file' => $jsonFile,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('instagram_accounts', [
            'user_id'  => $user->id,
            'username' => 'brand.agency.id',
        ]);

        $account = InstagramAccount::where('user_id', $user->id)->first();
        $this->assertCount(2, $account->posts);
        $this->assertEquals(5400, $account->followers_count);
        $this->assertEquals(410, $account->follows_count);
    }

    public function test_user_can_import_real_follower_and_following_counts(): void
    {
        $user = User::factory()->create([
            'username' => 'rifjan_user',
            'email'    => 'rifjan@example.com',
        ]);

        $jsonPayload = [
            'username'        => 'rifjanj',
            'name'            => 'Rifjan',
            'followers_count' => 755,
            'follows_count'   => 1153,
            'posts'           => [
                ['id' => 'p1', 'caption' => 'Post 1', 'like_count' => 50, 'comments_count' => 5],
            ],
        ];

        $jsonFile = UploadedFile::fake()->createWithContent('instagram_export.json', json_encode($jsonPayload));

        $response = $this->actingAs($user)->postJson('/auth/instagram/import-zip', [
            'export_file' => $jsonFile,
        ]);

        $response->assertStatus(200);

        $account = InstagramAccount::where('user_id', $user->id)->first();
        $this->assertEquals('rifjanj', $account->username);
        $this->assertEquals(755, $account->followers_count);
        $this->assertEquals(1153, $account->follows_count);
    }

    public function test_user_can_import_real_user_meta_zip_file(): void
    {
        $realZipPath = '/home/whoami/Downloads/instagram-rifjanj-2026-08-01-cTAhcN80.zip';
        if (!file_exists($realZipPath)) {
            $this->assertTrue(true);
            return;
        }

        $user = User::factory()->create([
            'username' => 'test_real_zip',
            'email'    => 'realzip@example.com',
        ]);

        $service = new \App\Services\InstagramImportService();
        $result = $service->importFromZipPath($user, $realZipPath);

        $this->assertTrue($result['success']);

        $account = InstagramAccount::where('user_id', $user->id)->first();
        $this->assertNotNull($account);
        $this->assertEquals('rifjanj', $account->username);
        $this->assertEquals('Rifjan', $account->name);
        $this->assertEquals(755, $account->followers_count);
        $this->assertEquals(1204, $account->follows_count);
        $this->assertEquals(5996, $account->reach);
        $this->assertEquals(28892, $account->impressions);
        $this->assertEquals(740, $account->profile_views);
        $this->assertEquals('54.7%', $account->insights_data['male_pct']);
        $this->assertEquals('45.2%', $account->insights_data['female_pct']);
    }

    public function test_user_can_upload_instagram_export_in_chunks(): void
    {
        $user = User::factory()->create([
            'username' => 'igchunkuser',
            'email'    => 'chunk@example.com',
        ]);

        $jsonPayload = json_encode([
            'username'        => 'chunked.brand.id',
            'name'            => 'Chunked Brand ID',
            'followers_count' => 9800,
            'posts'           => [
                ['id' => 'chunk_p1', 'caption' => 'Chunked Post 1', 'like_count' => 450],
            ],
        ]);

        $fileId = 'test_chunk_' . time();
        $chunkFile = UploadedFile::fake()->createWithContent('chunk_export.json', $jsonPayload);

        $response = $this->actingAs($user)->postJson('/auth/instagram/upload-chunk', [
            'file_chunk'   => $chunkFile,
            'file_id'      => $fileId,
            'chunk_index'  => 0,
            'total_chunks' => 1,
            'file_name'    => 'export.json',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success'     => true,
            'is_complete' => true,
        ]);

        $this->assertDatabaseHas('instagram_accounts', [
            'user_id'         => $user->id,
            'username'        => 'chunked.brand.id',
            'followers_count' => 9800,
        ]);
    }
}
