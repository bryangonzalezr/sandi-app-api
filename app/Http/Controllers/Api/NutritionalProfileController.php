<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNutritionalProfileRequest;
use App\Http\Requests\UpdateNutritionalProfileRequest;
use App\Models\NutritionalProfile;

class NutritionalProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNutritionalProfileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NutritionalProfile $nutritionalProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNutritionalProfileRequest $request, NutritionalProfile $nutritionalProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NutritionalProfile $nutritionalProfile)
    {
        //
    }
}
