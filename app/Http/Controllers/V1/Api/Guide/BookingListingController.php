<?php

namespace App\Http\Controllers\V1\Api\Guide;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payments\BookingResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as JsonResource;

class BookingListingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResource
    {
        $bookings = $request->user()->guide_bookings()->latest()->paginate(10);
        $bookings->load(['payment', 'tour', 'tour.images', 'user']);

        return BookingResource::collection($bookings);
    }
}
