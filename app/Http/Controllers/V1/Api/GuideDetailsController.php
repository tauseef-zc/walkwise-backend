<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Guide\GuideResource;
use App\Http\Resources\TourResource;
use App\Models\Guide;
use App\Services\Guide\TourService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as Pagination;

class GuideDetailsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Guide $guide): Pagination
    {
        $guide->load(['user']);

        $tours = app(TourService::class)->getToursByUser($guide->user_id);
        $tours->load([
            'category',
            'user',
            'images' => fn ($query) => $query->limit(4),
            'likes' => fn ($query) => $query->where('user_id', auth()->id())]);

        return TourResource::collection($tours)->additional(['guide' => GuideResource::make($guide)]);
    }
}
