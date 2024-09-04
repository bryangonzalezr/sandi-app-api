<?php

namespace App\Http\Controllers\Api;

use App\Enums\GetMethod;
use App\Enums\UserSex;
use App\Http\Controllers\Controller;
use App\Http\Resources\FoodIndicatorResource;
use App\Models\FoodIndicator;
use App\Models\NutritionalRequirement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NutritionalRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nutritionalRequirements = NutritionalRequirement::all();

        return response()->json([
            "data" => $nutritionalRequirements
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|numeric|exists:users,id',
            'method' => ['required', Rule::enum(GetMethod::class)],
            'rest_type' => Rule::requiredIf($request->method == GetMethod::HarrisBenedict),
        ]);

        $patient = User::where('id', $request->patient_id)->first();
        $nutritionalProfile = $patient->nutritionalProfile;

        $morbid_antecedents = [
            $nutritionalProfile->morbid_antecedents["dm2"] ,
            $nutritionalProfile->morbid_antecedents["hta"],
            $nutritionalProfile->morbid_antecedents["tiroides"],
            $nutritionalProfile->morbid_antecedents["dislipidemia"],
        ];
        foreach($morbid_antecedents as $i => $antecedent){
            if($antecedent == false){
                $morbid_antecedents[$i] = 'No';
            }else{
                $morbid_antecedents[$i] = 'Si';
            }
        }

        $morbid_antecedents[] = $nutritionalProfile->morbid_antecedents["otros"] == null ? 'No' : $nutritionalProfile->morbid_antecedents["otros"];
        $rest_factor = $request->rest_type == null ? 'No' : $request->rest_type;
        $requirements_path = app_path('Scripts') . '/requirements.py';
        $params = [
            $requirements_path,   // Ruta del script
            $request->input('method'),
            $morbid_antecedents[0],
            $morbid_antecedents[1],
            $morbid_antecedents[2],
            $morbid_antecedents[3],
            $morbid_antecedents[4],
            $rest_factor,
            $nutritionalProfile->nutritional_state,
            $nutritionalProfile->physical_status,
            $nutritionalProfile->patient_type,
            $nutritionalProfile->weight,
            $nutritionalProfile->height,
            $patient->sex->value,
            $patient->age,
        ];

        $output = [];
        $response = exec('python3 ' . implode(' ', $params) . ' 2>&1', $output);
        $response = explode(',', $response);

        if ($response[0] == 'error') {
            return response()->json([
                'message' => 'Error al calcular los requerimientos',
                'error' => $response[1],
            ], 400);
        } elseif ($response[0] == 'ok'){
            if($response[1] == '0'){
                return response()->json([
                    'message' => 'Error al calcular los requerimientos',
                    'error' => $response[1],
                ], 400);
            }
            $nutritionalRequirement = NutritionalRequirement::updateOrCreate([
                'patient_id'    => $request->patient_id,
            ],
            [
                'get'           => floatval($response[1]),
                'proteina'      => floatval($response[2]),
                'lipidos'       => floatval($response[3]),
                'carbohidratos' => floatval($response[4]),
                'agua'          => floatval($response[5]),
            ]);

            return response()->json([
                "data" => $nutritionalRequirement
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $patient)
    {
        $nutritionalRequirement = $patient->nutritionalRequirement;
        return response()->json([
            "data" => $nutritionalRequirement
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NutritionalRequirement $nutritionalRequirement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NutritionalRequirement $nutritionalRequirement)
    {
        //
    }
}
