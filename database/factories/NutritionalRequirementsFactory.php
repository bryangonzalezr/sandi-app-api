<?php

namespace Database\Factories;

use App\Enums\GetMethod;
use App\Models\NutritionalRequirement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class NutritionalRequirementsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => 0,
            'method' => $this->faker->randomElement(GetMethod::values()),
            'rest_type' => $this->faker->randomElement(NutritionalRequirement::values()),
            'get' => null,
            'proteina' => null,
            'lipidos' => null,
            'carbohidratos' => null,
            'agua' => null,
        ];
    }
}
