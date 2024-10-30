<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NutritionalPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            '_id' => $this->_id,
            'patient' => $this->patient,
            'desayuno' => $this->desayuno,
            'colacion' => $this->colacion,
            'almuerzo' => $this->almuerzo,
            'once'     => $this->once,
            'cena'     => $this->cena,
            'general_recommendations' => $this->general_recommendations,
            'forbidden_foods' => $this->forbidden_foods,
            'free_foods' => $this->free_foods,
            'nutritional_requirement' => $this->nutritionalRequirement,
            'portion' => $this->portion,
            'service_portion' => $this->servicePortion,
            'created_at' => $this->created_at
        ];
    }
}
