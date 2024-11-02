<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNutritionalPlanRequest;
use App\Http\Requests\UpdateNutritionalPlanRequest;
use App\Http\Resources\NutritionalPlanResource;
use App\Models\NutritionalPlan;
use App\Models\NutritionalProfile;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NutritionalPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:nutritional_plan.view'])->only(['index']);
        //$this->middleware(['can:nutritional_plan.view_own'])->only('show');
        $this->middleware(['can:nutritional_plan.create'])->only('store');
        $this->middleware(['can:nutritional_plan.update'])->only('update');
        $this->middleware(['can:nutritional_plan.delete'])->only('delete');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $nutritionist = User::find(Auth::id());
        $nutri_patient = Patient::query()
        ->where('nutritionist_id', $nutritionist->id)
        ->onlyTrashed()
        ->get();

        $nutritional_plans = NutritionalPlan::when($nutri_patient->isNotEmpty(), function ($query) use ($nutri_patient) {
        })->when($request->filled('fecha_creacion'), function ($query) use ($request) {
            $query->whereDate('created_at', Carbon::createFromDate($request->fecha_creacion));
        })
        ->onlyTrashed()
        ->orderBy('created_at', 'desc')
        ->get();

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
    public function show(User $patient)
    {
        $nutritionalPlan = $patient->nutritionalPlan;
        $return = $nutritionalPlan ? new NutritionalPlanResource($nutritionalPlan) :
                    response()->json(["data" => null]);
        return $return;
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
            'message' => 'Plan nutricional archivado satisfactoriamente',
        ]);
    }
}
