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
            "_id" => $this->_id,
            'name' => $this->name,
            'user' => $this->user->name . " " . $this->user->last_name,
            'type'  => $this->type ?? "diario",
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
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
