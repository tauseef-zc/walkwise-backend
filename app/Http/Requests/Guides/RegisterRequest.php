<?php

namespace App\Http\Requests\Guides;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
       return [
            'bio' => ['sometimes', 'string'],
            'phone' => ['sometimes', 'required', 'string'],
            'experience' => ['sometimes', 'numeric'],
            'expertise' => ['sometimes', 'json'],
            'languages' => ['sometimes', 'string'],
            'rating' => ['sometimes', 'numeric'],
            'verified_at' => ['sometimes', 'date'],
            'has_vehicle' => ['sometimes', 'numeric'],
            'tourism_license' => ['sometimes', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048'],
            'registration_certificate' => ['sometimes', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048'],
            'avatar' => [
                'sometimes',
                Rule::when(is_string($this->avatar), ['string', 'starts_with:data:image']),
                Rule::when(!is_string($this->avatar), ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'])
            ],
        ];
    }
}
