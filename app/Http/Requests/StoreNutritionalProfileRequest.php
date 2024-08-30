<?php

namespace App\Http\Requests;

use App\Enums\Health;
use App\Enums\PhysicalActivity;
use App\Enums\TimeUnit;
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
            'patient_id' => ['required', 'integer', 'exists:users,id'],
            'height' => ['required', 'numeric'],

            //Peso
            'weight' => ['required', 'array'],
            'weight.peso_real' => ['required', 'numeric'],
            'weight.peso_ideal' => ['required', 'numeric'],
            'weight.peso_máximo' => ['required', 'numeric'],
            'weight.peso_ajustado' => ['required', 'numeric'],

            // Actividad física
            'physical_activity' => ['required', 'array'],
            'physical_activity.actividad' => ['required', 'boolean'],
            'physical_activity.tiempo' => ['required', 'array'],
            'physical_activity.tiempo.cantidad' => ['required', 'integer'],
            'physical_activity.tiempo.unidad' => ['required', Rule::enum(TimeUnit::class)],
            'physical_activity.dias_semana' => ['required_if:physical_activity.*.actividad,true', 'integer'],
            'physical_activity.entrenamiento' => ['required_if:physical_activity.*.actividad,true', 'array'],
            'physical_activity.entrenamiento.duracion' => ['required', 'array'],
            'physical_activity.entrenamiento.duracion.cantidad' => ['required', 'integer'],
            'physical_activity.entrenamiento.duracion.unidad' => ['required', Rule::enum(TimeUnit::class)],
            'physical_activity.entrenamiento.tipo' => ['required', 'string'],
            'physical_activity.entrenamiento.horarios' => ['required', 'array'],
            'physical_activity.entrenamiento.horarios.*' => ['required', 'string'],
            'physical_activity.status' => ['required', Rule::enum(PhysicalActivity::class)],

            // Hábitos
            'habits' => ['required', 'array'],
            'habits.alcohol' => ['required', 'boolean'],
            'habits.tabaco' => ['required', 'boolean'],
            'habits.comentario' => ['nullable', 'string'],

            'allergies' => ['required', 'array'],
            'allergies.*' => ['required', Rule::enum(Health::class)],

            // Antecedentes morbidos
            'morbid_antecedents' => ['required', 'array'],
            'morbid_antecedents.dm2' => ['required', 'boolean'],
            'morbid_antecedents.hta' => ['required', 'boolean'],
            'morbid_antecedents.tiroides' => ['required', 'boolean'],
            'morbid_antecedents.dislipidemia' => ['required', 'boolean'],
            'morbid_antecedents.cirugias' => ['required', 'array'],
            'morbid_antecedents.cirugias.*' => ['required', 'string'],
            'morbid_antecedents.otros' => ['nullable', 'string'],

            // Antecedentes familiares
            'family_antecedents' => ['required', 'array'],
            'family_antecedents.dm2' => ['required', 'boolean'],
            'family_antecedents.hta' => ['required', 'boolean'],
            'family_antecedents.cancer' => ['required', 'boolean'],
            'family_antecedents.dislipidemia' => ['required', 'boolean'],
            'family_antecedents.otros' => ['nullable', 'string'],

            // Valoración subjetiva
            'subjective_assessment' => ['required', 'array'],
            'subjective_assessment.sintomas' => ['required', 'boolean'],
            'subjective_assessment.peso_habitual' => ['required', 'numeric'],
            'subjective_assessment.variacion_peso' => ['required', 'numeric'],
            'subjective_assessment.apetito' => ['required', 'numeric'],

            // Anamnesis alimentaria
            'nutritional_anamnesis' => ['required', 'array'],
            'nutritional_anamnesis.plan_anterior' => ['required', 'boolean'],
            'nutritional_anamnesis.agua' => ['required', 'boolean'],
            'nutritional_anamnesis.observaciones' => ['nullable', 'string'],
        ];
    }
}
