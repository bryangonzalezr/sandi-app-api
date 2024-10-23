<?php

namespace App\Http\Requests;

use App\Rules\ExistInMongo;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNutritionalPlanRequest extends FormRequest
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
            'patient_id' => ['required', 'integer', 'exists:users,id'],
            'desayuno'   => ['nullable', 'string', 'max:255'],
            'colacion' => ['nullable', 'string', 'max:255'],
            'almuerzo' => ['nullable', 'string', 'max:255'],
            'once' => ['nullable', 'string', 'max:255'],
            'cena' => ['nullable', 'string', 'max:255'],
            'general_recommendations' => ['nullable', 'string', 'max:255'],
            'forbidden_foods' => ['nullable', 'string', 'max:255'],
            'free_foods' => ['nullable', 'string', 'max:255'],
            'nutritional_requirement_id' => ['required', 'integer', 'exists:nutritional_requirements,id'],
            'portion_id' => ['required', 'integer', 'exists:portions,id'],
            'service_portion_id' => ['required', 'string', new ExistInMongo('_id')],
        ];
    }
}
