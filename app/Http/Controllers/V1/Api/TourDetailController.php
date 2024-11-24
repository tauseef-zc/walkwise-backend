<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourDetailResource;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourDetailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Tour $tour): TourDetailResource
    {
        $tour->load([
            'likes' => fn ($query) => $query->where('user_id', auth()->id()),
            'user',
            'user.guide',
            'images',
            'category',
            'tour_days',
            'tour_availability'
        ]);

        return TourDetailResource::make($tour);
    }
}
