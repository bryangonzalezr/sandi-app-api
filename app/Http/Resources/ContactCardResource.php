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
        if (is_null($this->resource)) {
            return [];
        }

        return [
            'id' => $this->id,
            'commune' => $this->commune,
            'region' => $this->commune->provinces->regions,
            'nutritionist_id' => $this->nutritionist,
            'description' => $this->description,
            'slogan' => $this->slogan,
            'specialties' => $this->specialties,
            'phone_number' => $this->nutritionist->phone_number,
            'email' => $this->nutritionist->email,
            'address' => $this->address,
            'experiences' => ExperienceResource::collection($this->nutritionist->experiences),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
