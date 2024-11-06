<?php

namespace App\Http\Requests;

use App\Enums\CivilStatus;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'sex' => ['required', 'string'],
            'birthdate' => ['required', 'date_format:d-m-Y'],
            'phone_number' => ['required', 'string'],
            'civil_status' => ['required', Rule::enum(CivilStatus::class)],
            'objectives' => ['nullable', 'string'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::default()],
            'password_confirmation' => ['required', 'string'],
            'role' => ['required', 'string'],
        ];
    }
}
