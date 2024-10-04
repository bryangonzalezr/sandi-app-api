<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuListResource extends JsonResource
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
