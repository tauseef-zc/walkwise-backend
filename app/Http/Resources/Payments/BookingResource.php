<?php

namespace App\Http\Resources\Payments;

use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\TourResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'tour_id' => $this->tour_id,
            'user_id' => $this->user_id,
            'tour' => $this->whenLoaded('tour', fn($record) => TourResource::make($record)),
            'user' => $this->whenLoaded('user', fn($record) => UserResource::make($record)),
            'booking_date' => $this->booking_date,
            'total' => $this->total,
            'adults' => $this->adults,
            'children' => $this->children,
            'infants' => $this->infants,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status
        ];
    }
}
