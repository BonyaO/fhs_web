<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::factory()->count(10)->create();
    }
}
