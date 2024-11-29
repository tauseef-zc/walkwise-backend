<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Services\TourService;
use Illuminate\Http\Request;

class FeaturedToursController extends Controller
{
    private TourService $service;

    public function __construct(TourService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $tours = $this->service->getFeaturedTours();
        $tours->load([
            'category',
            'user',
            'images' => fn ($query) => $query->limit(4),
        ]);

        if(auth()->check()){
            $tours->load([ 'likes' => fn ($query) => $query->where('user_id', auth()->id())]);
        }

        return TourResource::collection($tours);
    }
}
