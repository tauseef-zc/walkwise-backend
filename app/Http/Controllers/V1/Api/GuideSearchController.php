<?php

namespace App\Http\Controllers\V1\Api;

use App\Filters\GuideSearchFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Guide\GuideResource;
use App\Services\GuideService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as JsonResource;

class GuideSearchController extends Controller
{
    private GuideService $service;

    public function __construct(GuideService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, GuideSearchFilter $filter): JsonResource
    {
        $guides = $this->service->search($filter);

        $guides->load([
            'user'
        ]);

        return GuideResource::collection($guides);
    }
}
