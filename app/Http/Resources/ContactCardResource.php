<?php

namespace App\Http\Resources;

use App\Models\ContactCard;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ContactCard */
class ContactCardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'commune_id' => $this->commune_id,
            'nutritionist_id' => $this->nutritionist_id,
            'description' => $this->description,
            'phone_number' => $this->nutritionist()->phone_number,
            'email' => $this->nutritionist()->email,
            'address' => $this->address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
