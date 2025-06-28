<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            'Far North' => [

            ],
            'North',
            'Adamawa' => [
                'Djérem',
                'Faro-et-Déo',
                'Mayo-Banyo',
                'Mbéré',
            ],
            'Centre' => [
                'Haute-Sanaga',
                'Lekié',
                'Mbam-et-Inoubou',
                'Mbam-et-Kim',
                'Méfou-et-Afamba',
                'Méfou-et-Akono',
            ],
            'Litoral',
            'North West',
            'West',
            'South West',
            'South',
            'East' => [
                'Boumba-et-Ngoko',
                'Haut-Nyong',
                'Kadey',
                'Lom-et-Djérem',
            ],
        ];
    }
}
