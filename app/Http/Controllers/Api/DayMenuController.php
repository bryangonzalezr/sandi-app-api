<?php

namespace App\Http\Controllers\Api;

use App\Enums\Health;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetRecipeRequest;
use App\Http\Requests\StoreDayMenuRequest;
use App\Http\Requests\UpdateDayMenuRequest;
use App\Http\Resources\DayMenuResource;
use App\Models\DayMenu;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DayMenuController extends Controller
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
        $day_menu = DayMenu::create($request->validated());
        $day_menu["type"] = "diario";

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
            $auth_user = User::find($request->input('user_id'));
            if ($auth_user->hasRole('paciente')) {
                $nutritional_profile = $auth_user->nutritionalProfile;

                $request['health'] = $nutritional_profile->allergies;
            }

            $day_menu = [
                "recipes" => [],
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
}
