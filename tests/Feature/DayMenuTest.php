<?php

namespace Tests\Feature;

use App\Models\DayMenu;
use App\Models\Patient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DayMenuTest extends TestCase
{
    use WithFaker;

    protected $faker;
    /**
     * A basic feature test example.
     */
    public function test_user_can_create_day_menu_using_recipes(): void
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
        $recipes = [];
        for($i=1;$i<=3;$i++){
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


        $recipe = $this->getJson(route('recipes.show', ['recipe' => $response["data"]["_id"]]));
        $recipe->assertStatus(200);
        array_push($recipes,$recipe["data"]);
        }

        $day_menu = DayMenu::factory()->make();
        $createDayMenu = $this->postJson(route('dayMenus.store'), [
            "name" => $day_menu->name,
            "user_id" => $selected_patient,
            "sandi_recipe" => false,
            "recipes" => $recipes,
            "total_calories" => $day_menu->total_calories
        ]);

        $createDayMenu->assertStatus(201);
    }

    public function test_user_can_edit_day_menu_using_recipes(): void
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
        $recipes = [];
        for($i=1;$i<=3;$i++){
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


        $recipe = $this->getJson(route('recipes.show', ['recipe' => $response["data"]["_id"]]));
        $recipe->assertStatus(200);
        array_push($recipes,$recipe["data"]);
        }

        $day_menu = DayMenu::factory()->make();
        $createDayMenu = $this->postJson(route('dayMenus.store'), [
            "name" => $day_menu->name,
            "user_id" => $selected_patient,
            "sandi_recipe" => false,
            "recipes" => $recipes,
            "total_calories" => $day_menu->total_calories
        ]);

        $createDayMenu->assertStatus(201);
    }
}
