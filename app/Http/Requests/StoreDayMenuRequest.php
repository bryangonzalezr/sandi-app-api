<?php

namespace App\Http\Requests;

use App\Models\Recipe;
use Illuminate\Foundation\Http\FormRequest;

class StoreDayMenuRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'recipes' => ['required', 'array'],
            'recipes.*.label' => ['required', 'string'],
            'recipes.*.diet_labels' => ['required', 'array'],
            'recipes.*.health_labels' => ['required', 'array'],
            'recipes.*.cautions' => ['required', 'array'],
            'recipes.*.ingredient_lines' => ['required', 'array'],
            'recipes.*.calories' => ['required', 'numeric'],
            'recipes.*.glycemic_index' => ['nullable', 'numeric'],
            'recipes.*.inflammatory_index' => ['nullable', 'numeric'],
            'recipes.*.meal_type' => ['required', 'string'],
            'recipes.*.dish_type' => ['required', 'string'],
            'recipes.*.instructions' => ['nullable', 'string'],
            'total_calories' => ['required', 'numeric'],
        ];
    }
}
