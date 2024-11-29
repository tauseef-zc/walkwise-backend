<?php

namespace App\Http\Resources\Traveler;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelerResource extends JsonResource
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
            'name' => $this->name,
            'phone' => $this->phone,
            'emergency_contact' => $this->emergency_contact,
            'accessibility' => $this->accessibility,
            'dietary_restrictions' => $this->dietary_restrictions,
            'interests' => $this->interests,
            'nationality' => $this->nationality,
        ];
    }
}
