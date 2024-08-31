<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNutritionalProfileRequest;
use App\Http\Requests\UpdateNutritionalProfileRequest;
use App\Http\Requests\UserNutritionalProfileRequest;
use App\Http\Resources\NutritionalProfileResource;
use App\Models\NutritionalProfile;

class NutritionalProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:nutritional_profile.view'])->only(['index','show']);
        $this->middleware(['can:nutritional_profile.create'])->only('store');
        $this->middleware(['can:nutritional_profile.update'])->only('update');
        $this->middleware(['can:nutritional_profile.delete'])->only('delete');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nutritional_profiles = NutritionalProfile::all();

        return NutritionalProfileResource::collection($nutritional_profiles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserNutritionalProfileRequest $nut_profile)
    {
        $nutritional_profile = NutritionalProfile::create([
            'patient_id' => $nut_profile->patient_id,
            'habits' => $nut_profile->habits,
            'physical_activity' => $nut_profile->physical_activity,
            'allergies' => $nut_profile->allergies,
            'nutritional_anamnesis' => $nut_profile->nutritional_anamnesis,
        ]);

        return new NutritionalProfileResource($nutritional_profile);
    }

    /**
     * Display the specified resource.
     */
    public function show(NutritionalProfile $nutritionalProfile)
    {
        $nutritional_profile = NutritionalProfile::find($nutritionalProfile);

        return new NutritionalProfileResource($nutritional_profile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNutritionalProfileRequest $request, NutritionalProfile $nutritionalProfile)
    {
        $nutritionalProfile->update($request->validated());

        return new NutritionalProfileResource($nutritionalProfile);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NutritionalProfile $nutritionalProfile)
    {
        $nutritionalProfile->delete();

        return response()->json([
            'message' => 'Perfil nutricional eliminado correctamente'
        ]);
    }
}
