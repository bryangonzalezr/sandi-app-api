<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
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
            'timespan' => $this->faker->randomElement([7,28,29,30,31]),
            'total_calories' => $this->faker->randomFloat(4),
            'menus' => [],
        ];
    }
}
