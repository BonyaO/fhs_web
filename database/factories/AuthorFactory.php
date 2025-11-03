<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $first = $this->faker->firstName();
        $last = $this->faker->lastName();

        return [
            'first_name'    => $first,
            'surname'       => $last,
            'email'         => $this->faker->unique()->safeEmail(),
            // 40% chance to generate an ORCID URL, otherwise null
            'orcid'         => $this->faker->boolean(40)
                                ? 'https://orcid.org/'.$this->faker->numerify('0000-####-####-####')
                                : null,
            'affiliation'   => $this->faker->company(),
            'department'    => $this->faker->optional(0.8)->jobTitle(),
            'bio'           => $this->faker->optional(0.9)->paragraph(),
            'country'       => $this->faker->country(),
            'website'       => $this->faker->optional()->url(),
            'google_scholar'=> $this->faker->optional(0.3)->regexify('https://scholar.google.com/citations\\?user=[A-Za-z0-9_-]{12}'),
        ];
    }
}
