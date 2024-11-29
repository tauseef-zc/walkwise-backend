<?php

namespace App\Http\Controllers\V1\Api\Guide;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();
        $data = Cache::remember('dashboard_'.$user->id, now()->addHour(), function () use ($user) {

            $bookingCount = $user->guide_bookings()->count();
            $toursCount = $user->tours()->count();
            $earnings = $user->guide_bookings()->sum('total');
            $rating = $user->rating;

            return [
                'bookingCount' => $bookingCount,
                'toursCount' => $toursCount,
                'earnings' => $earnings,
                'rating' => $rating,
            ];
        });

        return response()->json($data);
    }
}
