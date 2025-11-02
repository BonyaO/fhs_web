<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        

        Artisan::call('shield:generate --all');
        Artisan::call('shield:super-admin', [
            '--user' => 1,
        ]);

        $this->call([
            JournalSettingsSeeder::class,
            EditorialBoardSeeder::class,
            VolumeSeeder::class,
            IssueSeeder::class,
            AuthorSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
