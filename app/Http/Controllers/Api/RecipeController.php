<?php

namespace App\Http\Controllers\Api;

use App\Enums\Health;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetRecipeRequest;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:recipe.view'])->only(['index','show']);
        //$this->middleware(['can:recipe.view_any'])->only('');
        $this->middleware(['can:recipe.create'])->only('store');
        $this->middleware(['can:recipe.update'])->only('update');
        $this->middleware(['can:recipe.delete'])->only('delete');
        $this->middleware(['can:recipe.generate'])->only('getRecipeFromApi');

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::all();

        return RecipeResource::collection($recipes);
    }

    /**
     * Muestra el listado de recetas
     * de los pacientes del nutricionista
     */
    public function recipes(User $user)
    {
        $recipes = Recipe::where('user_id',$user->id)->get();

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
            'message' => 'Receta eliminado satisfactoriamente',
        ]);
    }

    public function getRecipeFromApi(GetRecipeRequest $request)
    {
        try {
            $auth_user = User::find(Auth::id());
            $nutritional_profile = $auth_user->nutritionalProfile;
            $allergies = [];
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
                "mealType",
                "dishType",
                "cautions",
                "ingredientLines",
                "calories",
                "glycemicIndex",
                "inflammatoryIndex",
                "totalTime",
            ];
            $health_translation = Health::translation();

            foreach($health_translation as $key => $value){
                foreach($nutritional_profile->allergies as $k => $allergie){
                    if ($value === $allergie){
                        $allergies[] = Health::tryName($key);
                    }
                }
            }

            $request['health'] = $allergies;

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
        $url = "https://api.edamam.com/api/recipes/v2?". http_build_query($params);

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
