<?php

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
        Schema::create('article_author', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('author_id')->constrained()->onDelete('cascade');
            $table->integer('author_order')->comment('Order in author list (1, 2, 3...)');
            $table->boolean('is_corresponding')->default(false)->comment('Corresponding author flag');
            $table->text('affiliation_at_time')->nullable()->comment('Affiliation when article published');
            $table->text('contribution')->nullable()->comment('Author\'s specific contribution');

            // Indexes
            $table->unique(['article_id', 'author_id']);
            $table->index('author_order');
            $table->index(['article_id', 'author_order']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_author');
    }
};
