<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        "id" => $this->id,
        "type" => $this->type,
        "title" => $this->title,
        "institution" => $this->institution,
        "description" => $this->description,
        "start_date" => $this->start_date ? Carbon::parse($this->start_date)->format('d/m/Y') : null,
        "end_date" => $this->end_date ? Carbon::parse($this->end_date)->format('d/m/Y') : null
        ];
    }
}
