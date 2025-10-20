<?php

namespace App\Http\Resources;

use App\Models\Patient;
use App\Models\User;
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
        if($this->roles->first()->name == 'paciente'){
            $patient = Patient::where('patient_id', $this->id)->first();
            $nutritionist = User::find($patient->nutritionist_id);
        }

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
            'objectives' => $this->objectives,
            'password_reset' => $this->password_reset,
            'filed' => $this->deleted_at ? true : false,
            'nutritionist' => $nutritionist ?? null,
            'nutritional_profile' => new NutritionalProfileResource($this->nutritionalProfile),
        ];
    }
}
