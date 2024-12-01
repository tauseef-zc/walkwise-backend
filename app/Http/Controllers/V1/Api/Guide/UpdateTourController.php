<?php

namespace App\Http\Controllers\V1\Api\Guide;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guide\UpdateTour;
use App\Models\Tour;
use App\Services\Guide\TourService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateTourController extends Controller
{
    private TourService $service;

    public function __construct(TourService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateTour $request, Tour $tour): JsonResponse
    {
        list($payload, $status) = $this->service->updateTour($tour, $request->validated());
        return response()->json($payload, $status);
    }
}
