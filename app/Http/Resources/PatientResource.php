<?php

namespace App\Http\Resources;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $patient = Patient::where('patient_id', $this->id)->first();
        return [
            'user' => new UserResource($this),
            'first_visit' => $patient->first_visit,
            'nutritional_profile' => new NutritionalProfileResource($this->nutritionalProfile),
            'nutritional_plan' => new NutritionalPlanResource($this->nutritionalPlan),
        ];
    }
}
