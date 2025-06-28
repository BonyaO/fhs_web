<?php

namespace Database\Seeders;

use App\Models\SubDivision;
use Illuminate\Database\Seeder;

class SubDivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubDivision::factory()->count(10)->create();
    }
}
