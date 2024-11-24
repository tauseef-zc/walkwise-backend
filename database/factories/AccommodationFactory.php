<?php

namespace Database\Factories;

use App\Models\Accommodation;
use App\Models\Guide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Accommodation>
 */
class AccommodationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $guide = Guide::inRandomOrder()->first();
        if ($guide === null) {
            $guide = Guide::factory()->create();
        }
        return [
            'name' => $this->faker->streetName(),
            'data' => null,
            'guide_id' => $guide->id
        ];
    }
}
