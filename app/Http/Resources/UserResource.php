<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'role' => $this->roles->first()->name,
            'sex' => $this->sex,
            'birthdate' => $this->birthdate,
            'age' => $this->age,
            'phone_number' => $this->phone_number,
            'civil_status' => $this->civil_status,
            'description' => $this->description,
            'objectives' => $this->objectives,
        ];
    }
}
