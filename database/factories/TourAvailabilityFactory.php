<?php

namespace Database\Factories;

use App\Models\TourAvailability;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<TourAvailability>
 */
class TourAvailabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seasonStart =now()->setDateFrom($this->faker->dateTimeBetween('now', '+1 years' ));
        $seasonEnd = now()->setDateFrom($seasonStart)->addMonths(2);
        return [
            'from' => $seasonStart->format('Y-m-d H:i:s'),
            'to' => $seasonEnd->format('Y-m-d H:i:s'),
        ];
    }
}
