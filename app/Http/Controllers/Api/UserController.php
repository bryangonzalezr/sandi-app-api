<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'sex' => $request->user_sex,
            'birthdate' => $request->birthdate,
            'phone_number' => $request->phone_number,
            'description' => $request->description,
            'objectives' => $request->objectives,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->asasignRole($request->rol);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'sex' => $request->user_sex,
            'birthdate' => $request->birthdate,
            'phone_number' => $request->phone_number,
            'description' => $request->description,
            'objectives' => $request->objectives,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(
            [
                'message' => 'Usuario eliminado satisfactoriamente',
            ],
            200
        );
    }
}
