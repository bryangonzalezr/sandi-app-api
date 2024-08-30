<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserSex;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNutritionalProfileRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserNutritionalProfileRequest;
use App\Models\NutritionalProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreUserRequest $request, UserNutritionalProfileRequest $nut_profile): Response
    {
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'sex' => $request->user_sex,
            'birthdate' => $request->birthdate,
            'age' => Carbon::parse($request->birthdate)->age,
            'phone_number' => $request->phone_number,
            'civil_status' => $request->civil_status,
            'objectives' => $request->objectives,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);

        $nutritionalProfile = NutritionalProfile::create([
            'patient_id' => $user->id,
            'habits' => $nut_profile->habits,
            'physical_activity' => $nut_profile->physical_activity,
            'allergies' => $nut_profile->allergies,
            'nutritional_anamnesis' => $nut_profile->nutritional_anamnesis,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
