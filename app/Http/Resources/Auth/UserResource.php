<?php

namespace App\Http\Resources\Auth;

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
            'email' => $this->email,
            'verified' => !is_null($this->email_verified_at),
            'status' => $this->status->toArray(),
            'gender' => $this->gender ? $this->gender->toArray() : null,
            'nationality' => $this->nationality,
            'primary_lang' => $this->primary_lang,
            'other_lang' => $this->other_lang,
            'newsletter' => $this->newsletter,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
