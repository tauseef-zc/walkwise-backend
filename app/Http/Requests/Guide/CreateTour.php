<?php

namespace App\Http\Requests\Guide;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateTour extends FormRequest
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
            'title' => 'required|string',
            'overview' => 'required|string',
            'location' => 'required',
            'tour_category_id' => 'required|integer',
            'price' => 'required|integer',
            'start_point' => 'required',
            'end_point' => 'required',
            'max_packs' => 'required|integer',
            'inclusions' => 'sometimes|string',
            'exclusions' => 'sometimes|string',
            'conditions' => 'sometimes|string',
            'tour_days'  => 'sometimes|required|array',
            'tour_dates'  => 'sometimes|required|array',
            'tour_images'  => 'sometimes|required|array',
            'tour_images.*'  => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }

    public function messages(): array
    {
        $messages = parent::messages();
        $messages['tour_images.*'] = 'Please upload a valid image';

        return $messages;
    }
}
