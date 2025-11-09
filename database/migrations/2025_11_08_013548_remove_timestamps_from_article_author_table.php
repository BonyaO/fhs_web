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
        $cols = [];
        if (Schema::hasColumn('article_author', 'created_at')) {
            $cols[] = 'created_at';
        }
        if (Schema::hasColumn('article_author', 'updated_at')) {
            $cols[] = 'updated_at';
        }

        if (!empty($cols)) {
            Schema::table('article_author', function (Blueprint $table) use ($cols) {
                $table->dropColumn($cols);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $needs = false;
        if (!Schema::hasColumn('article_author', 'created_at') || !Schema::hasColumn('article_author', 'updated_at')) {
            $needs = true;
        }

        if ($needs) {
            Schema::table('article_author', function (Blueprint $table) {
                $table->timestamps();
            });
        }
    }
};
