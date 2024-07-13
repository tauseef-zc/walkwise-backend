<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'unique:users', 'max:50'],
            'password' => ['required', 'confirmed', 'min:8', 'max:32'],
            'password_confirmation' => ['required', 'min:8', 'max:32'],
            'gender' => ['required'],
            'nationality' => ['sometimes', 'string'],
            'primary_lang' => ['sometimes', 'string', 'max:20'],
            'other_lang' => ['sometimes', 'string'],
        ];
    }
}
