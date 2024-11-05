<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (is_null($this->resource)) {
            return [];
        }

        $menu = $this->menu ?? $this->dayMenu;

        return [
            '_id' => $this->_id,
            'menu' => [
                '_id' => $this->menu_id,
                'name' => $menu->name,
                'sandi_recipe' => $menu->sandi_recipe,
                'type' => $this->menu_type
            ],
            'list' => $this->list,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
