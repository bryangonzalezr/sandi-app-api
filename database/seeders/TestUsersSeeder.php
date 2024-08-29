<?php

namespace Database\Seeders;

use App\Models\NutritionalPlan;
use App\Models\NutritionalProfile;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $birthdate = Carbon::createFromFormat('Y-m-d', '1988-06-20');
        $nutritionist = User::create([
            'name' => 'Belen',
            'last_name' => 'Isuani',
            'sex' => 'Femenino',
            'birthdate' => $birthdate,
            'age' => Carbon::parse($birthdate)->age,
            'phone_number' => '989220812',
            'civil_status' => 'Casado(a)',
            'description' => '',
            'objectives' => '',
            'email' => 'belen@test.cl',
            'password' => bcrypt('sandi.,2024'),
        ]);

        $nutritionist->assignRole('nutricionista');

        $birthdate = Carbon::createFromFormat('Y-m-d', '1990-01-14');
        $user = User::create([
            'name' => 'Claudia',
            'last_name' => 'Varela',
            'sex' => 'Femenino',
            'birthdate' => $birthdate,
            'age' => Carbon::parse($birthdate)->age,
            'phone_number' => '911112222',
            'civil_status' => 'Casado(a)',
            'description' => '',
            'objectives' => 'Bajar de peso',
            'email' => 'claudia@test.cl',
            'password' => bcrypt('sandi.,2024'),
        ]);
        $patient = Patient::create([
            'nutritionist_id' => $nutritionist->id,
            'patient_id' => $user->id,
        ]);
        $user->assignRole('paciente');

        $nutritional_profile = NutritionalProfile::create([
            'patient_id' => $user->id,
            'height' => 1.63,
            'weight' => 76,
            'physical_activity' => [
                'actividad' => 'No',
                'tiempo' => [
                    'cantidad' => 7,
                    'unidad' => 'años'
                ],
            ],
            'habits' => [
                'alcohol' => [
                    'actividad' => 'Si',
                    'comentario' => 'Tomo una copa de vino ocasionalmente con amigas',
                ],
                'tabaco'  => [
                    'actividad' => 'Si',
                    'comentario' => 'Fumo 5 cigarros al día',
                ],
            ],
            'allergies' => [
                'alergia' => 'Si',
                'alergias' => [
                    'Maní',
                    'Frutos secos',
                    'Mariscos',
                ],
            ],
            'intolerances' => [
                'intolerancia' => 'Si',
                'intolerancias' => [
                    'Carnes rojas',
                ],
            ],
            'family_antecedents' => [],
            'subjective_assessment' => [],
            'nutritional_anamnesis' => [
                'plan_anterior' => 'No',
                'agua' => [
                    'toma_agua' => 'Si',
                    'cantidad' => 'Baja',
                ],
                'observaciones' => []
            ],
        ]);

        $birthdate = Carbon::createFromFormat('Y-m-d', '2000-11-08');
        $user = User::create([
            'name' => 'John',
            'last_name' => 'Barriga',
            'sex' => 'Masculino',
            'birthdate' => $birthdate,
            'age' => Carbon::parse($birthdate)->age,
            'phone_number' => '911112222',
            'civil_status' => 'Soltero(a)',
            'description' => '',
            'objectives' => 'Bajar de peso e intentar ganar musculos',
            'email' => 'john@test.cl',
            'password' => bcrypt('sandi.,2024'),
        ]);

        $patient = Patient::create([
            'nutritionist_id' => $nutritionist->id,
            'patient_id' => $user->id,
        ]);

        $user->assignRole('paciente');


        $nutritional_profile = NutritionalProfile::create([
            'patient_id' => $user->id,
            'height' => 1.72,
            'weight' => 92,
            'physical_activity' => [
                'actividad' => 'No',
                'tiempo' => [
                    'cantidad' => 2,
                    'unidad' => 'años'
                ],
            ],
            'habits' => [
                'alcohol' => [
                    'actividad' => 'No',
                    'comentario' => 'No tomo alcohol',
                ],
                'tabaco'  => [
                    'actividad' => 'Si',
                    'comentario' => 'Fumador social',
                ],
            ],
            'allergies' => [
                'alergia' => 'Si',
                'alergias' => [
                    'Maní',
                    'Frutos secos',
                    'Mariscos',
                ],
            ],
            'intolerances' => [
                'intolerancia' => 'Si',
                'intolerancias' => [
                    'Lactosa',
                    'Mariscos',
                    'Carnes',
                ],
            ],
            'family_antecedents' => [],
            'subjective_assessment' => [],
            'nutritional_anamnesis' => [
                'plan_anterior' => 'No',
                'agua' => [
                    'toma_agua' => 'Si',
                    'cantidad' => 'Alta',
                ],
                'observaciones' => [],
            ],
        ]);

    }
}
