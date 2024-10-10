<?php

namespace Database\Factories;

use App\Enums\Health;
use App\Models\Patient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    protected $model = Recipe::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $diet_labels = ['balanced','high-fiber','high-protein','low-carb','low-fat','low-sodium'];
        $meal_type = ['Breakfast', 'Lunch', 'Dinner', 'Snack', 'Teatime'];
        $dish_type = [
            'Biscuits and cookies',
            'Bread',
            'Cereals',
            'Condiments and sauces',
            'Desserts',
            'Drinks',
            'Main course',
            'Pancake',
            'Preps',
            'Preserve',
            'Salad',
            'Sandwiches',
            'Side dish',
            'Soup',
            'Starter',
            'Sweets'
        ];
        return [
            'label' => $this->faker->word(),
            'dietLabels' => $this->faker->randomElements($diet_labels,rand(1,count($diet_labels))),
            'healthLabels' => $this->faker->randomElements(Health::cases()),
            'ingredientLines' => $this->faker->sentences(rand(3, 7)),
            'calories'         => $this->faker->randomFloat(4),
            'mealType'        => $this->faker->randomElements($meal_type, rand(1,count($meal_type))),
            'dishType'        => $this->faker->randomElements($dish_type, rand(1,count($dish_type))),
            'instructions'     => $this->faker->text(200),
            'user_id'          => 0,
            'sandi_recipe'     => false
        ];
    }

    public function getPatient($nutritionist_id) {
        return $this->afterMaking(function (Recipe $recipe) use ($nutritionist_id) {
            $patient = Patient::where('nutritionist_id', $nutritionist_id)->pluck('patient_id');
            if($patient){
                $selected_patient = $this->faker->randomElement($patient);
                $recipe->update([
                    'user_id' => $selected_patient
                ]);
            } else{
                $patient_user = User::factory()->patient()->create();
                $patient = Patient::create([
                    'patient_id' => $patient_user->id,
                    'nutritionist_id' => $nutritionist_id
                ]);

                $recipe->update([
                    'user_id' => $patient_user->id
                ]);

            }

        });
    }
}
