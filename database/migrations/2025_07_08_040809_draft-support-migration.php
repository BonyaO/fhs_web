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
        Schema::table('applications', function (Blueprint $table) {
            $table->boolean('is_draft')->default(false)->after('option');
            $table->timestamp('last_saved_at')->nullable()->after('is_draft');
            $table->json('step_completion')->nullable()->after('last_saved_at');
            
            // Add indexes for better performance
            $table->index('is_draft');
            $table->index(['user_id', 'is_draft']);
            $table->index('last_saved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropIndex(['is_draft']);
            $table->dropIndex(['user_id', 'is_draft']);
            $table->dropIndex(['last_saved_at']);
            
            $table->dropColumn([
                'is_draft',
                'last_saved_at',
                'step_completion'
            ]);
        });
    }
};