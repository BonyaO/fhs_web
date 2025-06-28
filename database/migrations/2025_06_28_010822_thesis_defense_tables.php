<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('defenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->string('venue'); // Hall/Room
            $table->string('jury_number');
            
            // Student information
            $table->string('student_name');
            $table->string('registration_number');
            $table->text('thesis_title');
            $table->string('student_photo')->nullable();
            
            // Jury members
            $table->string('president_name');
            $table->string('president_title')->nullable();
            $table->string('rapporteur_name');
            $table->string('rapporteur_title')->nullable();
            
            // JSON field for jury members (president, rapporteur, and members)
            $table->json('jury_members'); // Will store array of jury member objects
            
            // Optional fields
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('defenses');
    }
};
