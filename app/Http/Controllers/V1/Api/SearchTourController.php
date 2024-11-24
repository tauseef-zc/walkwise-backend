<?php

namespace App\Http\Controllers\V1\Api;

use App\Filters\TourSearchFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Services\TourService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as JsonCollection;
use Illuminate\Support\Facades\Auth;

class SearchTourController extends Controller
{
    private TourService $service;

    public function __construct(TourService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(TourSearchFilter $filter): JsonCollection | JsonResponse
    {
        $tours = $this->service->searchTours($filter);
        $tours->load([
            'category',
            'user',
            'images' => fn ($query) => $query->limit(4),
        ]);

        if(request()->user()) {
            $tours->load(['likes' => fn ($query) => $query->where('user_id', Auth::id())]);
        }

        return TourResource::collection($tours);
    }
}
