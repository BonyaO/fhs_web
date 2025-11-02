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
        Schema::create('volumes', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->comment('Volume number (1, 2, 3, etc.)');
            $table->year('year')->unique()->comment('Publication year');
            $table->text('description')->nullable()->comment('Optional volume description');
            $table->timestamp('published_at')->nullable()->comment('When the volume was published');
            $table->timestamps();

            // Indexes
            $table->index('number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volumes');
    }
};
