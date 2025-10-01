<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('content');
            $table->enum('content_type', ['text', 'link', 'image'])->default('text');
            $table->string('url')->nullable();
            $table->string('image_path')->nullable();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('subreddit_id')->constrained()->onDelete('cascade');
            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);
            $table->integer('score')->default(0);
            $table->integer('comment_count')->default(0);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
