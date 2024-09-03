<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNutritionalPlanRequest extends FormRequest
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
            'desayuno'   => ['required', 'string', 'max:255'],
            'colacion' => ['required', 'string', 'max:255'],
            'almuerzo' => ['required', 'string', 'max:255'],
            'once' => ['required', 'string', 'max:255'],
            'cena' => ['required', 'string', 'max:255'],
            'general_recommendations' => ['required', 'string', 'max:255'],
            'forbidden_foods' => ['required', 'string', 'max:255'],
            'free_foods' => ['required', 'string', 'max:255'],
        ];
    }
}
