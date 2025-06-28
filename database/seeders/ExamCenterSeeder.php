<?php

namespace Database\Seeders;

use App\Models\ExamCenter;
use Illuminate\Database\Seeder;

class ExamCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $centers = [
            'Bamenda',
            'Bafousssam',
            'Yaounde',
            'Douala',
        ];

        foreach ($centers as $center) {
            ExamCenter::create([
                'name' => $center,
            ]);
        }
    }
}
