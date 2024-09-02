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
            'patient_id' => ['required', 'integer', 'exists:users,id'],
            'height' => ['required', 'numeric'],
            'weight' => ['required', 'numeric'],

            //Pliegues
            'bicipital_skinfold' => ['nullable', 'numeric'],
            'tricipital_skinfold' => ['nullable', 'numeric'],
            'subscapular_skinfold' => ['nullable', 'numeric'],
            'supraspinal_skinfold' => ['nullable', 'numeric'],
            'suprailiac_skinfold' => ['nullable', 'numeric'],
            'thigh_skinfold' => ['nullable', 'numeric'],
            'calf_skinfold' => ['nullable', 'numeric'],
            'abdomen_skinfold' => ['nullable', 'numeric'],

            // Perimetros
            'pb_relaj' => ['nullable', 'numeric'],
            'pb_contra' => ['nullable', 'numeric'],
            'forearm' => ['nullable', 'numeric'],
            'thigh' => ['nullable', 'numeric'],
            'calf' => ['nullable', 'numeric'],
            'waist' => ['nullable', 'numeric'],
            'thorax' => ['nullable', 'numeric'],
        ];
    }
}
