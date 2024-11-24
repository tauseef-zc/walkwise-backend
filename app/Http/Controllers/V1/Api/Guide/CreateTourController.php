<?php

namespace App\Http\Controllers\V1\Api\Guide;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guide\CreateTour;
use App\Models\Tour;
use App\Services\Guide\TourService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateTourController extends Controller
{
    private TourService $service;

    public function __construct(TourService $service)
    {
        $this->service = $service;
    }


    /**
     * @param CreateTour $request
     * @return JsonResponse
     */
    public function __invoke(CreateTour $request): JsonResponse
    {
        list($payload, $status) = $this->service->createTour($request->validated());
        return response()->json($payload, $status);
    }
}
