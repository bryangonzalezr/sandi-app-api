<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserSex;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\NutritionalProfileResource;
use App\Http\Resources\UserResource;
use App\Models\NutritionalProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:users.view_own'])->only(['index','show']);
        $this->middleware(['can:nutritional_profile.view_own'])->only('nutritionalProfile');
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

    public function nutritionalProfile(User $user)
    {
        if (Auth::user()->id != $user->id) {
            return response()->json(
                [
                    'message' => 'No tienes permisos para ver este recurso',
                ],
                403
            );
        }else{
            $nutritional_profile = $user->nutritionalProfile;
        }

        return new NutritionalProfileResource($nutritional_profile);
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
            'sex' => $request->sex,
            'birthdate' => $request->birthdate,
            'age' => Carbon::parse($request->birthdate)->age,
            'phone_number' => $request->phone_number,
            'description' => $request->description,
            'objectives' => $request->objectives,
        ]);

        $nutritional_profile = NutritionalProfile::where('patient_id', $user->id)->first();
        $nutritional_profile->update([
            'habits' => $request->habits,
            'physical_status' => $request->physical_status,
            'physical_comentario' => $request->physical_comentario,
            'allergies' => $request->allergies,
            'nutritional_anamnesis' => $request->nutritional_anamnesis,
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
