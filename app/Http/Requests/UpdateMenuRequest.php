<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
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
            'timespan' => ['required', 'numeric'],
            'total_calories' => ['required', 'numeric'],
            'menus' => ['required', 'array'],
            'menus.*' => ['required', 'array'],
            'menus.*.*._id' => ['required', 'string'],
            'menus.*.*.label' => ['required', 'string'],
            'menus.*.*.dietLabels' => ['nullable', 'array'],
            'menus.*.*.healthLabels' => ['nullable', 'array'],
            'menus.*.*.cautions' => ['nullable', 'array'],
            'menus.*.*.ingredientLines' => ['required', 'array'],
            'menus.*.*.ingredients' => ['required', 'array'],
            'menus.*.*.calories' => ['nullable', 'numeric'],
            'menus.*.*.mealType' => ['nullable', 'array'],
            'menus.*.*.dishType' => ['nullable', 'array'],
            'menus.*.*.instructions' => ['nullable', 'string'],
        ];
    }
}
