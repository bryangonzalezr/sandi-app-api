<?php

namespace App\Http\Requests;

use App\Enums\HabitFrequency;
use App\Enums\Health;
use App\Enums\PhysicalActivity;
use App\Enums\TimeUnit;
use App\Enums\UserSex;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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

            'habits' => ['required', 'array'],
            'habits.alcohol' => ['required', Rule::enum(HabitFrequency::class)],
            'habits.tabaco' => ['required', Rule::enum(HabitFrequency::class)],

            // Anamnesis alimentaria
            'nutritional_anamnesis' => ['required', 'array'],
            'nutritional_anamnesis.plan_anterior' => ['required', 'boolean'],
            'nutritional_anamnesis.agua' => ['required', 'boolean'],

            // Actividad física
            // 'physical_activity' => ['required', 'boolean'],
            'physical_comentario' => ['nullable', 'string'],
/*             'physical_activity.tiempo' => ['nullable', 'string'],
            'physical_activity.dias_semana' => ['nullable', 'integer'],
            'physical_activity.entrenamiento' => ['nullable', 'array'],
            'physical_activity.entrenamiento.duracion' => ['nullable', 'string'],
            'physical_activity.entrenamiento.tipo' => ['nullable', 'string'],
            'physical_activity.entrenamiento.horarios' => ['nullable', 'string'], */
            'physical_status' => ['required', Rule::enum(PhysicalActivity::class)],

            'allergies' => ['nullable', 'array'],
            'allergies.*' => ['nullable', Rule::enum(Health::class)],
        ];
    }
}
