<?php

namespace App\Http\Controllers\V1\Api\Protected;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Tour;
use App\Models\User;
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
        $response = [];
        $user = $request->user();

        if($request->has(['booking_id', 'tour_id'])){
            $data = $request->only(['booking_id', 'tour_id', 'tour_rating', 'tour_review']);
            $tour = Tour::find($data['tour_id']);
            $data = [
                'booking_id' => $data['booking_id'],
                'tour_id' => $data['tour_id'],
                'rating' => $data['tour_rating'],
                'review' => $data['tour_review'],
                'reviewer' => $user->id,
            ];
            $review = $this->reviewService->addTourReview($data);
            $review->load(['user']);

            $tour->update([
                'rating' => $tour->reviews()->average('rating')
            ]);

            $response['tourReview'] = ReviewResource::make($review);
        }

        if($request->has('guide_id')){
            $data = $request->only(['guide_id', 'guide_rating', 'guide_review']);
            $user = User::find($data['guide_id']);

            $data = [
                'user_id' => $data['guide_id'],
                'rating' => $data['guide_rating'],
                'review' => $data['guide_review'],
                'reviewer' => $user->id,
            ];
            $response['guideReview'] = $this->reviewService->addGuideReview($data);
            $user->update([
                'rating' => $user->reviews()->average('rating')
            ]);
        }

        return response()->json($response);
    }
}
