<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('fullname')->after('country');
            $table->dropColumn(['name', 'surname']);
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('name')->after('country');
            $table->string('surname')->after('name');
            $table->dropColumn('fullname');
        });
    }
};