<?php

namespace App\Http\Requests;

use App\Enums\Health;
use App\Enums\Pathology;
use App\Enums\PatientType;
use App\Enums\PhysicalActivity;
use App\Enums\TimeUnit;
use App\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNutritionalProfileRequest extends FormRequest
{
    protected $first_visit;

    public function __construct($first_visit)
    {
        parent::__construct();
        $this->first_visit = $first_visit;
    }

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
            $validations = [
                'description' => ['nullable', 'string'],

                // Actividad física
                'physical_activity' => ['required', 'array'],
                'physical_activity.actividad' => ['required', 'boolean'],
                'physical_activity.tiempo' => ['nullable', 'string'],
                'physical_activity.dias_semana' => ['nullable', 'integer'],
                'physical_activity.entrenamiento' => ['nullable', 'array'],
                'physical_activity.entrenamiento.duracion' => ['nullable', 'array'],
                'physical_activity.entrenamiento.duracion.cantidad' => ['nullable', 'integer'],
                'physical_activity.entrenamiento.duracion.unidad' => ['nullable', Rule::enum(TimeUnit::class)],
                'physical_activity.entrenamiento.tipo' => ['nullable', 'string'],
                'physical_activity.entrenamiento.horarios' => ['nullable', 'string'],
                'physical_activity.status' => ['required', Rule::enum(PhysicalActivity::class)],

                // Hábitos
                'habits' => ['required', 'array'],
                'habits.alcohol' => ['required', 'boolean'],
                'habits.tabaco' => ['required', 'boolean'],
                'habits.comentario' => ['nullable', 'string'],

                'allergies' => ['required', 'array'],
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
                'subjective_assessment.apetito' => ['required', 'numeric'],

                // Anamnesis alimentaria
                'nutritional_anamnesis' => ['required', 'array'],
                'nutritional_anamnesis.plan_anterior' => ['required', 'boolean'],
                'nutritional_anamnesis.agua' => ['required', 'boolean'],
                'nutritional_anamnesis.observaciones' => ['nullable', 'string'],

                // Antropometría
                'height' => ['required', 'numeric'],
                'weight' => ['required', 'numeric'],

                //Pliegues
                'bicipital_skinfold' => ['nullable', 'numeric'],
                'tricipital_skinfold' => ['nullable', 'numeric'],
                'subscapular_skinfold' => ['nullable', 'numeric'],
                'supraspinal_skinfold' => ['nullable', 'numeric'],
                'suprailiac_skinfold' => ['nullable', 'numeric'],
                'thigh_skinfold' => ['nullable', 'numeric'],
                'calf_skinfold' => ['nullable', 'numeric'],
                'abdomen_skinfold' => ['nullable', 'numeric'],

                // Perimetros
                'pb_relaj' => ['nullable', 'numeric'],
                'pb_contra' => ['nullable', 'numeric'],
                'forearm' => ['nullable', 'numeric'],
                'thigh' => ['nullable', 'numeric'],
                'calf' => ['nullable', 'numeric'],
                'waist' => ['nullable', 'numeric'],
                'thorax' => ['nullable', 'numeric'],
            ];

        return $validations;
    }
}
