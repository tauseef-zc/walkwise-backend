<?php

namespace App\Http\Resources\Payments;

use App\Http\Resources\Auth\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'user' => $this->whenLoaded('user', fn($record) => UserResource::make($record)),
            'booking' => $this->whenLoaded('booking', fn($record) => BookingResource::make($record)),
            'amount' => $this->amount,
            'transaction_id' => $this->transaction_id,
            'transaction_ref' => $this->transaction_ref,
            'payment_date' => $this->payment_date,
            'status' => $this->status
        ];
    }
}
