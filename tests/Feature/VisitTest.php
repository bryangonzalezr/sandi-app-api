<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VisitTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_patient_visits_nutritionist(): void
    {
        $nutritionist = User::find(3);
        $this->actingAs($nutritionist);

        $visit = Visit::factory()->make();

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

        $response = $this->postJson(route('visits.store'),[
            'date' => $visit->date,
            'patient_id' => $selected_patient,
            'height' => $this->faker->randomFloat(2,1, 2),
            'weight' => $this->faker->randomFloat(2,40, 150),
            'bicipital_skinfold' => $this->faker->numberBetween(3, 15),
            'tricipital_skinfold' => $this->faker->numberBetween(6, 25),
            'subscapular_skinfold' => $this->faker->numberBetween(8, 20),
            'supraspinal_skinfold' => $this->faker->numberBetween(6, 20),
            'suprailiac_skinfold' => $this->faker->numberBetween(8, 20),
            'thigh_skinfold' => $this->faker->numberBetween(10, 30),
            'calf_skinfold' => $this->faker->numberBetween(8, 25),
            'abdomen_skinfold' => $this->faker->numberBetween(10, 30),
            'pb_relaj' => $this->faker->numberBetween(20, 40),
            'pb_contra' => $this->faker->numberBetween(0, 45),
            'forearm' => $this->faker->numberBetween(0, 35),
            'thigh' => $this->faker->numberBetween(0, 70),
            'calf' => $this->faker->numberBetween(0, 45),
            'waist' => $this->faker->numberBetween(0, 110),
            'thorax' => $this->faker->numberBetween(0, 120),
        ]);

        $response->assertStatus(201);
    }

}
