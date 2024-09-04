<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePortionRequest extends FormRequest
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
            'patient_id' => ['required', 'numeric', 'exists:users,id'],
            'cereales' => ['required', 'numeric'],
            'verduras_gral' => ['required', 'numeric'],
            'verduras_libre_cons' => ['required', 'numeric'],
            'frutas' => ['required', 'numeric'],
            'carnes_ag' => ['required', 'numeric'],
            'carnes_bg' => ['required', 'numeric'],
            'legumbres' => ['required', 'numeric'],
            'lacteos_ag' => ['required', 'numeric'],
            'lacteos_bg' => ['required', 'numeric'],
            'lacteos_mg' => ['required', 'numeric'],
            'aceites_grasas' => ['required', 'numeric'],
            'alim_ricos_lipidos' => ['required', 'numeric'],
            'azucares' => ['required', 'numeric'],
        ];
    }
}
