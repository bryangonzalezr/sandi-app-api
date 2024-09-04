<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServicePortionRequest;
use App\Http\Requests\UpdateServicePortionRequest;
use App\Http\Resources\ServicePortionResource;
use App\Models\Portion;
use App\Models\ServicePortion;
use App\Models\User;
use Illuminate\Http\Request;

class ServicePortionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $service_portions = ServicePortion::all();

        return $service_portions;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServicePortionRequest $request)
    {
        $portions = Portion::where('patient_id', $request->patient_id)->get();
        $service_portion = ServicePortion::create($request->validated());

        return new ServicePortionResource($service_portion);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $patient)
    {
        $servicePortion = $patient->servicePortion;
        return new ServicePortionResource($servicePortion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServicePortionRequest $request, ServicePortion $servicePortion)
    {
        $servicePortion->update($request->validated());
        return new ServicePortionResource($servicePortion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServicePortion $servicePortion)
    {
        $servicePortion->delete();
        return response()->json([
            'message' => 'Porción de servicio eliminada correctamente'
        ], 204);
    }
}
