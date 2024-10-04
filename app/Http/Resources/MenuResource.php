<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->timespan == 7){
            $type = "semanal";
        } elseif ($this->whereBetween('timespan', [28, 31])){
            $type = "mensual";
        }

        return [
            'name' => $this->name,
            'user_id' => $this->user->name,
            'list' => [
                "diario" => $this->recipes,
                "sm" => [
                    'timespan' => $this->timespan,
                    'menus' => $this->menus,
                ]
            ]
        ];
    }
}
