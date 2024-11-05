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
            'dietLabels' => ['nullable', 'array'],
            'healthLabels' => ['nullable', 'array'],
            'cautions' => ['nullable', 'array'],
            'ingredientLines' => ['required', 'array'],
            'ingredients' => ['required', 'array'],
            'ingredients.food' => ['required', 'string'],
            'ingredients.quantity' => ['required', 'numeric'],
            'calories' => ['required', 'numeric'],
            'mealType' => ['nullable', 'array'],
            'dishType' => ['nullable', 'array'],
            'instructions' => ['nullable', 'string'],
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'sandi_recipe' => ['required', 'boolean']
        ];
    }
}
