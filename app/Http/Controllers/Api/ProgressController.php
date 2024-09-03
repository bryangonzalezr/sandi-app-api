<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgressRequest;
use App\Http\Requests\UpdateProgressRequest;
use App\Http\Resources\ProgressResource;
use App\Models\Patient;
use App\Models\Progress;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
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
    public function store(StoreProgressRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $patient)
    {
        $user = User::find(Auth::id());

        if($user->hasRole('nutricionista')){
            $patient_user = Patient::where('nutritionist_id', $user->id)->where('patient_id', $patient->id)->first();
            $progress = $patient_user ? Progress::where('patient_id', $patient->id)->get(): null;
        }else{
            $progress = Progress::where('patient_id', $user->id)->get();
        }

        return ProgressResource::collection($progress);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgressRequest $request, Progress $progress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Progress $progress)
    {
        //
    }
}
