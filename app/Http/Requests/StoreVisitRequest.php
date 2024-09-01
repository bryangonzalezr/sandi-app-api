<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'patient_id' => ['required', 'integer', 'exists:users,id']
           /*
             'height' => ['required', 'numeric'],
            'weight' => ['required', 'numeric'],
            'bicipital_skinfold' => ['required', 'numeric'],
            'tricipital_skinfold' => ['required', 'numeric'],
            'subescapular_skinfold' => ['required', 'numeric'],
            'supraspinal_skinfold' => ['required', 'numeric'],
            'suprailiac_skinfold' => ['required', 'numeric'],
            'pb_relaj' => ['required', 'numeric'],
            'pb_contra' => ['required', 'numeric'],
            'forearm' => ['required', 'numeric'],
            'thigh' => ['required', 'numeric'],
            'calf' => ['required', 'numeric'],
            'waist' => ['required', 'numeric'],
            'thorax' => ['required', 'numeric'], */
        ];
    }
}
