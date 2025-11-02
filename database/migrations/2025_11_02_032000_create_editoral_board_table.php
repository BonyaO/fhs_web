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
        Schema::create('editorial_board', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Full name');
            $table->string('role', 100)->comment('editor_in_chief, associate_editor, board_member, etc.');
            $table->text('affiliation')->comment('Institutional affiliation');
            $table->string('department')->nullable()->comment('Department or division');
            $table->string('country', 100)->nullable()->comment('Country');
            $table->string('email')->nullable()->comment('Contact email');
            $table->text('bio')->nullable()->comment('Biography/credentials');
            $table->string('photo')->nullable()->comment('Path to photo');
            $table->string('orcid', 50)->nullable()->comment('ORCID identifier');
            $table->string('google_scholar')->nullable()->comment('Google Scholar profile');
            $table->text('research_interests')->nullable()->comment('Research areas');
            $table->integer('order')->default(0)->comment('Display order');
            $table->boolean('is_active')->default(true)->comment('Active status');
            $table->date('start_date')->nullable()->comment('Started serving date');
            $table->date('end_date')->nullable()->comment('Ended service date');
            $table->timestamps();

            // Indexes
            $table->index('role');
            $table->index('is_active');
            $table->index(['is_active', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editoral_board');
    }
};
