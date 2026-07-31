<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('topic')->nullable();
            $table->text('concept')->nullable();
            $table->text('caption')->nullable();
            $table->string('tone')->default('professional');
            $table->string('media_type')->default('IMAGE');
            $table->dateTime('scheduled_at')->nullable();
            $table->string('status')->default('draft'); // draft, scheduled, published
            $table->integer('spk_score')->default(75);
            $table->string('priority_level')->default('Star Content'); // Star Content, Medium Priority, Needs Refactoring
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_plans');
    }
};
