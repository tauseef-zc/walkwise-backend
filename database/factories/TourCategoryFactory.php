<?php

namespace Database\Factories;

use App\Models\TourCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TourCategory>
 */
class TourCategoryFactory extends Factory
{

    private array $categories = [
        "Cultural Heritage",
        "Wildlife Safari",
        "Tea Plantation",
        "Coastal & Beach",
        "Ayurveda and Wellness",
        "Cultural & Religious",
        "Romantic Tours",
        "Adventure and Eco"
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = $this->faker->randomElement($this->categories);
        return [
            'category' => $category,
            'slug' => Str::slug($category),
            'info' => $this->faker->sentence(1),
            'image' => "categories/". Str::slug($category) . ".jpg"
        ];
    }
}
