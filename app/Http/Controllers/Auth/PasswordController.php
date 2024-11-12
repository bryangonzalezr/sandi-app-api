<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function newPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', Rules\Password::defaults()],
            'new_password' => ['required', 'confirmed', Rules\Password::defaults()],

        ]);

        if($request->password == $request->new_password){
            return response()->json([
                'message' => 'La contraseña actual y la nueva son iguales'
            ], 422);
        }

        $user = User::where('email',$request->email)->first();
        if(!Hash::check($request->password,$user->password)){
            return response()->json([
                'message' => 'La contraseña actual es incorrecta'
            ],422);
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $user->forceFill([
            'password' => Hash::make($request->string('new_password')),
            'password_reset' => 0
        ])->save();


        event(new PasswordReset($user));

        return new UserResource($user);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email',$request['email'])->first();
        if(!$user){
            return response()->json([
                'message' => 'Este correo es inválido'
            ],401);
        }else{
            $password = Str::random(16);
            $user->forceFill([
                'password' => bcrypt($password),
                'password_reset' => true
            ])->save();
        }

        Mail::to($request->email)->send(new ForgotPassword($user, $password));


        return response()->json(['status' => 'Se ha enviado un correo para que pueda recuperar su contraseña']);
    }
}
