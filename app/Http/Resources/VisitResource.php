<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'patient' => new UserResource($this->patient),
            'date' => Carbon::parse($this->date)->format('d/m/Y'),
            'progresses' => ProgressResource::collection($this->patient->progresses),
        ];
    }
}
