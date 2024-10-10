<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RegistrationTest extends TestCase
{

    public function test_new_users_can_register(): void
    {
        $user = User::factory()->make();

        $response = $this->postJson(route('register'), [
            'name' => $user->name,
            'last_name' => $user->last_name,
            'sex' => $user->sex,
            'birthdate' => $user->birthdate,
            'age' => Carbon::parse($user->birthdate)->age,
            'phone_number' => $user->phone_number,
            'civil_status' => $user->civil_status,
            'description' => $user->description,
            'objectives' => $user->objectives,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'nutricionista'
        ]);

        $response->assertStatus(200);
    }
}
