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
        Schema::create('journal_settings', function (Blueprint $table) {
            $table->id();
            $table->string('journal_name')->default('African Annals of Health Sciences')->comment('Official journal name');
            $table->string('journal_acronym', 50)->nullable()->comment('Short name/acronym');
            $table->string('tagline', 500)->nullable()->comment('Journal tagline/motto');
            $table->text('description')->comment('Journal scope and aims');
            $table->string('issn_print', 20)->nullable()->comment('Print ISSN');
            $table->string('issn_online', 20)->nullable()->comment('Online ISSN');
            $table->string('publisher')->nullable()->comment('Publisher name');
            $table->string('publication_frequency', 100)->default('Biannual')->comment('How often published');
            $table->string('contact_email')->comment('Primary contact email');
            $table->string('submission_email')->nullable()->comment('Submission-specific email');
            $table->text('copyright_policy')->nullable()->comment('Copyright policy text');
            $table->text('open_access_statement')->nullable()->comment('Open access policy');
            $table->text('ethical_guidelines')->nullable()->comment('Ethical guidelines');
            $table->text('peer_review_policy')->nullable()->comment('Peer review process');
            $table->text('submission_guidelines')->nullable()->comment('Author submission guidelines');
            $table->text('manuscript_preparation')->nullable()->comment('Manuscript formatting instructions');
            $table->text('indexing_info')->nullable()->comment('Where journal is indexed');
            $table->string('logo')->nullable()->comment('Journal logo path');
            $table->string('cover_default')->nullable()->comment('Default cover image');
            $table->string('twitter', 100)->nullable()->comment('Twitter handle');
            $table->string('facebook')->nullable()->comment('Facebook page');
            $table->string('linkedin')->nullable()->comment('LinkedIn page');
            $table->timestamps();
        });

        // Insert default settings row
        DB::table('journal_settings')->insert([
            'journal_name' => 'African Annals of Health Sciences',
            'description' => 'A peer-reviewed open access journal publishing original research in health sciences.',
            'publication_frequency' => 'Biannual',
            'contact_email' => 'editor@africanannals.org',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_settings');
    }
};
