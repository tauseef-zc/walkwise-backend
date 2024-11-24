<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\TourCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TourCategoryController extends Controller
{
    private TourCategory $category;

    public function __construct(TourCategory $category)
    {
        $this->category = $category;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->category->withCount('tours')->get());
    }

    public function getCategory(String $slug): JsonResponse
    {
        try {
            $category = $this->category->where('slug', $slug)->first();
            return response()->json(new CategoryResource($category));
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
