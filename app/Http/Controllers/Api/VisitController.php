<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNutritionalProfileRequest;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Requests\UpdateVisitRequest;
use App\Http\Resources\VisitResource;
use App\Models\NutritionalProfile;
use App\Models\Progress;
use App\Models\Visit;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visits = Visit::all();

        return VisitResource::collection($visits);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVisitRequest $visit, StoreNutritionalProfileRequest $request)
    {
        $visit = Visit::create([
            'patient_id' => $request->patient_id,
            'date' => $visit->date,
        ]);

        $nutritional_profile = NutritionalProfile::where('patient_id', $request->patient_id)->first();
        $nutritional_profile->update($request->validated());

        $imc = $request->weight / ($request->height * $request->height);
        $progress = Progress::create([
            'patient_id' => $request->patient_id,
            'imc' => $imc,
            ''
        ]);

        return new VisitResource($visit);
    }

    /**
     * Display the specified resource.
     */
    public function show(Visit $visit)
    {
        return new VisitResource($visit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVisitRequest $request, Visit $visit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit)
    {
        $visit->delete();

        return response()->json([
            'message' => 'Consulta eliminada satisfactoriamente'
        ]);
    }
}
