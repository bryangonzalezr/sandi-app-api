<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNutritionalProfileRequest;
use App\Http\Requests\UpdateNutritionalProfileRequest;
use App\Http\Resources\NutritionalProfileResource;
use App\Models\NutritionalProfile;

class NutritionalProfileController extends Controller
{
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
    public function store(StoreNutritionalProfileRequest $request)
    {
        $nutritional_profile = NutritionalProfile::create($request->validated());

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
