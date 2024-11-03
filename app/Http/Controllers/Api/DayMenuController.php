<?php

namespace App\Http\Controllers\Api;

use App\Enums\Health;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetRecipeRequest;
use App\Http\Requests\StoreDayMenuRequest;
use App\Http\Requests\UpdateDayMenuRequest;
use App\Http\Resources\DayMenuResource;
use App\Jobs\ShoppingListJob;
use App\Models\DayMenu;
use App\Models\Patient;
use App\Models\Recipe;
use App\Models\ShoppingList;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DayMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:menu.view'])->only(['index','show']);
        //$this->middleware(['can:menu.create'])->only('store');
        $this->middleware(['can:menu.update'])->only('update');
        $this->middleware(['can:menu.delete'])->only('delete');
        $this->middleware(['can:menu.generate'])->only('generateMenu');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(Auth::id());

        $patient = Patient::when($user->hasRole('nutricionista'), function ($query) {
            $query->where('nutritionist_id', Auth::id());
        })->pluck('patient_id');

        $day_menus = DayMenu::when($user->hasRole('nutricionista'), function ($query) use ($patient) {
            $query->whereIn('user_id', $patient);
        })->when($user->hasRole('paciente'), function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->orderBy('created_at','asc')
        ->paginate(15);

        return DayMenuResource::collection($day_menus);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDayMenuRequest $request)
    {
        if ($request->boolean('sandi_recipe')){
            $recipes = [];
            foreach($request->input('recipes') as $recipe){
                $created_recipe = Recipe::create($recipe);
                array_push($recipes, collect($created_recipe));
            }

            $day_menu = DayMenu::firstOrCreate($request->validated());
            $day_menu->update([
                'type' => "diario",
                'recipes' => $recipes
            ]);

        } else {
            $day_menu = DayMenu::firstOrCreate($request->validated());
            $day_menu->update([
                'type' => "diario",
            ]);
        }

        ShoppingListJob::dispatch($day_menu)->onQueue('shoppingList');
        /* $list = [];
        $count_ingredients = [];
        foreach($day_menu->recipes as $recipe){
            foreach($recipe["ingredients"] as $ingredient){
                $formatted_ingredient = str_replace(' ','_',$ingredient);
                if(array_key_exists($formatted_ingredient, $count_ingredients)){
                    $count_ingredients[$formatted_ingredient] += 1;
                    continue;
                } else{
                    $scrape = $this->scrape($formatted_ingredient);
                    array_push($list, $scrape);
                    $count_ingredients[$formatted_ingredient] = 1;
                }
            }
        }

        $shopping_list = ShoppingList::create([
            'menu_id' => $day_menu->id,
            'list'    => $list,
            'amounts' => $count_ingredients
        ]); */

        return new DayMenuResource($day_menu);
    }

    /**
     * Display the specified resource.
     */
    public function show(DayMenu $dayMenu)
    {
        return new DayMenuResource($dayMenu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDayMenuRequest $request, DayMenu $dayMenu)
    {
        $dayMenu->update($request->validated());
        $dayMenu["type"] = "diario";
        $dayMenu->save();

        return new DayMenuResource($dayMenu);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DayMenu $dayMenu)
    {
        $dayMenu->delete();

        return response()->json([
            'message' => 'Menu diario eliminado satisfactoriamente',
        ]);
    }

    public function generateDayMenu(GetRecipeRequest $request)
    {
        try {
            $auth_user = User::find(Auth::id());
            if ($auth_user->hasRole('paciente')) {
                $nutritional_profile = $auth_user->nutritionalProfile;

                $request['health'] = $nutritional_profile->allergies;
            }

            $day_menu = [
                "recipes" => [],
                "type"  => "diario",
                "total_calories" => 0,
            ];

            if($request->filled('patient_id')){
                $patient = User::find($request->input('patient_id'));
                if ($patient->hasRole('paciente')){
                    $day_menu['user_id'] = $request->input('patient_id');
                }
            }

            $params = [
                'type' => 'public',
                'beta' => false,
                'app_id' => config('recipe_api.edamam.id'),
                'app_key' => config('recipe_api.edamam.key'),
            ];

            $ignore_params = [
                'timespan',
                'user_id',
                'patient_id',
            ];

            $fields = [
                "label",
                "dietLabels",
                "healthLabels",
                "mealType",
                "dishType",
                "cautions",
                "ingredientLines",
                "ingredients",
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
                } elseif (in_array($key,$ignore_params)){
                    continue;
                }
                else {
                    $params[$key] = $value;
                }
            }
        }


        $meal_types = ["breakfast", "lunch", "dinner"];

        $url = "https://api.edamam.com/api/recipes/v2?". http_build_query($params);

        foreach ($fields as $field) {
            $url .= '&field=' . urlencode($field);
        }

        foreach($meal_types as $meal_type){
            $url .= '&mealType=' . urlencode($meal_type);

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
                    $day_menu["recipes"][] = $recipe['recipe'];
                    $day_menu["total_calories"] += $recipe['recipe']['calories'];

                    $url = "https://api.edamam.com/api/recipes/v2?". http_build_query($params);
                    foreach ($fields as $field) {
                        $url .= '&field=' . urlencode($field);
                    }
                }

            } else {
                return response()->json($response->json(), $response->status());
            }
        }
        return response()->json($day_menu);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener recetas de la API',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /* private function scrape($ingredient)
    {
        $scrapper_path = app_path('Scripts/scrapper') . '/scrapper.py';
        $output = [];
        $response = exec('python3 ' . $scrapper_path . ' ' . $ingredient, $output);
        $response = explode(',', $response);

        if ($response[0] == 'error') {
            return response()->json([
                "message" => $response[1]
            ]);
        }elseif ($response[0] == 'ok') {
            return json_decode($response[1]);
        }
    } */
}
