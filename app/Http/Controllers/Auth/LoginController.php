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
            'birthdate' => $request->birthdate,
            'age' => Carbon::parse($request->birthdate)->age,
            'phone_number' => $request->phone_number,
            'civil_status' => $request->civil_status,
            'description' => $request->description,
            'objectives' => $request->objectives,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->assignRole($request->role);

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
        $token = $user->createToken('authToken')->plainTextToken;
        return new JsonResponse(
            data: [
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ]
            ],
            status: Response::HTTP_OK,
        );
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
