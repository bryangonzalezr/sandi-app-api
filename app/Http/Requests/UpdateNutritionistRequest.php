<?php

namespace App\Http\Requests;

use App\Enums\UserSex;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNutritionistRequest extends FormRequest
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
            'last_name' => ['required', 'string'],
            'sex' => ['required', Rule::enum(UserSex::class)],
            'birthdate' => ['required', 'date'],
            'phone_number' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'objectives' => ['nullable', 'string'],
        ];
    }
}
