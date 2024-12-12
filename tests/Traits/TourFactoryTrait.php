<?php

namespace Tests\Traits;

use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourDay;
use Database\Factories\TourCategoryFactory;
use Database\Factories\TourDayFactory;
use Database\Factories\TourFactory;

trait TourFactoryTrait
{

    public function makeTourCategory(int $count = null): TourCategoryFactory
    {
        return TourCategory::factory()->count($count);
    }
    public function makeTour(int $count = null): TourFactory
    {
        return Tour::factory()->count($count);
    }

    public function makeTourDay(int $count = null, $tour = null): TourDayFactory
    {
        $tour = $tour ?? $this->makeTour();
        return TourDay::factory()->forTour($tour)->count($count);
    }

}
