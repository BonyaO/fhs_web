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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100)->comment('Author\'s first name');
            $table->string('surname', 100)->comment('Author\'s last name');
            $table->string('email')->nullable()->comment('Author\'s email');
            $table->string('orcid', 50)->nullable()->unique()->comment('ORCID identifier');
            $table->text('affiliation')->nullable()->comment('Primary institutional affiliation');
            $table->string('department')->nullable()->comment('Department or division');
            $table->text('bio')->nullable()->comment('Author biography');
            $table->string('country', 100)->nullable()->comment('Country of affiliation');
            $table->string('website')->nullable()->comment('Personal/professional website');
            $table->string('google_scholar')->nullable()->comment('Google Scholar profile URL');
            $table->timestamps();

            // Indexes
            $table->index(['surname', 'first_name']);
            $table->index('email');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
