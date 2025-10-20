<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NutritionalProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'physical_activity' => $this->physical_activity,
            'physical_status' => $this->physical_status,
            'physical_comentario' => $this->physical_comentario,
            'habits' => $this->habits,
            'allergies' => $this->allergies,
            'morbid_antecedents' => $this->morbid_antecedents,
            'patient_type' => $this->patient_type,
            'family_antecedents' => $this->family_antecedents,
            'subjective_assessment' => $this->subjective_assessment,
            'nutritional_anamnesis' => $this->nutritional_anamnesis,
        ];
    }
}
