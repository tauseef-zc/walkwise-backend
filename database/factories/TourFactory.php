<?php

namespace Database\Factories;

use App\Enums\TourStatusEnum;
use App\Models\Tour;
use App\Models\TourAvailability;
use App\Models\TourCategory;
use App\Models\TourDay;
use Database\Factories\helpers\TourFactoryHelper;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Tour>
 */
class TourFactory extends Factory
{
    use TourFactoryHelper;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $location = $this->getRandomLocation();
        $category = TourCategory::inRandomOrder()->first();
        $day = $this->faker->numberBetween(1, 5);
        $title = $location['name']." $day Days of ". $category->category ." Tour";

        return [
            //
            'title' => $title,
            'slug' => Str::slug($title),
            'location' => $this->getRandomLocation(),
            'overview' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 1000),
            'duration' => $day,
            'start_point' => $this->getRandomLocation(),
            'end_point' => $this->getRandomLocation(),
            'max_packs' => $this->faker->numberBetween(30, 60),
            'inclusions' => $this->faker->paragraph(),
            'exclusions' => $this->faker->paragraph(),
            'conditions' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(TourStatusEnum::cases()),
            'featured' => $this->faker->boolean(),
            'tour_category_id' => $category->id,
            'user_id' => $this->faker->numberBetween(1, 10),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Tour $tour) {
            for ($i = 1; $i < 8; $i++) {
                $index = $this->faker->numberBetween(1, 15);
                $tour->images()->create([
                    'image' => 'tours/images/tour-' . $index . '.jpg',
                ]);
            }

            TourDay::factory()->count($tour->duration ?? 1)->create([
                'tour_id' => $tour->id
            ]);

            TourAvailability::factory()->count(2)->create([
                'tour_id' => $tour->id
            ]);

        });
    }

}
