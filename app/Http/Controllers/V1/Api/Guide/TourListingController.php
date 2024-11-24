<?php

namespace App\Http\Controllers\V1\Api\Guide;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Services\Guide\TourService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as Pagination;

class TourListingController extends Controller
{
    private TourService  $tourService;

    public function __construct(TourService $tourService)
    {
        $this->tourService = $tourService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Pagination
    {
        $tours = $this->tourService->getTours();
        $tours->load([
            'category',
            'user',
            'images' => fn ($query) => $query->limit(4),
            'likes' => fn ($query) => $query->where('user_id', auth()->id())]);

        return TourResource::collection($tours);
    }
}
