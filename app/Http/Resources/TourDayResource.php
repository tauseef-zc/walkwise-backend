<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourDayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'itinerary' => $this->itinerary,
            'location' => $this->location,
            'accommodation' => $this->accommodation,
            'meal_plan' => $this->meal_plan,
            'order' => $this->order
        ];
    }
}
