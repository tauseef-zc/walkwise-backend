<?php

namespace App\Http\Resources\Guide;

use App\Http\Resources\Auth\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property array $accessibility
 * @property array $interests
 * @property string $bio
 * @property int $id
 */
class GuideResource extends JsonResource
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
            'rating' => $this->rating,
            'verified_at' => $this->verified_at,
            'user_id' => $this->user_id,
            'location' => $this->location,
            'user' => $this->whenLoaded('user', fn ($record) => UserResource::make($record)),
        ];
    }
}
