<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Issue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(mt_rand(3, 8));
        $pageStart = $this->faker->numberBetween(1, 200);
        $pageEnd = $pageStart + $this->faker->numberBetween(1, 12);
        $isPublished = $this->faker->boolean(70);
        $publishedAt = $isPublished ? $this->faker->dateTimeBetween('-1 years', 'now') : null;

        return [
            'issue_id' => Issue::factory(),
            'title' => $title,
            'slug' => Article::generateUniqueSlug($title),
            'abstract' => $this->faker->paragraphs(mt_rand(2, 5), true),
            'keywords' => implode(', ', $this->faker->words(mt_rand(3, 6))),
            'page_start' => $pageStart,
            'page_end' => $pageEnd,
            'doi' => $this->faker->optional(0.6)->regexify('10\.\d{4,9}/[-._;()/:A-Za-z0-9]+'),
            'submission_date' => $this->faker->date(),
            'acceptance_date' => $this->faker->optional(0.6)->date(),
            'publication_date' => $this->faker->optional(0.6)->date(),
            'article_type' => $this->faker->randomElement(['research', 'review', 'case_report', 'editorial']),
            'language' => $this->faker->randomElement(['en', 'fr']),
            'license' => $this->faker->randomElement(['CC BY', 'CC BY-NC', 'All rights reserved']),
            'status' => $this->faker->randomElement(['submitted', 'under_review', 'accepted', 'published']),
            'is_published' => $isPublished,
            'view_count' => $this->faker->numberBetween(0, 5000),
            'download_count' => $this->faker->numberBetween(0, 2000),
            'featured' => $this->faker->boolean(10),
            'order' => $this->faker->numberBetween(1, 100),
            'published_at' => $publishedAt,
        ];
    }
}
