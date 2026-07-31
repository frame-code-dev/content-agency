<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add analytics metrics & JSON insights data to instagram_accounts table
        Schema::table('instagram_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('followers_count')->default(0)->after('profile_picture_url');
            $table->unsignedBigInteger('follows_count')->default(0)->after('followers_count');
            $table->unsignedBigInteger('media_count')->default(0)->after('follows_count');
            $table->unsignedBigInteger('reach')->default(0)->after('media_count');
            $table->unsignedBigInteger('impressions')->default(0)->after('reach');
            $table->string('engagement_rate')->default('0%')->after('impressions');
            $table->unsignedBigInteger('profile_views')->default(0)->after('engagement_rate');
            $table->boolean('is_live_api')->default(false)->after('profile_views');
            $table->json('insights_data')->nullable()->after('is_live_api');
            $table->timestamp('last_synced_at')->nullable()->after('insights_data');
        });

        // 2. Create instagram_posts table to persist fetched/synced posts in database
        Schema::create('instagram_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instagram_account_id')->constrained()->onDelete('cascade');
            $table->string('instagram_post_id')->unique();
            $table->text('caption')->nullable();
            $table->string('media_type')->default('IMAGE');
            $table->text('media_url')->nullable();
            $table->text('permalink')->nullable();
            $table->unsignedInteger('like_count')->default(0);
            $table->unsignedInteger('comments_count')->default(0);
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instagram_posts');

        Schema::table('instagram_accounts', function (Blueprint $table) {
            $table->dropColumn([
                'followers_count',
                'follows_count',
                'media_count',
                'reach',
                'impressions',
                'engagement_rate',
                'profile_views',
                'is_live_api',
                'insights_data',
                'last_synced_at',
            ]);
        });
    }
};
