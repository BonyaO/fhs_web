<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JournalSettings>
 */
class JournalSettingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->company() . ' Journal';
        $acronym = strtoupper(substr(preg_replace('/[^A-Za-z0-9 ]/', '', $name), 0, 3));
        $isIndexed = $this->faker->boolean(50);

        return [
            'journal_name' => $name,
            'journal_acronym' => $this->faker->optional(0.6)->regexify('[A-Z]{2,6}') ?? $acronym,
            'tagline' => $this->faker->optional(0.7)->catchPhrase(),
            'description' => $this->faker->optional(0.9)->paragraphs(mt_rand(2, 5), true),
            'issn_print' => $this->faker->optional(0.6)->regexify('\d{4}-\d{4}'),
            'issn_online' => $this->faker->optional(0.5)->regexify('\d{4}-\d{4}'),
            'publisher' => $this->faker->company(),
            'publication_frequency' => $this->faker->randomElement(['Monthly', 'Quarterly', 'Biannual', 'Annual']),
            'contact_email' => $this->faker->safeEmail(),
            'submission_email' => $this->faker->optional(0.9)->safeEmail(),
            'copyright_policy' => $this->faker->optional(0.8)->sentence(),
            'open_access_statement' => $this->faker->optional(0.8)->paragraph(),
            'ethical_guidelines' => $this->faker->optional(0.7)->paragraphs(mt_rand(1,3), true),
            'peer_review_policy' => $this->faker->optional(0.8)->sentence(),
            'submission_guidelines' => $this->faker->optional(0.9)->paragraphs(mt_rand(1,4), true),
            'manuscript_preparation' => $this->faker->optional(0.8)->paragraphs(mt_rand(1,3), true),
            'indexing_info' => $isIndexed ? implode(', ', $this->faker->words(mt_rand(2,5))) : null,
            'logo' => $this->faker->boolean(50) ? $this->faker->lexify('logo_????.png') : null,
            'cover_default' => $this->faker->boolean(40) ? $this->faker->lexify('cover_default_???.jpg') : null,
            'twitter' => $this->faker->optional(0.5)->regexify('@[A-Za-z0-9_]{3,15}'),
            'facebook' => $this->faker->optional(0.4)->url(),
            'linkedin' => $this->faker->optional(0.4)->url(),
        ];
    }
}
