<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNutritionalProfileRequest;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Requests\UpdateVisitRequest;
use App\Http\Resources\VisitResource;
use App\Models\NutritionalProfile;
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
    public function store(StoreVisitRequest $visit, StoreNutritionalProfileRequest $request)
    {
        $visit = Visit::create([
            'patient_id' => $request->patient_id,
            'date' => $visit->date,
        ]);

        $patient = User::where('id', $request->patient_id)->first();

        $nutritional_profile = NutritionalProfile::where('patient_id', $request->patient_id)->first();
        if (!$nutritional_profile) {
            $nutritional_profile = NutritionalProfile::create($request->validated());
        }else{
            $nutritional_profile->update($request->validated());
        }

        $script_path = app_path('Scripts') . '/progress.py';
        $params = [
            $script_path,   // Ruta del script
            $request->input('bicipital_skinfold'),
            $request->input('tricipital_skinfold'),
            $request->input('subscapular_skinfold'),
            $request->input('suprailiac_skinfold'),
            $request->input('supraspinal_skinfold'),
            $request->input('suprailiac_skinfold'),
            $request->input('thigh_skinfold'),
            $request->input('calf_skinfold'),
            $request->input('abdomen_skinfold'),
            $request->input('pb_relaj'),
            $request->input('pb_contra'),
            $request->input('forearm'),
            $request->input('thigh'),
            $request->input('calf'),
            $request->input('waist'),
            $request->input('thorax'),
            $request->input('weight'),
            $request->input('height'),
            $patient->sex,
            $patient->age,
        ];

        $output = [];
        $response = exec('python ' . $script_path . implode(' ', $params). ' 2>&1', $output);
        $response = explode(',', $response);

        if ($response[0] == 'error') {
            logger()->error($output);
        } elseif ($response[0] == 'ok'){
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
