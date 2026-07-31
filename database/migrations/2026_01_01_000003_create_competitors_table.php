<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('username');
            $table->integer('followers_count')->default(1000);
            $table->decimal('engagement_rate', 5, 2)->default(3.50);
            $table->integer('avg_likes')->default(150);
            $table->integer('avg_comments')->default(15);
            $table->text('gap_analysis_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competitors');
    }
};
