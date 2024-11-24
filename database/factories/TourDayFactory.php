<?php

namespace Database\Factories;

use App\Models\TourDay;
use Database\Factories\helpers\TourFactoryHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TourDay>
 */
class TourDayFactory extends Factory
{
    use TourFactoryHelper;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $index = $this->faker->numberBetween(0, 2);
        return [
            'title' => $this->faker->sentence(),
            'itinerary' => $this->faker->paragraph(),
            'location' => $this->getRandomLocation(),
            'accommodation' => ['At Hotel', 'At Resort', 'At Villa'][$index],
            'meal_plan' => ['Breakfast', 'Breakfast and Lunch', 'Breakfast, Lunch and Dinner'][$index],
        ];
    }


}
