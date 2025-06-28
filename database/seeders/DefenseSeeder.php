<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Defense;
use Carbon\Carbon;

class DefenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defenses = [
            [
                'date' => Carbon::parse('2025-07-16'),
                'time' => Carbon::parse('08:00'),
                'venue' => 'USP AMPHI B',
                'jury_number' => 'Jury N 1',
                'student_name' => 'BELLA BIYEGUE Régine',
                'registration_number' => '18M125',
                'thesis_title' => 'Aspects épidémiologiques diagnostiques et thérapeutiques des malformations congénitales de l\'appareil locomoteur de l\'enfant à HGOPY',
                'president_name' => 'HANDY EONE Daniel',
                'president_title' => 'Pr',
                'rapporteur_name' => 'MOUAFO TAMBO Faustin',
                'rapporteur_title' => 'Pr',
                'jury_members' => [
                    ['name' => 'NGO UM KINJEL Suzanne', 'title' => 'Pr'],
                    ['name' => 'FONKOUE Loïc', 'title' => 'Dr']
                ],
                'status' => 'scheduled'
            ],
            [
                'date' => Carbon::parse('2025-07-20'),
                'time' => Carbon::parse('10:00'),
                'venue' => 'AMPHI A',
                'jury_number' => 'Jury N 2',
                'student_name' => 'MARTIN DUPONT Jean',
                'registration_number' => '19M256',
                'thesis_title' => 'Étude comparative des techniques chirurgicales modernes dans le traitement des pathologies cardiovasculaires',
                'president_name' => 'BERNARD CLAIRE Marie',
                'president_title' => 'Pr',
                'rapporteur_name' => 'DURAND MICHEL Pierre',
                'rapporteur_title' => 'Dr',
                'jury_members' => [
                    ['name' => 'LEBLANC SOPHIE Anne', 'title' => 'Pr'],
                    ['name' => 'MOREAU ANTOINE Paul', 'title' => 'Dr'],
                    ['name' => 'GARCIA MARIA Elena', 'title' => 'Dr']
                ],
                'status' => 'scheduled'
            ],
            [
                'date' => Carbon::parse('2025-06-15'),
                'time' => Carbon::parse('14:00'),
                'venue' => 'SALLE 101',
                'jury_number' => 'Jury N 3',
                'student_name' => 'KOUAM ALICE Blandine',
                'registration_number' => '18M089',
                'thesis_title' => 'Impact de la nutrition sur le développement cognitif chez l\'enfant en milieu urbain camerounais',
                'president_name' => 'FOTSO JEAN Claude',
                'president_title' => 'Pr',
                'rapporteur_name' => 'MBALLA ESTELLE Rose',
                'rapporteur_title' => 'Dr',
                'jury_members' => [
                    ['name' => 'NKENG PAUL François', 'title' => 'Pr'],
                    ['name' => 'ATEBA MARIE Joséphine', 'title' => 'Dr']
                ],
                'status' => 'completed'
            ],
            [
                'date' => Carbon::parse('2025-07-25'),
                'time' => Carbon::parse('09:30'),
                'venue' => 'USP AMPHI B',
                'jury_number' => 'Jury N 4',
                'student_name' => 'TCHINDA BORIS Emmanuel',
                'registration_number' => '19M134',
                'thesis_title' => 'Nouvelles approches thérapeutiques dans la prise en charge des maladies infectieuses émergentes en Afrique subsaharienne',
                'president_name' => 'MUNA WALTER Henri',
                'president_title' => 'Pr',
                'rapporteur_name' => 'NDONGO FELIX Bertrand',
                'rapporteur_title' => 'Pr',
                'jury_members' => [
                    ['name' => 'ESSAME OYONO Jean-Louis', 'title' => 'Pr'],
                    ['name' => 'MBANGO CLAIRE Sylvie', 'title' => 'Dr'],
                    ['name' => 'AWONO PATRICK Serge', 'title' => 'Dr']
                ],
                'status' => 'scheduled',
                'notes' => 'Soutenance en présence de représentants du Ministère de la Santé Publique'
            ]
        ];

        foreach ($defenses as $defenseData) {
            Defense::create($defenseData);
        }
    }
}