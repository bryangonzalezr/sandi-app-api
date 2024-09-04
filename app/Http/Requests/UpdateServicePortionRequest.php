<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServicePortionRequest extends FormRequest
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
            'total_calorias' => ['required', 'numeric'],
            'desayuno' => ['required', 'array'],
            'desayuno.cereales' => ['required', 'numeric'],
            'desayuno.verduras_gral' => ['required', 'numeric'],
            'desayuno.verduras_libre_cons' => ['required', 'numeric'],
            'desayuno.frutas' => ['required', 'numeric'],
            'desayuno.carnes_ag' => ['required', 'numeric'],
            'desayuno.carnes_bg' => ['required', 'numeric'],
            'desayuno.lacteos_ag' => ['required', 'numeric'],
            'desayuno.lacteos_mg' => ['required', 'numeric'],
            'desayuno.lacteos_bg' => ['required', 'numeric'],
            'desayuno.aceites_grasas' => ['required', 'numeric'],
            'desayuno.alim_ricos_lips' => ['required', 'numeric'],
            'desayuno.azucares' => ['required', 'numeric'],

            'colacion' => ['required', 'array'],
            'colacion.cereales' => ['required', 'numeric'],
            'colacion.verduras_gral' => ['required', 'numeric'],
            'colacion.verduras_libre_cons' => ['required', 'numeric'],
            'colacion.frutas' => ['required', 'numeric'],
            'colacion.carnes_ag' => ['required', 'numeric'],
            'colacion.carnes_bg' => ['required', 'numeric'],
            'colacion.lacteos_ag' => ['required', 'numeric'],
            'colacion.lacteos_mg' => ['required', 'numeric'],
            'colacion.lacteos_bg' => ['required', 'numeric'],
            'colacion.aceites_grasas' => ['required', 'numeric'],
            'colacion.alim_ricos_lips' => ['required', 'numeric'],
            'colacion.azucares' => ['required', 'numeric'],

            'almuerzo' => ['required', 'array'],
            'almuerzo.cereales' => ['required', 'numeric'],
            'almuerzo.verduras_gral' => ['required', 'numeric'],
            'almuerzo.verduras_libre_cons' => ['required', 'numeric'],
            'almuerzo.frutas' => ['required', 'numeric'],
            'almuerzo.carnes_ag' => ['required', 'numeric'],
            'almuerzo.carnes_bg' => ['required', 'numeric'],
            'almuerzo.lacteos_ag' => ['required', 'numeric'],
            'almuerzo.lacteos_mg' => ['required', 'numeric'],
            'almuerzo.lacteos_bg' => ['required', 'numeric'],
            'almuerzo.aceites_grasas' => ['required', 'numeric'],
            'almuerzo.alim_ricos_lips' => ['required', 'numeric'],
            'almuerzo.azucares' => ['required', 'numeric'],

            'once' => ['required', 'array'],
            'once.cereales' => ['required', 'numeric'],
            'once.verduras_gral' => ['required', 'numeric'],
            'once.verduras_libre_cons' => ['required', 'numeric'],
            'once.frutas' => ['required', 'numeric'],
            'once.carnes_ag' => ['required', 'numeric'],
            'once.carnes_bg' => ['required', 'numeric'],
            'once.lacteos_ag' => ['required', 'numeric'],
            'once.lacteos_mg' => ['required', 'numeric'],
            'once.lacteos_bg' => ['required', 'numeric'],
            'once.aceites_grasas' => ['required', 'numeric'],
            'once.alim_ricos_lips' => ['required', 'numeric'],
            'once.azucares' => ['required', 'numeric'],

            'cena' => ['required', 'array'],
            'cena.cereales' => ['required', 'numeric'],
            'cena.verduras_gral' => ['required', 'numeric'],
            'cena.verduras_libre_cons' => ['required', 'numeric'],
            'cena.frutas' => ['required', 'numeric'],
            'cena.carnes_ag' => ['required', 'numeric'],
            'cena.carnes_bg' => ['required', 'numeric'],
            'cena.lacteos_ag' => ['required', 'numeric'],
            'cena.lacteos_mg' => ['required', 'numeric'],
            'cena.lacteos_bg' => ['required', 'numeric'],
            'cena.aceites_grasas' => ['required', 'numeric'],
            'cena.alim_ricos_lips' => ['required', 'numeric'],
            'cena.azucares' => ['required', 'numeric'],
        ];
    }
}
