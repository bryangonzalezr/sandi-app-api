<?php

namespace Database\Seeders;

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
        $user = User::create([
            'name' => 'Belen',
            'last_name' => 'Isuani',
            'sex' => 'Femenino',
            'birthdate' => $birthdate,
            'age' => Carbon::parse($birthdate)->age,
            'phone_number' => '989220812',
            'civil_status' => 'Casada',
            'description' => '',
            'objectives' => '',
            'email' => 'belen@test.cl',
            'password' => bcrypt('sandi.,2024'),
        ]);

        $user->assignRole('nutricionista');

        $birthdate = Carbon::createFromFormat('Y-m-d', '1990-01-14');
        $user = User::create([
            'name' => 'Claudia',
            'last_name' => 'Varela',
            'sex' => 'Femenino',
            'birthdate' => $birthdate,
            'age' => Carbon::parse($birthdate)->age,
            'phone_number' => '911112222',
            'civil_status' => 'Casada',
            'description' => '',
            'objectives' => 'Bajar de peso',
            'email' => 'claudia@test.cl',
            'password' => bcrypt('sandi.,2024'),
        ]);

        $user->assignRole('paciente');
    }
}
