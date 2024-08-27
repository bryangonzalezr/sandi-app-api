<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $birthdate = Carbon::createFromFormat('Y-m-d', '2024-01-01');
        $user = User::create([
            'name' => 'Super',
            'last_name' => 'Admin',
            'sex' => 'Masculino',
            'birthdate' => $birthdate,
            'age' => Carbon::parse($birthdate)->age,
            'phone_number' => '911112222',
            'civil_status' => 'Viudo',
            'description' => 'El super administrador de la aplicación',
            'objectives' => 'Super administrar la aplicación',
            'email' => 'sandi@test.cl',
            'password' => bcrypt('sandi.,2024'),
        ]);

        $user->assignRole('SuperAdmin');
    }
}
