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
        // Usuario Basico
        $birthdate = Carbon::createFromFormat('Y-m-d', '1999-06-20');
        $basic = User::create([
            'name' => 'Juan',
            'last_name' => 'Miranda',
            'sex' => 'Masculino',
            'birthdate' => $birthdate,
            'age' => Carbon::parse($birthdate)->age,
            'phone_number' => fake()->phoneNumber,
            'civil_status' => 'Soltero(a)',
            'objectives' => '',
            'email' => 'juan@test.cl',
            'password' => bcrypt('sandi.,2024'),
        ]);

        $basic->assignRole('usuario_basico');

        // Nutricionista
        $birthdate = Carbon::createFromFormat('Y-m-d', '1988-06-20');
        $nutritionist = User::create([
            'name' => 'Belen',
            'last_name' => 'Isuani',
            'sex' => 'Femenino',
            'birthdate' => $birthdate,
            'age' => Carbon::parse($birthdate)->age,
            'phone_number' => '989220812',
            'civil_status' => 'Casado(a)',
            'objectives' => '',
            'email' => 'belen@test.cl',
            'password' => bcrypt('sandi.,2024'),
        ]);

        $nutritionist->assignRole('nutricionista');

        // Pacientes
        $birthdate = Carbon::createFromFormat('Y-m-d', '1990-01-14');
        $user = User::create([
            'name' => 'Claudia',
            'last_name' => 'Varela',
            'sex' => 'Femenino',
            'birthdate' => $birthdate,
            'age' => Carbon::parse($birthdate)->age,
            'phone_number' => '911112222',
            'civil_status' => 'Casado(a)',
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
            'physical_status' => 'Leve',
            'physical_comentario' => 'No realiza actividad fisica',
            'habits' => [
                'alcohol' =>  'Alto',
                'tabaco'  => 'Nada',
            ],
            'allergies' => [
                'Mani',
                'Frutos Secos',
                'Marisco',
            ],
            'morbid_antecedents' => [
                'dm2' => false,
                'hta' => false,
                'tiroides' => false,
                'dislipidemia' => false,
                'cirugias' => [],
                'otros' => null,
            ],
            'patient_type' => 'Ambulatorio',
            'family_antecedents' => [],
            'subjective_assessment' => [],
            'nutritional_anamnesis' => [
                'plan_anterior' => 'No',
                'agua' => true,
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
            'physical_status' => 'Moderada',
            'physical_comentario' => 'Realiza actividad fisica 3 veces a la semana',
            'habits' => [
                'alcohol' =>  'Nada',
                'tabaco'  => 'Moderado',
            ],
            'allergies' => [
                'Lacteos',
                'Vegetariano'
            ],

            'morbid_antecedents' => [
                'dm2' => false,
                'hta' => false,
                'tiroides' => false,
                'dislipidemia' => false,
                'cirugias' => [],
                'otros' => null,
            ],
            'patient_type' => 'Ambulatorio',
            'family_antecedents' => [],
            'subjective_assessment' => [],
            'nutritional_anamnesis' => [
                'plan_anterior' => false,
                'agua' => true,
            ],
        ]);

        $birthdate = Carbon::createFromFormat('Y-m-d', '2003-09-18');
        $user = User::create([
            'name' => 'Karla',
            'last_name' => 'Maturana',
            'sex' => 'Femenino',
            'birthdate' => $birthdate,
            'age' => Carbon::parse($birthdate)->age,
            'phone_number' => fake()->phoneNumber,
            'civil_status' => 'Soltero(a)',
            'objectives' => 'Empezar una dieta vegana',
            'email' => 'karla@test.cl',
            'password' => bcrypt('sandi.,2024'),
        ]);

        $patient = Patient::create([
            'nutritionist_id' => $nutritionist->id,
            'patient_id' => $user->id,
        ]);

        $user->assignRole('paciente');


        $nutritional_profile = NutritionalProfile::create([
            'patient_id' => $user->id,
            'height' => 1.55,
            'weight' => 47,
            'physical_status' => 'Alta',
            'physical_comentario' => 'Todos los días en las mañanas, 5 días a la semana, puro cardio,descanso fines de semana.',
            'habits' => [
                'alcohol' =>  'Alto',
                'tabaco'  => 'Moderado',
            ],
            'allergies' => [
                'Soya',
                'Vegano'
            ],

            'morbid_antecedents' => [
                'dm2' => false,
                'hta' => false,
                'tiroides' => false,
                'dislipidemia' => false,
                'cirugias' => [],
                'otros' => null,
            ],
            'patient_type' => 'Ambulatorio',
            'family_antecedents' => [],
            'subjective_assessment' => [],
            'nutritional_anamnesis' => [
                'plan_anterior' => false,
                'agua' => true,
            ],
        ]);
    }
}
