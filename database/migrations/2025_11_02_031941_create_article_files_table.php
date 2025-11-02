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
        Schema::create('article_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->enum('file_type', ['pdf', 'supplementary', 'dataset', 'image'])->comment('Type of file');
            $table->string('file_path')->comment('Storage path to file');
            $table->string('original_filename')->comment('Original uploaded filename');
            $table->integer('file_size')->comment('File size in bytes');
            $table->string('mime_type', 100)->comment('File MIME type');
            $table->integer('version')->default(1)->comment('File version number');
            $table->text('description')->nullable()->comment('File description');
            $table->boolean('is_primary')->default(false)->comment('Primary PDF flag');
            $table->integer('download_count')->default(0)->comment('Download counter');
            $table->timestamps();

            // Indexes
            $table->index('file_type');
            $table->index(['article_id', 'is_primary']);
            $table->index(['article_id', 'file_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_files');
    }
};
