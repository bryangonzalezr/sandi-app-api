<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortionRequest;
use App\Http\Requests\UpdatePortionRequest;
use App\Http\Resources\PortionResource;
use App\Models\Portion;
use App\Models\User;
use Illuminate\Http\Request;

class PortionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $portions = Portion::when($request->filled('patient_id'), function ($query) use ($request) {
            $query->where('patient_id', $request->patient_id);
        })->get();

        return PortionResource::collection($portions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePortionRequest $request)
    {
        $portion = Portion::updateOrCreate([
            'patient_id' => $request->patient_id
        ],[
            'total_calorias' => $request->total_calorias,
            'cereales' => $request->cereales,
            'verduras_gral' => $request->verduras_gral,
            'verduras_libre_cons' => $request->verduras_libre_cons,
            'frutas' => $request->frutas,
            'carnes_ag' => $request->carnes_ag,
            'carnes_bg' => $request->carnes_bg,
            'legumbres' => $request->legumbres,
            'lacteos_ag' => $request->lacteos_ag,
            'lacteos_bg' => $request->lacteos_bg,
            'lacteos_mg' => $request->lacteos_mg,
            'aceites_grasas' => $request->aceitas_grasas,
            'alim_ricos_lipidos' => $request->alim_ricos_lipidos,
            'azucares' => $request->azucares,
        ]);

        return new PortionResource($portion);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $patient)
    {
        $portions = $patient->portions;
        return new PortionResource($portions);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePortionRequest $request, Portion $portion)
    {
        $portion->update($request->validated());
        return new PortionResource($portion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portion $portion)
    {
        //
    }
}
