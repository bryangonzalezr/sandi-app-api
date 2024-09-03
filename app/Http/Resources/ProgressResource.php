<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'patient_id'          => $this->patient_id,
            'imc'                 => (float) $this->imc,
            'fat_percentage'      =>  (float) $this->fat_percentage,
            'muscular_percentage' => (float) $this->muscular_percentage,
            'nutritional_state'   =>  $this->nutritional_state,
        ];
    }
}
