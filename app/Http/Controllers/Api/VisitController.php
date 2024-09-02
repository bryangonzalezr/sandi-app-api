<?php

namespace App\Http\Controllers\Api;

use App\Enums\NutritionalState;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNutritionalProfileRequest;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Requests\UpdateVisitRequest;
use App\Http\Resources\VisitResource;
use App\Models\NutritionalProfile;
use App\Models\Patient;
use App\Models\Progress;
use App\Models\User;
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
    public function store(StoreVisitRequest $request)
    {

        $visit = Visit::create([
            'patient_id' => $request->patient_id,
            'date' => $request->date,
        ]);
        //$patient_table = Patient::where('patient_id', $visit->patient_id)->first();
        //$request = app(StoreNutritionalProfileRequest::class, ['first_visit' => $patient_table->first_visit]);
        $patient_user = User::where('id', $request->patient_id)->first();

        $nutritional_profile = NutritionalProfile::where('patient_id', $request->patient_id)->first();

        $nutritional_profile->update($request->validated());

        $progress_path = app_path('Scripts') . '/progress.py';
        $params = [
            $progress_path,   // Ruta del script
            $request->input('bicipital_skinfold'),
            $request->input('tricipital_skinfold'),
            $request->input('subscapular_skinfold'),
            $request->input('suprailiac_skinfold'),
            $request->input('supraspinal_skinfold'),
            $request->input('thigh_skinfold'),
            $request->input('calf_skinfold'),
            $request->input('abdomen_skinfold'),
            $request->input('pb_relaj'),
            $request->input('pb_contra'),
            $request->input('forearm'),
            $request->input('thigh'),
            $request->input('calf'),
            $request->input('thorax'),
            $request->input('weight'),
            $request->input('height'),
            $patient_user->sex->value,
            $patient_user->age,
        ];

        $output = [];
        $response = exec('python3 ' . implode(' ', $params) . ' 2>&1', $output);
        $response = explode(',', $response);
        if ($response[0] == 'error') {
            return response()->json([
                'message' => 'Error al calcular el progreso',
                'error' => $response[1],
            ], 400);
        } elseif ($response[0] == 'ok'){
            if(NutritionalState::tryFrom($response[10])){
                $nutritional_profile->update([
                    'nutritional_state' => $response[10],
                ]);
            }

            /* $patient_table->update([
                'first_visit' => true,
            ]); */

            $progress = Progress::create([
                'patient_id'          => $request->patient_id,
                'imc'                 => floatval($response[1]),
                'density'             => floatval($response[2]),
                'fat_percentage'      => floatval($response[3]),
                'z_muscular'          => floatval($response[4]),
                'muscular_mass'       => floatval($response[5]),
                'muscular_percentage' => floatval($response[6]),
                'pmb'                 => floatval($response[7]),
                'amb'                 => floatval($response[8]),
                'agb'                 => floatval($response[9]),
                'nutritional_state'   => $response[10],
            ]);
        }

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
