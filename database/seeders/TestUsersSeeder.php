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
            'physical_activity' => false,
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
            'physical_activity' => true,
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
    }
}
