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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volume_id')->constrained()->onDelete('cascade');
            $table->integer('number')->comment('Issue number within volume');
            $table->string('title')->nullable()->comment('Optional issue title/theme');
            $table->text('description')->nullable()->comment('Issue description');
            $table->string('cover_image')->nullable()->comment('Path to cover image');
            $table->date('publication_date')->comment('Official publication date');
            $table->boolean('is_published')->default(false)->comment('Publication status');
            $table->timestamp('published_at')->nullable()->comment('When made publicly available');
            $table->timestamps();

            // Indexes
            $table->unique(['volume_id', 'number']);
            $table->index('publication_date');
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
