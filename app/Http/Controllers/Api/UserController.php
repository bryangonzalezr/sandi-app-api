<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserSex;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:users.view_own'])->only(['index','show']);
        $this->middleware(['can:users.update_own'])->only('update');
    }
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
    /* public function store(StoreUserRequest $request)
    {
        $civil_status = $request->sex == UserSex::Masculino ? 'Soltero' : 'Soltera';
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'sex' => $request->user_sex,
            'birthdate' => $request->birthdate,
            'age' => Carbon::parse($request->birthdate)->age,
            'phone_number' => $request->phone_number,
            'civil_status' => $civil_status,
            'description' => $request->description,
            'objectives' => $request->objectives,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);

        return new UserResource($user);
    } */

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
            'age' => Carbon::parse($request->birthdate)->age,
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

    /**
     * Obtiene la lista de roles
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function roleList(Request $request)
    {
        $roles = Role::all();

        $roles = $roles->map(function ($rol) {
            return [
                'name' => $rol->name,
                'display_name' => $rol->display_name
            ];
        })->values();

        return JsonResource::collection($roles);
    }
}
