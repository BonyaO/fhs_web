<?php

namespace Database\Factories;

use App\Models\Volume;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Volume>
 */
class VolumeFactory extends Factory
{
    protected $model = Volume::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $number = $this->faker->numberBetween(1, 50);
        $year = $this->faker->numberBetween(1990, (int) date('Y'));

        // published_at is optional on the Volume model
        $publishedAt = $this->faker->boolean(65)
            ? $this->faker->dateTimeBetween("{$year}-01-01", "{$year}-12-31")
            : null;

        return [
            // fields defined in Volume::$fillable
            'number' => $number,
            'year' => $year,
            'description' => $this->faker->optional(0.7)->paragraphs(mt_rand(1, 4), true),
            'published_at' => $publishedAt ? $publishedAt->format('Y-m-d H:i:s') : null,
        ];
    }
}
