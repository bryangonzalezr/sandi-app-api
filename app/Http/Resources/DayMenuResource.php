<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DayMenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'user' => $this->user->name . " " . $this->user->last_name,
            'sandi_recipe' => $this->sandi_recipe,
            "type" => $this->type ?? "diario",
            "recipes"        => $this->recipes,
            "total_calories" => $this->total_calories,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
