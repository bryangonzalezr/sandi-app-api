<?php

namespace Database\Factories;

use App\Enums\CivilStatus;
use App\Enums\UserSex;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * El nombre del modelo asociado con esta fábrica.
     *
     * @var string
     */
    protected $model = User::class;

    protected $connection = 'pgsql';

    /**
     * Define el estado por defecto de los atributos del modelo.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'sex' => $this->faker->randomElement([UserSex::Masculino, UserSex::Femenino]),
            'birthdate' => $this->faker->date(),
            'age' => $this->faker->numberBetween(18, 80),
            'phone_number' => $this->faker->phoneNumber,
            'civil_status' => $this->faker->randomElement(CivilStatus::cases()), // asumiendo que CivilStatus es un enum
            'objectives' => $this->faker->sentence,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indica que el email debe estar verificado.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function verified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Indica que el usuario es un nutricionista.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function nutritionist()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('nutricionista');
        });
    }

    /**
     * Indica que el usuario es un paciente.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function patient()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('paciente');
        });
    }

    /**
     * Indica que el usuario es un usuario básico.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function basicUser()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('usuario_basico');
        });
    }
}
