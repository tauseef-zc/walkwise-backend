<?php

namespace App\Http\Controllers\V1\Api\Protected;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Services\TourService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RemoveFromWishlistController extends Controller
{
    private TourService $service;

    public function __construct(TourService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     * @param Request $request
     * @param Tour $tour
     * @return JsonResponse
     */
    public function __invoke(Request $request, Tour $tour): JsonResponse
    {
        $this->service->removeFromWishlist($tour);
        return response()->json([], Response::HTTP_ACCEPTED);
    }
}
