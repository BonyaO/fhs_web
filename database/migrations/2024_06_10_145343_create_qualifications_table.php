<?php

use App\Models\Application;
use App\Models\QualificationType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Application::class);
            $table->foreignIdFor(QualificationType::class);
            $table->string('school');
            $table->float('points');
            $table->string('year', 4);
            $table->string('certificate');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qualifications');
    }
};
