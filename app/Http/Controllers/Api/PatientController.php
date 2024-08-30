<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Http\Resources\UserResource;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:users.view_patient_users'])->only(['index','show']);
        $this->middleware(['can:users.create_patient_users'])->only('store');
        $this->middleware(['can:delete_patient_users'])->only('delete');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::where('nutritionist_id', Auth::id())->get();
        $patient_users = User::whereIn('id', $patients->pluck('patient_id'))->get();
        return UserResource::collection($patient_users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        $patient = Patient::create([
            'nutritionist_id' => Auth::id(),
            'patient_id' => $request->patient_id,
        ]);

        return new UserResource($patient);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $patient = User::with('nutritionalProfile')->find($patient->patient_id);
        return new PatientResource($patient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return response()->json([
            'message' => 'Paciente desvinculado satisfactoriamente'
        ]);
    }
}
