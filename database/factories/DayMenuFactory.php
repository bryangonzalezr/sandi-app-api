<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DayMenu>
 */
class DayMenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($this->faker));
        return [
            'name' => $this->faker->foodName(),
            'user_id' => 0,
            'sandi_recipe' => false,
            'type' => 'diario',
            'recipes' => [],
            'total_calories' => $this->faker->randomFloat(4),
        ];
    }
}
