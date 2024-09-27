<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDayMenuRequest extends FormRequest
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
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'sandi_recipe' => ['required', 'boolean'],
            'recipes' => ['required', 'array'],
            'recipes.*.label' => ['required', 'string'],
            'recipes.*.dietLabels' => ['nullable', 'array'],
            'recipes.*.healthLabels' => ['required', 'array'],
            'recipes.*.cautions' => ['nullable', 'array'],
            'recipes.*.ingredientLines' => ['required', 'array'],
            'recipes.*.calories' => ['required', 'numeric'],
            'recipes.*.mealType' => ['required', 'array'],
            'recipes.*.dishType' => ['required', 'array'],
            'recipes.*.instructions' => ['nullable', 'string'],
            'total_calories' => ['required', 'numeric'],
        ];
    }
}
