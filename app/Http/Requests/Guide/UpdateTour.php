<?php

namespace App\Http\Requests\Guide;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTour extends FormRequest
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
            'title' => 'sometimes|string',
            'overview' => 'sometimes|string',
            'location' => 'sometimes',
            'tour_category_id' => 'sometimes|integer',
            'price' => 'sometimes|integer',
            'start_point' => 'sometimes',
            'end_point' => 'sometimes',
            'max_packs' => 'sometimes|integer',
            'inclusions' => 'sometimes|string',
            'exclusions' => 'sometimes|string',
            'conditions' => 'sometimes|string',
            'tour_days'  => 'sometimes|required|array',
            'existing_images'  => 'sometimes|required|array',
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
