<?php

namespace Database\Factories;

use App\Models\EditorialBoard;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EditorialBoard>
 */
class EditorialBoardFactory extends Factory
{
    protected $model = EditorialBoard::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = [
            'editor_in_chief',
            'deputy_editor',
            'managing_editor',
            'associate_editor',
            'section_editor',
            'board_member',
            'advisory_board',
        ];

        $startDate = $this->faker->dateTimeBetween('-10 years', 'now');
        $endDate = $this->faker->boolean(30) ? $this->faker->dateTimeBetween($startDate, '+5 years') : null;
        $isActive = is_null($endDate) ? $this->faker->boolean(90) : $endDate > now();

        return [
            'name' => $this->faker->name(),
            'role' => $this->faker->randomElement($roles),
            'affiliation' => $this->faker->company(),
            'department' => $this->faker->optional(0.7)->companySuffix(),
            'country' => $this->faker->country(),
            'email' => $this->faker->unique()->safeEmail(),
            'bio' => $this->faker->optional(0.9)->paragraphs(mt_rand(1,3), true),
            'photo' => $this->faker->boolean(60) ? $this->faker->lexify('board_?????.jpg') : null,
            'orcid' => $this->faker->boolean(30) ? 'https://orcid.org/'.$this->faker->numerify('0000-####-####-####') : null,
            'google_scholar' => $this->faker->optional(0.25)->regexify('https://scholar.google.com/citations\\?user=[A-Za-z0-9_-]{12}'),
            'research_interests' => implode(', ', $this->faker->words(mt_rand(2,6))),
            'order' => $this->faker->numberBetween(1, 50),
            'is_active' => $isActive,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
        ];
    }
}
