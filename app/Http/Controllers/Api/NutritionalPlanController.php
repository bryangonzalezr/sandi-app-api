<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNutritionalPlanRequest;
use App\Http\Requests\UpdateNutritionalPlanRequest;
use App\Models\NutritionalPlan;

class NutritionalPlanController extends Controller
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
    public function store(StoreNutritionalPlanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NutritionalPlan $nutritionalPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNutritionalPlanRequest $request, NutritionalPlan $nutritionalPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NutritionalPlan $nutritionalPlan)
    {
        //
    }
}
