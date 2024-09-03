<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServicePortionRequest extends FormRequest
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
            'cereales' => ['required', 'array'],
            'cereales.desayuno' => ['required', 'numeric'],
            'cereales.colacion' => ['required', 'numeric'],
            'cereales.almuerzo' => ['required', 'numeric'],
            'cereales.once' => ['required', 'numeric'],
            'cereales.cena' => ['required', 'numeric'],

            'verduras_gral' => ['required', 'array'],
            'verduras_gral.desayuno' => ['required', 'numeric'],
            'verduras_gral.colacion' => ['required', 'numeric'],
            'verduras_gral.almuerzo' => ['required', 'numeric'],
            'verduras_gral.once' => ['required', 'numeric'],
            'verduras_gral.cena' => ['required', 'numeric'],

            'verduras_libre_cons' => ['required', 'array'],
            'verduras_libre_cons.desayuno' => ['required', 'numeric'],
            'verduras_libre_cons.colacion' => ['required', 'numeric'],
            'verduras_libre_cons.almuerzo' => ['required', 'numeric'],
            'verduras_libre_cons.once' => ['required', 'numeric'],
            'verduras_libre_cons.cena' => ['required', 'numeric'],

            'frutas' => ['required', 'array'],
            'frutas.desayuno' => ['required', 'numeric'],
            'frutas.colacion' => ['required', 'numeric'],
            'frutas.almuerzo' => ['required', 'numeric'],
            'frutas.once' => ['required', 'numeric'],
            'frutas.cena' => ['required', 'numeric'],

            'carnes_ag' => ['required', 'array'],
            'carnes_ag.desayuno' => ['required', 'numeric'],
            'carnes_ag.colacion' => ['required', 'numeric'],
            'carnes_ag.almuerzo' => ['required', 'numeric'],
            'carnes_ag.once' => ['required', 'numeric'],
            'carnes_ag.cena' => ['required', 'numeric'],

            'carnes_bg' => ['required', 'array'],
            'carnes_bg.desayuno' => ['required', 'numeric'],
            'carnes_bg.colacion' => ['required', 'numeric'],
            'carnes_bg.almuerzo' => ['required', 'numeric'],
            'carnes_bg.once' => ['required', 'numeric'],
            'carnes_bg.cena' => ['required', 'numeric'],

            'legumbres' => ['required', 'array'],
            'legumbres.desayuno' => ['required', 'numeric'],
            'legumbres.colacion' => ['required', 'numeric'],
            'legumbres.almuerzo' => ['required', 'numeric'],
            'legumbres.once' => ['required', 'numeric'],
            'legumbres.cena' => ['required', 'numeric'],

            'lacteos_ag' => ['required', 'array'],
            'lacteos_ag.desayuno' => ['required', 'numeric'],
            'lacteos_ag.colacion' => ['required', 'numeric'],
            'lacteos_ag.almuerzo' => ['required', 'numeric'],
            'lacteos_ag.once' => ['required', 'numeric'],
            'lacteos_ag.cena' => ['required', 'numeric'],

            'lacteos_bg' => ['required', 'array'],
            'lacteos_bg.desayuno' => ['required', 'numeric'],
            'lacteos_bg.colacion' => ['required', 'numeric'],
            'lacteos_bg.almuerzo' => ['required', 'numeric'],
            'lacteos_bg.once' => ['required', 'numeric'],
            'lacteos_bg.cena' => ['required', 'numeric'],

            'lacteos_mg' => ['required', 'array'],
            'lacteos_mg.desayuno' => ['required', 'numeric'],
            'lacteos_mg.colacion' => ['required', 'numeric'],
            'lacteos_mg.almuerzo' => ['required', 'numeric'],
            'lacteos_mg.once' => ['required', 'numeric'],
            'lacteos_mg.cena' => ['required', 'numeric'],

            'aceites_grasas' => ['required', 'array'],
            'aceitas_grasas.desayuno' => ['required', 'numeric'],
            'aceitas_grasas.colacion' => ['required', 'numeric'],
            'aceitas_grasas.almuerzo' => ['required', 'numeric'],
            'aceitas_grasas.once' => ['required', 'numeric'],
            'aceitas_grasas.cena' => ['required', 'numeric'],

            'alim_ricos_lipidos' => ['required', 'array'],
            'alim_ricos_lipidos.desayuno' => ['required', 'numeric'],
            'alim_ricos_lipidos.colacion' => ['required', 'numeric'],
            'alim_ricos_lipidos.almuerzo' => ['required', 'numeric'],
            'alim_ricos_lipidos.once' => ['required', 'numeric'],
            'alim_ricos_lipidos.cena' => ['required', 'numeric'],

            'azucares' => ['required', 'array'],
            'azucares.desayuno' => ['required', 'numeric'],
            'azucares.colacion' => ['required', 'numeric'],
            'azucares.almuerzo' => ['required', 'numeric'],
            'azucares.once' => ['required', 'numeric'],
            'azucares.cena' => ['required', 'numeric'],

            'patient_id' => ['required', 'numeric'],
        ];
    }
}
