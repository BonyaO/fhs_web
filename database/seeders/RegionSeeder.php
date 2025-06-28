<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = ['Far North', 'North', 'Adamawa', 'Centre', 'Litoral', 'North West', 'West', 'South West', 'South', 'East'];
        foreach ($regions as $region) {
            Region::create([
                'name' => $region,
            ]);
        }
    }
}
