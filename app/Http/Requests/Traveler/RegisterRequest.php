<?php

namespace App\Http\Requests\Traveler;

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
            'avatar' => [
                'sometimes',
                Rule::when(is_string($this->avatar), ['string', 'starts_with:data:image']),
                Rule::when(!is_string($this->avatar), ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'])
            ],
            'passport_image' => ['sometimes', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048'],
            'phone' => ['sometimes', 'required', 'string'],
            'accessibility' => ['sometimes', 'json'],
            'interests' => ['sometimes', 'json'],
            'dietary_restrictions' => ['sometimes', 'string'],
            'nationality' => ['sometimes', 'string'],
            'emergency_contact' => ['sometimes', 'json'],
            'primary_lang' => ['sometimes', 'string'],
            'other_lang' => ['sometimes', 'json'],
        ];
    }
}
