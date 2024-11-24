<?php

namespace App\Http\Resources;

use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\Guide\GuideResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class TourDetailResource extends JsonResource
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
            'overview' => $this->overview,
            'inclusions' => $this->inclusions,
            'exclusions' => $this->exclusions,
            'conditions' => $this->conditions,
            'price' => $this->price,
            'status' => $this->status,
            'featured' => $this->featured,
            'is_liked' => $this->is_liked,
            'location' => is_string($this->location ) ? json_decode($this->location) : $this->location,
            'start_location' => is_string($this->start_point) ? json_decode($this->start_point) : $this->start_point,
            'end_location' => is_string($this->end_point) ? json_decode($this->end_point) : $this->end_point,
            'max_packs' => $this->max_packs,
            'tour_days' => $this->whenLoaded('tour_days', fn($records) => TourDayResource::collection($records)),
            'tour_availability' => $this->whenLoaded('tour_availability',
                fn($records) => TourAvailabilityResource::collection($records)),
            'category' => $this->whenLoaded('category', fn ($record) => CategoryResource::make($record)),
            'user' => $this->whenLoaded('user', fn ($record) => UserResource::make($record)),
            'images' => $this->whenLoaded('images', fn ($records) => TourImageResource::collection($records)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
