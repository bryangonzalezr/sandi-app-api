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
        return [
            '_id' => $this->_id,
            'menu' => $this->menu,/* [
                '_id' => $this->menu->_id,
                'name' => $this->menu->name
            ], */
            'list' => $this->list,
            'amount' => $this->amount
        ];
    }
}
