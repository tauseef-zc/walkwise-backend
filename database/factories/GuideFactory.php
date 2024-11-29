<?php

namespace Database\Factories;

use App\Models\Guide;
use App\Models\User;
use Database\Factories\helpers\TourFactoryHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Guide>
 */
class GuideFactory extends Factory
{
    use TourFactoryHelper;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'bio' => $this->faker->text(),
            'expertise' => [$this->faker->word()],
            'experience' => $this->faker->numberBetween(1,10),
            'documents' => [$this->faker->filePath(), $this->faker->filePath()],
            'avatar' => '/guide/images/avatar.jpg',
            'location' => $this->getRandomLocation(),
            'rating' => $this->faker->numberBetween(1,5),
            'user_id' => $user->id,
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
