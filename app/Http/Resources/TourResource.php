<?php

namespace App\Http\Resources;

use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\Guide\GuideResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class TourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'category' => $this->whenLoaded('category', function ($record) {
                return CategoryResource::make($record);
            }),
            'user' => $this->whenLoaded('user', fn ($record) => UserResource::make($record)),
            'price' => $this->price,
            'images' => $this->whenLoaded('images', function ($records) {
                return TourImageResource::collection($records);
            }),
            'tour_availability' => $this->whenLoaded('tour_availability',
                fn($records) => TourAvailabilityResource::collection($records)),
            'status' => $this->status,
            'is_liked' => $this->is_liked,
            'rating' => $this->rating,
            'location' => is_string($this->location ) ? json_decode($this->location) : $this->location,
            'start_location' => is_string($this->start_point) ? json_decode($this->start_point) : $this->start_point,
            'end_location' => is_string($this->end_point) ? json_decode($this->end_point) : $this->end_point,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
