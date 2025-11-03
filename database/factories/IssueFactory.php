<?php

namespace Database\Factories;

use App\Models\Issue;
use App\Models\Volume;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Issue>
 */
class IssueFactory extends Factory
{
    protected $model = Issue::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $number = $this->faker->numberBetween(1, 12);
        $isPublished = true;
        $publicationDate = $isPublished ? $this->faker->dateTimeBetween('-3 years', 'now') : null;
        $publishedAt = $isPublished ? $publicationDate : null;

        return [
            'volume_id' => Volume::factory(),
            'number' => $number,
            'title' => $this->faker->optional(0.6)->sentence(mt_rand(3, 7)),
            'description' => $this->faker->optional(0.7)->paragraphs(mt_rand(1, 4), true),
            'cover_image' => $this->faker->boolean(40) ? $this->faker->lexify('cover_?????.jpg') : null,
            'publication_date' => $publicationDate ? $publicationDate->format('Y-m-d') : null,
            'is_published' => $isPublished,
            'published_at' => $publishedAt ? $publishedAt->format('Y-m-d H:i:s') : null,
        ];
    }
}
