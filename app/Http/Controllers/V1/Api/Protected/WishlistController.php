<?php

namespace App\Http\Controllers\V1\Api\Protected;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Services\TourService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as JsonCollection;

class WishlistController extends Controller
{
    private TourService $service;

    public function __construct(TourService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     * @param Request $request
     * @return JsonCollection
     */
    public function __invoke(Request $request): JsonCollection
    {
        $tours = $this->service->getLikedTours();
        $tours->load([
            'category',
            'user',
            'likes' => fn($query) => $query->where('user_id', auth()->id()),
            'images' => fn ($query) => $query->limit(4),
        ]);

        return TourResource::collection($tours);
    }
}
