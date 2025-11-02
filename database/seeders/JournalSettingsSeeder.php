<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JournalSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed journal settings
        \DB::table('journal_settings')->insert([
            'name' => 'FHS Journal',
            'issn' => '1234-5678',
            'publisher' => 'FHS Publishing',
            'contact_email' => 'contact@fhsjournal.com',
        ]);
    }
}
