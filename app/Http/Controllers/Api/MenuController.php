<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetRecipeRequest;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Http\Resources\MenuResource;
use App\Models\ApiMenu;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:menu.view'])->only(['index','show']);
        $this->middleware(['can:menu.create'])->only('store');
        $this->middleware(['can:menu.update'])->only('update');
        $this->middleware(['can:menu.delete'])->only('delete');
        $this->middleware(['can:menu.generate'])->only('generateMenu');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $menus = Menu::when($request->filled('type'), function ($query) use ($request) {
            if ($request->type === 'semanal') {
                $query->where('timespan', 7);
            } elseif ($request->type === 'mensual') {
                $query->whereBetween('timespan', [28, 31]);
            }
        })->get();

        return MenuResource::collection($menus);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        $menu = Menu::create($request->validated());

        return new MenuResource($menu);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return new MenuResource($menu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());

        return new MenuResource($menu);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response()->json([
            'message' => 'Menú eliminado satisfactoriamente',
        ]);
    }

    public function generateMenu(GetRecipeRequest $request)
    {
        try {
            $api_tokens = ApiMenu::first();
            $request->validate([
                'timespan' => 'required|integer',
            ]);

            $menu = [
                "menus" => null,
                "total_calories" => 0,
            ];

            $day_menu = [
                "recipes" => [],
                "total_calories" => 0,
            ];
            $params = [
                'type' => 'public',
                'beta' => false,
                'app_id' => $api_tokens->api_id,
                'app_key' => $api_tokens->api_key,
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

            // Añadir los parámetros adicionales del usuario
            foreach ($request->validated() as $key => $value) {
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


            $meal_types = ["breakfast", "lunch", "dinner"];

            $url = "https://api.edamam.com/api/recipes/v2?" . http_build_query($params);

            foreach ($fields as $field) {
                $url .= '&field=' . urlencode($field);
            }

            $count_api = 0;
            $skip = 0;
            for($i=0; $i<$request->timespan; $i++){
                foreach ($meal_types as $meal_type) {
                    $url .= '&mealType=' . urlencode($meal_type);

                    // Realizar la solicitud a la API
                    if($count_api === 10){
                        $skip = $skip == $api_tokens->count() ? 1 : $skip + 1;
                        $api_tokens = ApiMenu::find($skip);

                        $params['app_id'] = $api_tokens->api_id;
                        $params['app_key'] = $api_tokens->api_key;
                        $url = "https://api.edamam.com/api/recipes/v2?" . http_build_query($params);
                        foreach ($fields as $field) {
                            $url .= '&field=' . urlencode($field);
                        }
                        $count_api = 0;
                    }
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
                            $day_menu["recipes"][] = $recipe['recipe'];
                            $day_menu["total_calories"] += $recipe['recipe']['calories'];

                        }
                    } else {
                        return response()->json($response->json(), $response->status());
                    }
                    $count_api++;
                }
                $menu["menus"] = $day_menu["recipes"];
                $menu["total_calories"] += $day_menu["total_calories"];
            }
            return response()->json($menu);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al generar el menú',
            ], 500);
        }
    }
}
