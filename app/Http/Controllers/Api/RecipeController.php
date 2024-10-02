<?php

namespace App\Http\Controllers\Api;

use App\Enums\Health;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetRecipeRequest;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Patient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:recipe.view'])->only(['index', 'show']);
        //$this->middleware(['can:recipe.view_any'])->only('');
        $this->middleware(['can:recipe.create'])->only('store');
        $this->middleware(['can:recipe.update'])->only('update');
        $this->middleware(['can:recipe.delete'])->only('delete');
        $this->middleware(['can:recipe.generate'])->only('getRecipeFromApi');
    }
        /**
     * Muestra el listado de recetas
     * de los pacientes del nutricionista
     */
    public function index()
    {
        $patient = Patient::where('nutritionist_id', Auth::id())->pluck('patient_id');
        $recipes = Recipe::whereIn('user_id', $patient)
        ->orderBy('created_at','asc')
        ->paginate(15);

        return RecipeResource::collection($recipes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request)
    {
        $recipe = Recipe::create($request->validated());

        return new RecipeResource($recipe);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        return new RecipeResource($recipe);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $recipe->update($request->validated());

        return new RecipeResource($recipe);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return response()->json([
            'message' => 'Receta eliminada satisfactoriamente',
        ]);
    }

    public function getRecipeFromApi(GetRecipeRequest $request)
    {
        try {
            $auth_user = User::find($request->input('user_id'));
            if ($auth_user->hasRole('paciente')) {
                $nutritional_profile = $auth_user->nutritionalProfile;

                $request['health'] = $nutritional_profile->allergies;
            }


            $params = [
                'type' => 'public',
                'beta' => false,
                'app_id' => config('recipe_api.edamam.id'),
                'app_key' => config('recipe_api.edamam.key'),
            ];

            $fields = [
                "label",
                "dietLabels",
                "healthLabels",
                "dishType",
                "cautions",
                "ingredientLines",
                "calories",
                "totalTime",
            ];

            // Añadir los parámetros adicionales del usuario
            foreach ($request->all() as $key => $value) {
                if ($value !== null) {
                    if ($key === "nutrients") {
                        foreach ($value as $nut_key => $nut_value) {
                            if (strpos($nut_value, '%2B') !== false || strpos($nut_value, '-') !== false) {
                                $params[$key . "%5B" . $nut_key . "%5D"] = $nut_value;
                            }
                        }
                    } elseif ($key === "query") {
                        $params["q"] = $value;
                    } else {
                        $params[$key] = $value;
                    }
                }
            }
            $url = "https://api.edamam.com/api/recipes/v2?" . http_build_query($params);

            foreach ($fields as $field) {
                $url .= '&field=' . urlencode($field);
            }
            // Realizar la solicitud a la API
            $response = Http::get($url);
            if ($response->successful()) {
                $data = $response->json();
                $hits = $data['hits'] ?? [];
                if (count($hits) === 0) {
                    $recipe = response()->json([
                        "message" => "No se encontraron recetas con los parámetros proporcionados"
                    ]);
                } else {
                    $recipe = $hits[array_rand($hits)];
                    if($request->filled('patient_id')){
                        $patient = User::find($request->input('patient_id'));
                        if ($patient->hasRole('paciente')){
                            $recipe['user_id'] = $request->input('patient_id');
                        }
                    }
                }

                return response()->json($recipe);
            } else {
                return response()->json($response->json(), $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener recetas de la API',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
