<?php

namespace App\Http\Controllers\V1\Api\Guide;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payments\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingDetailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Booking &$booking): BookingResource
    {
        $booking->load(['payment', 'user', 'tour', 'tour.images', 'tour.category']);
        return BookingResource::make($booking);
    }
}
