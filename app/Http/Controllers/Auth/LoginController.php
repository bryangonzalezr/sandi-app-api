<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserNutritionalProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\NutritionalProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function register(StoreUserRequest $request){

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'sex' => $request->sex,
            'birthdate' => Carbon::parse($request->birthdate),
            'age' => Carbon::parse($request->birthdate)->age,
            'phone_number' => $request->phone_number,
            'civil_status' => $request->civil_status,
            'description' => $request->description,
            'objectives' => $request->objectives,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->assignRole($request->role);

        $nutritional_profile = NutritionalProfile::create([
            'patient_id' => $user->id,
            'nutritional_state' => "",
            'description' => "",
            'height' => 0,
            'weight' => 0,
            'physical_comentario' => "",
            'physical_status' => "",
            'habits' => [
                'alcohol' => false,
                'tabaco' => false
            ],
            'allergies' => [],
            'morbid_antecedents' => [
                'dm2' => false,
                'hta' => false,
                'tiroides' => false,
                'dislipidemia' => false,
                'insulin_resistance' => false,
                'cirugias' => null,
                'farmacos' => null,
                'exams' => null,
                'otros' => null,
            ],
            'patient_type' => "",
            'family_antecedents' => [
                'dm2' => false,
                'hta' => false,
                'tiroides' => false,
                'dislipidemia' => false,
                'comments' => null,
            ],
            'subjective_assessment' => [
                'usual_weight' => '',
                'weight_variation' => '',
                'gastrointestinal_symptoms' => '',
                'appetite' => '',
                'digestion' => '',
                'digestion_frequency' => '',
                'digestion_measures' => '',
            ],
            'nutritional_anamnesis' => [
                'plan_anterior' => false,
                'agua' => false,
            ],
        ]);

        event(new Registered($user));

        return response()->json([
            'message' => 'User Created ',
        ]);
    }

    public function login(LoginRequest $request){

        $user = User::where('email',$request['email'])->first();
        if(!$user || !Hash::check($request['password'],$user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }

        Auth::login($user);

        return new UserResource($user);
    }

    public function apiLogin(LoginRequest $request){

        $user = User::where('email',$request['email'])->first();
        if(!$user || !Hash::check($request['password'],$user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }
        // Se listan todos los permisos
        $roles = [];
        $permissions = [];
        foreach ($user->roles as $role) {
            $roles[] = $role->name;
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission->name;
            }
        }

        $token = $user->createToken('authToken', $permissions)->plainTextToken;

        return new JsonResponse(
            data: [
                'user' => new UserResource($user),
                'token' => $token,
            ],
            status: Response::HTTP_OK,
        );
    }

    public function checkSession(Request $request){
        $user = $request->user();
        return response()->json([
            'message' => 'Sesión activa',
            'user' => new UserResource($user),
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
