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
        Schema::create('comments', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('content');
            $table->foreignUuid('user_id')->constrained();
            $table->foreignUuid('post_id')->constrained();
            // relacionamento hierárquico (com a própria tabela), uso outro tabela para declarar a relação
            $table->uuid('parent_id')->nullable();

            // estratégia de Materialized Path
            $table->integer('depth')->default(0);
            $table->string('path', 1000)->nullable();

            // votação
            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);
            $table->integer('score')->default(0);

            $table->timestamps();

            $table->index(['post_id', 'path']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
