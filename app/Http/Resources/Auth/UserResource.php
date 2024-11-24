<?php

namespace App\Http\Resources\Auth;

use App\Enums\UserTypesEnum;
use App\Http\Resources\Guide\GuideResource;
use App\Http\Resources\Traveler\TravelerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'verified' => $this->hasVerifiedEmail(),
            'status' => $this->status->toArray(),
            'avatar' => isset($resource) && !empty($resource) && !empty($resource->avatar)? '/'.$this->user_type->value.'/images/'.$resource->avatar : null,
            'gender' => $this->gender ? $this->gender->toArray() : null,
            'nationality' => $this->nationality,
            'primary_lang' => $this->primary_lang,
            'other_lang' => $this->other_lang,
            'newsletter' => $this->newsletter,
            'onboarding' => $this->onboarding,
            'user_type' => $this->user_type->value,
            'guide' => $this->whenLoaded('guide', fn($record) => GuideResource::make($record)),
            'traveler' => $this->whenLoaded('traveler', fn($record) => TravelerResource::make($record)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
