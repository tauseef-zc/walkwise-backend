<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'rating' => $this->rating,
            'review' => $this->review,
            'reviewer' => $this->whenLoaded('user', fn($record) => [
                'id' => $record->id,
                'name' => $record->name,
                'email' => $record->email,
                'avatar' => $record->avatar,
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
