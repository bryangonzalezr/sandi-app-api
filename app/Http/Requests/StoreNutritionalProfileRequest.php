<?php

namespace App\Http\Requests;

use App\Enums\Health;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNutritionalProfileRequest extends FormRequest
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
            'patient_id' => ['required', 'integer'],
            'height' => ['required', 'numeric'],
            'weight' => ['required', 'numeric'],
            'physical_activity' => ['required', 'array'],
            'habits' => ['required', 'array'],
            'allergies' => ['required', 'array'],
            'allergies.*' => ['required', Rule::enum(Health::class)],
            'intolerances' => ['required', 'array'],
            'intolerances.*' => ['required', Rule::enum(Health::class)],
            'morbid_antecedents' => ['required', 'array'],
            'family_antecedents' => ['required', 'array'],
            'subjective_assessment' => ['required', 'array'],
            'nutritional_anamnesis' => ['required', 'array'],
        ];
    }
}
