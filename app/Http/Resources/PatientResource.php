<?php

namespace App\Http\Resources;

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
        return [
            'user' => new UserResource($this),
            'first_visit' => $this->first_visit,
            'nutritional_profile' => new NutritionalProfileResource($this->nutritionalProfile),
            'nutritional_plan' => new NutritionalPlanResource($this->nutritionalPlan),
        ];
    }
}
