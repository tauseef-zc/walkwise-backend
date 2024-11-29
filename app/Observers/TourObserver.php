<?php

namespace App\Observers;

use App\Models\Tour;

class TourObserver
{
    public function creating(Tour $tour): Tour
    {
        $tour->location = json_decode($tour->location, true);
        $tour->start_point = json_decode($tour->start_point, true);
        $tour->end_point = json_decode($tour->end_point, true);

        return $tour;
    }

}
