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
        User::create([
            'name' => 'testuser',
            'email' => 'user@test.com',
            'password' => Hash::make('testuser'),
            'isAdmin' => true,
        ]);

        Artisan::call('shield:generate --all');
        Artisan::call('shield:super-admin', [
            '--user' => 1,
        ]);

        $this->call([
            DepartmentOptionSeeder::class,
            SubDivisionSeeder::class,
            RegionSeeder::class,
            ExamCenterSeeder::class,
            QualificationTypeSeeder::class,
        ]);
    }
}
