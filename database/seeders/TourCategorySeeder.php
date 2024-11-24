<?php

namespace Database\Seeders;

use App\Models\TourCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TourCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            "Cultural Heritage" => "Ancient cities and temples showcase Sri Lanka's history",
            "Wildlife Safari" => "Experience diverse wildlife in pristine national parks",
            "Tea Plantation" => "Journey through misty hills of Ceylon tea",
            "Coastal & Beach" => "Tropical paradise with golden beaches and azure waters",
            "Ayurveda and Wellness" => "Traditional healing treatments for mind and body",
            "Cultural & Religious" => "Sacred temples and vibrant traditional ceremonies",
            "Romantic Tours" => "Intimate experiences in stunning scenic locations",
            "Adventure and Eco" => "Thrilling outdoor activities in natural landscapes"
        ];

        foreach ($categories as $category => $description) {
            TourCategory::create([
                'category' => $category,
                'slug' => Str::slug($category),
                'info' => $description,
                'image' => "categories/". Str::slug($category) . ".jpg"
            ]);
        }
    }
}
