<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNutritionalPlanRequest;
use App\Http\Requests\UpdateNutritionalPlanRequest;
use App\Http\Resources\NutritionalPlanResource;
use App\Models\NutritionalPlan;

class NutritionalPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nutritional_plans = NutritionalPlan::all();

        return NutritionalPlanResource::collection($nutritional_plans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNutritionalPlanRequest $request)
    {
        $nutritional_plans = NutritionalPlan::create($request->validated());

        return new NutritionalPlanResource($nutritional_plans);
    }

    /**
     * Display the specified resource.
     */
    public function show(NutritionalPlan $nutritionalPlan)
    {
        return new NutritionalPlanResource($nutritionalPlan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNutritionalPlanRequest $request, NutritionalPlan $nutritionalPlan)
    {
        $nutritionalPlan->update($request->validated());

        return new NutritionalPlanResource($nutritionalPlan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NutritionalPlan $nutritionalPlan)
    {
        $nutritionalPlan->delete();

        return response()->json([
            'message' => 'Nutritional plan deleted successfully',
        ]);
    }
}
