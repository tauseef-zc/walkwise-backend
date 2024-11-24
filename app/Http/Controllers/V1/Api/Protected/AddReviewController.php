<?php

namespace App\Http\Controllers\V1\Api\Protected;

use App\Http\Controllers\Controller;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddReviewController extends Controller
{
    private ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();

        if($request->has(['booking_id', 'tour_id'])){
            $data = $request->only(['booking_id', 'tour_id', 'tour_rating', 'tour_review']);
            $data = [
                'booking_id' => $data['booking_id'],
                'tour_id' => $data['tour_id'],
                'rating' => $data['tour_rating'],
                'review' => $data['tour_review'],
                'user_id' => $user->id,
            ];
            $this->reviewService->addTourReview($data);
        }

        if($request->has(['guide_id'])){
            $data = $request->only(['guide_id', 'guide_rating', 'guide_review']);
            $data = [
                'reviewer' => $data['guide_id'],
                'rating' => $data['guide_rating'],
                'review' => $data['guide_review'],
                'user_id' => $user->id,
            ];
            $this->reviewService->addGuideReview($data);
        }

        return response()->json(['message' => 'Review added successfully.']);
    }
}
