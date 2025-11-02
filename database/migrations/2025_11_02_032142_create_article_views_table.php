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
        Schema::create('article_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->enum('view_type', ['abstract_view', 'pdf_download', 'full_view'])->comment('Type of view/interaction');
            $table->string('ip_address', 45)->nullable()->comment('Visitor IP address (IPv6 compatible)');
            $table->text('user_agent')->nullable()->comment('Browser user agent');
            $table->string('referer', 500)->nullable()->comment('Referring URL');
            $table->string('country', 100)->nullable()->comment('Visitor country (from IP)');
            $table->timestamp('created_at')->useCurrent()->comment('View/download timestamp');

            // Indexes
            $table->index(['article_id', 'created_at']);
            $table->index('view_type');
            $table->index('created_at');
            $table->index(['article_id', 'view_type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_views');
    }
};
