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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_id')->constrained()->onDelete('cascade');
            $table->string('title', 500)->comment('Article title');
            $table->string('slug')->unique()->comment('URL-friendly identifier');
            $table->text('abstract')->comment('Article abstract');
            $table->text('keywords')->nullable()->comment('Article keywords');
            $table->integer('page_start')->nullable()->comment('Starting page number');
            $table->integer('page_end')->nullable()->comment('Ending page number');
            $table->string('doi', 100)->nullable()->unique()->comment('Digital Object Identifier');
            $table->date('submission_date')->nullable()->comment('Date submitted');
            $table->date('acceptance_date')->nullable()->comment('Date accepted');
            $table->date('publication_date')->nullable()->comment('Date published');
            $table->string('article_type', 50)->default('research')->comment('Type: research, review, case_study, editorial');
            $table->string('language', 10)->default('en')->comment('Article language code');
            $table->string('license', 50)->default('CC-BY-4.0')->comment('Open access license');
            $table->enum('status', ['draft', 'under_review', 'accepted', 'published', 'rejected'])->default('draft');
            $table->boolean('is_published')->default(false)->comment('Publication status flag');
            $table->integer('view_count')->default(0)->comment('Total views counter');
            $table->integer('download_count')->default(0)->comment('Total downloads counter');
            $table->boolean('featured')->default(false)->comment('Featured article flag');
            $table->integer('order')->default(0)->comment('Order within issue');
            $table->timestamps();
            $table->timestamp('published_at')->nullable()->comment('When made publicly available');

            // Indexes
            $table->index('status');
            $table->index('is_published');
            $table->index('publication_date');
            $table->index('article_type');
            $table->index('featured');
            $table->index(['issue_id', 'order']);
            
           
            // TODO: Add this via raw SQL after migration if needed:
            // DB::statement('ALTER TABLE articles ADD FULLTEXT search_index(title, abstract, keywords)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
