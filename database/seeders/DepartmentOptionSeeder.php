<?php

namespace Database\Seeders;

use App\Models\DepartmentOption;
use Illuminate\Database\Seeder;

class DepartmentOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DepartmentOption::factory()->count(10)->create();
    }
}
