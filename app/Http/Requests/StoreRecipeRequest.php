<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
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
            'label' => ['required', 'string'],
            'diet_labels' => ['required', 'array'],
            'health_labels' => ['required', 'array'],
            'cautions' => ['nullable', 'array'],
            'ingredient_lines' => ['required', 'array'],
            'calories' => ['required', 'numeric'],
            'glycemic_index' => ['nullable', 'numeric'],
            'inflammatory_index' => ['nullable', 'numeric'],
            'meal_type' => ['nullable', 'array'],
            'dish_type' => ['nullable', 'array'],
            'instructions' => ['nullable', 'string'],
            'user_id' => ['required', 'numeric'],
        ];
    }
}
