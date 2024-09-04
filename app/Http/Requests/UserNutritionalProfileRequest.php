<?php

namespace App\Http\Requests;

use App\Enums\HabitFrequency;
use App\Enums\Health;
use App\Enums\Pathology;
use App\Enums\PatientType;
use App\Enums\PhysicalActivity;
use App\Enums\TimeUnit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserNutritionalProfileRequest extends FormRequest
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

            // Actividad física
            //'physical_activity' => ['required', 'array'],
            // 'physical_activity' => ['required', 'boolean'],
            'physical_comentario' => ['nullable', 'string'],
/*             'physical_activity.tiempo' => ['required', 'string'],
            'physical_activity.dias_semana' => ['nullable', 'integer'],
            'physical_activity.entrenamiento' => ['nullable', 'array'],
            'physical_activity.entrenamiento.duracion' => ['nullable', 'array'],
            'physical_activity.entrenamiento.duracion.cantidad' => ['nullable', 'integer'],
            'physical_activity.entrenamiento.duracion.unidad' => ['nullable', Rule::enum(TimeUnit::class)],
            'physical_activity.entrenamiento.tipo' => ['nullable', 'string'],
            'physical_activity.entrenamiento.horarios' => ['nullable', 'string'], */
            'physical_status' => ['required', Rule::enum(PhysicalActivity::class)],

            // Hábitos
            'habits' => ['required', 'array'],
            'habits.alcohol' => ['required', Rule::enum(HabitFrequency::class)],
            'habits.tabaco' => ['required', Rule::enum(HabitFrequency::class)],

            'allergies' => ['nullable', 'array'],
            'allergies.*' => ['nullable', Rule::enum(Health::class)],

            // Antecedentes morbidos
            'morbid_antecedents' => ['required', 'array'],
            'morbid_antecedents.dm2' => ['required', 'boolean'],
            'morbid_antecedents.hta' => ['required', 'boolean'],
            'morbid_antecedents.tiroides' => ['required', 'boolean'],
            'morbid_antecedents.dislipidemia' => ['required', 'boolean'],
            'morbid_antecedents.cirugias' => ['nullable', 'array'],
            'morbid_antecedents.cirugias.*' => ['nullable', 'string'],
            'morbid_antecedents.otros' => ['nullable', Rule::enum(Pathology::class)],
            // 'morbid_antecedents.otros' => ['nullable', 'array'],
            // 'morbid_antecedents.otros.*' => ['nullable', Rule::enum(Pathology::class)],
            'patient_type' => ['required', Rule::enum(PatientType::class)],

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
            'subjective_assessment.apetito' => ['required', 'string'],
            'subjective_assessment.digestion' => ['required', 'string'],
            'subjective_assessment.frecuencia_dig' => ['required', 'string'],
            'subjective_assessment.medidas' => ['required', 'string'],

            // Anamnesis alimentaria
            'nutritional_anamnesis' => ['required', 'array'],
            'nutritional_anamnesis.plan_anterior' => ['required', 'boolean'],
            'nutritional_anamnesis.agua' => ['required', 'boolean'],
            'nutritional_anamnesis.observaciones' => ['nullable', 'string'],
        ];
    }
}
