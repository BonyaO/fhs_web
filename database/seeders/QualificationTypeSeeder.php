<?php

namespace Database\Seeders;

use App\Models\QualificationType;
use Illuminate\Database\Seeder;

class QualificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'secondary school' => [
                'O/L General',
                'O/L Technical',
                'Probatoire',
            ],
            'high school' => [
                'A/L General',
                'A/L Technical',
                'Baccalaureat',
            ],
        ];

        foreach ($data as $level => $options) {
            foreach ($options as $option) {
                QualificationType::create([
                    'level' => $level,
                    'name' => $option,
                ]);
            }
        }
    }
}
