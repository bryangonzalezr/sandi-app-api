<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactCardRequest extends FormRequest
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
            'nutritionist_id' => ['required', 'integer', 'exists:users,id'],
            'commune_id' => ['required', 'integer', 'exists:communes,id'],
            'address' => ['required', 'string'],
            'slogan' => ['nullable', 'string'],
            'specialties' => ['nullable', 'string'],
            'description' => ['required', 'string'],
        ];
    }
}
