<?php

namespace Database\Factories;

use App\Models\Guide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Guide>
 */
class GuideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'bio' => $this->faker->text(),
            'expertise' => [$this->faker->word()],
            'experience' => $this->faker->numberBetween(1,10),
            'document' => $this->faker->filePath(),
            'avatar' => $this->faker->imageUrl(),
            'languages' => $this->faker->languageCode(),
            'rating' => $this->faker->numberBetween(1,5)
        ];
    }

    /**
     * Indicate that the model's Guide should be verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verified_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }

}
