<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetRecipeRequest;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::all();

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
        /* try {
            $url = "https://api.edamam.com/api/recipes/v2";

        $params = [
            'type' => 'public',
            'beta' => false,
            'app_id' => env('EDAMAM_APP_ID'),
            'app_key' => env('EDAMAM_APP_KEY'),
            "field" => [
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
            ]
        ];

        foreach ($userData as $key => $value) {
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

        $response = Http::get($url, $params);
        dd($response->json());
        if ($response->successful()) {
            $data = $response->json();
            dd($data);
            $hits = $data['hits'] ?? [];

            if (count($hits) === 0) {
                $recipe = ["message" => "No se encontraron recetas con los parámetros proporcionados"];
            } else {
                $randomRecipe = $hits[array_rand($hits)];
                $recipe = Recipe::fromArray($randomRecipe['recipe']);
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
        } */
    }
}
