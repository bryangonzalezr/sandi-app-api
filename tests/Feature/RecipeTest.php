<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use WithFaker;

    protected $faker;

    /**
     * A basic feature test example.
     */
    public function test_nutritionist_can_create_recipe_for_patient(): void
    {
        $nutritionist = User::find(3);
        $this->actingAs($nutritionist);

        $patient = Patient::where('nutritionist_id', $nutritionist->id)->pluck('patient_id');
        if($patient){
            $selected_patient = $this->faker->randomElement($patient);
        } else{
            $patient_user = User::factory()->patient()->create();
            $patient = Patient::create([
                'patient_id' => $patient_user->id,
                'nutritionist_id' => $nutritionist->id
            ]);
            $selected_patient = $patient_user->id;
        }

        $recipe = Recipe::factory()->make();
        $response = $this->postJson(route('recipes.store'), [
            'label' => $recipe->label,
            'dietLabels' => $recipe->dietLabels,
            'healthLabels' => $recipe->healthLabels,
            'ingredientLines' => $recipe->ingredientLines,
            'calories' => $recipe->calories,
            'mealType' => $recipe->mealType,
            'dishType' => $recipe->dishType,
            'instructions' => $recipe->instructions,
            'user_id'      => $selected_patient,
            'sandi_recipe' => $recipe->sandi_recipe
        ]);

        $response->assertStatus(201);

    }

    public function test_sandi_can_generate_recipe(): void
    {
        $this->faker = \Faker\Factory::create();
        $this->faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($this->faker));

        $sandi = User::find(1);
        $this->actingAs($sandi);

        // Usuario paciente pide receta a sandi
        $response = $this->postJson(route('recipes.generate'), [
            'query'            => $this->faker->foodName(),
            'user_id'          => 4,
        ]);

        $response->assertStatus(200);

        // Usuario nutricionista pide receta a sandi
        $response = $this->postJson(route('recipes.generate'), [
            'query'            => $this->faker->foodName(),
            'user_id'          => 3,
        ]);

        $response->assertStatus(200);
    }

    public function test_patient_can_save_recipe_from_sandi(): void
    {
        $this->faker = \Faker\Factory::create();
        $this->faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($this->faker));

        $sandi = User::find(1);
        $this->actingAs($sandi);

        // Usuario paciente pide receta a sandi
        $getRecipe = $this->postJson(route('recipes.generate'), [
            'query'            => $this->faker->foodName(),
            'user_id'          => 4,
        ]);

        $getRecipe->assertStatus(200);
        $this->assertArrayHasKey('recipe', $getRecipe->json());

        // Paciente guarda la receta
        $patient = User::find(4);
        $this->actingAs($patient);

        $recipe = $getRecipe->json()['recipe'];

        $response = $this->postJson(route('recipes.store'), [
            'label' => $recipe['label'],
            'dietLabels' => $recipe['dietLabels'] ?? null,
            'healthLabels' => $recipe['healthLabels'] ?? null,
            'ingredientLines' => $recipe['ingredientLines'] ?? null,
            'calories' => $recipe['calories'] ?? null,
            'mealType' => $recipe['mealType'] ?? null,
            'dishType' => $recipe['dishType'] ?? null,
            'instructions' => $recipe['instructions'] ?? null,
            'user_id'      => $patient->id,
            'sandi_recipe' => true
        ]);
    }

    public function test_nutritionist_can_save_recipe_from_sandi(): void
    {
        $this->faker = \Faker\Factory::create();
        $this->faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($this->faker));

        $sandi = User::find(1);
        $this->actingAs($sandi);

        // Usuario nutricionista pide receta a sandi seleccionando un paciente
        $getRecipe = $this->postJson(route('recipes.generate'), [
            'query'            => $this->faker->foodName(),
            'user_id'          => 4,
            ''
        ]);

        $getRecipe->assertStatus(200);
        $this->assertArrayHasKey('recipe', $getRecipe->json());

        // Nutricionista guarda la receta para un paciente
        $nutritionist = User::find(3);
        $this->actingAs($nutritionist);

        $recipe = $getRecipe->json()['recipe'];

        $response = $this->postJson(route('recipes.store'), [
            'label' => $recipe['label'],
            'dietLabels' => $recipe['dietLabels'] ?? null,
            'healthLabels' => $recipe['healthLabels'] ?? null,
            'ingredientLines' => $recipe['ingredientLines'] ?? null,
            'calories' => $recipe['calories'] ?? null,
            'mealType' => $recipe['mealType'] ?? null,
            'dishType' => $recipe['dishType'] ?? null,
            'instructions' => $recipe['instructions'] ?? null,
            'user_id'      => $nutritionist->id,
            'sandi_recipe' => true
        ]);
    }
}
