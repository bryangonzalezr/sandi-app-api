<?php

namespace App\Http\Controllers\Api;

use App\Enums\Health;
use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetRecipeRequest;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Http\Resources\MenuListResource;
use App\Http\Resources\MenuResource;
use App\Models\ApiMenu;
use App\Models\DayMenu;
use App\Models\Menu;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = User::find(Auth::id());

        $patient = Patient::when($user->hasRole('nutricionista'), function ($query) {
            $query->where('nutritionist_id', Auth::id());
        })->pluck('patient_id');

        $menus = Menu::when($request->filled('type'), function ($query) use ($request) {
            if ($request->type === 'semanal') {
                $query->where('timespan', 7);
            } elseif ($request->type === 'mensual') {
                $query->whereBetween('timespan', [28, 31]);
            }
        })->when($user->hasRole('nutricionista'), function ($query) use ($patient) {
            $query->whereIn('user_id', $patient);
        })->when($user->hasRole('paciente'), function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->orderBy('created_at','asc')
        ->paginate(15);

        return MenuResource::collection($menus);
    }

    public function menusList(Request $request)
    {
        $request->validate(
            [
                'patient' => ['nullable', 'numeric'],
                'sandi' => ['nullable', 'boolean'],
                'type' => ['nullable', 'string']
            ]
            );
        $user = User::find(Auth::id());

        $patient = Patient::when($user->hasRole('nutricionista'), function ($query) {
            $query->where('nutritionist_id', Auth::id());
        })->pluck('patient_id');

        $day_menus = DayMenu::when($request->filled('type'), function ($query) use ($request, $user, $patient) {
                $query->where('type', $request->input('type'));
        })->when($user->hasRole('nutricionista'), function ($query) use ($patient, $request) {
            $query->whereIn('user_id', $patient)->when($request->filled('patient'), function ($query) use ($request){
                $query->where('user_id', $request->integer('patient'));
            });
        })->when($user->hasRole('paciente'), function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->when($request->filled('sandi'), function ($query) use ($request) {
            $query->where('sandi_recipe', $request->boolean('sandi'));
        })->get();

        $menus = Menu::when($request->filled('type'), function ($query) use ($request) {
            if ($request->type === 'semanal') {
                $query->where('timespan', 7);
            } elseif ($request->type === 'mensual') {
                $query->whereBetween('timespan', [28, 31]);
            } elseif($request->type === 'diario'){
                $query->where('timespan', 1);
            }
        })->when($user->hasRole('nutricionista'), function ($query) use ($patient, $request) {
            $query->whereIn('user_id', $patient)
                  ->when($request->filled('patient'), function ($query) use ($request){
                $query->where('user_id', $request->integer('patient'));
            });
        })->when($user->hasRole('paciente'), function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->when($request->filled('sandi'), function ($query) use ($request) {
            $query->where('sandi_recipe', $request->boolean('sandi'));
        })->get();

        $menus_list = $day_menus->merge($menus);

        $paginate = PaginationHelper::paginate($menus_list, 15);

        return MenuListResource::collection($paginate);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        $menu = Menu::create($request->validated());
        if ($menu->timespan == 7) {
            $menu->update([
                "type" => "semanal"
            ]);
        } elseif ($menu->whereBetween('timespan', [28, 31])) {
            $menu->update([
                "type" => "mensual"
            ]);
        }

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
        if ($menu->timespan == 7) {
            $menu->update([
                "type" => "semanal"
            ]);
        } elseif ($menu->whereBetween('timespan', [28, 31])) {
            $menu->update([
                "type" => "mensual"
            ]);
        }


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
            $auth_user = User::find($request->input('user_id'));
            if ($auth_user->hasRole('paciente')) {
                $nutritional_profile = $auth_user->nutritionalProfile;

                $request['health'] = $nutritional_profile->allergies;
            }

            $api_tokens = ApiMenu::first();
            $request->validate([
                'timespan' => 'required|integer',
            ]);

            if ($request->timespan == 7){
                $menu_type = 'semanal';
            } elseif ($request->timespan >= 28 && $request->timespan < 32){
                $menu_type = 'mensual';
            }

            $menu = [
                "menus" => null,
                "type" => $menu_type ?? null,
                "total_calories" => 0,
            ];

            if($request->filled('patient_id')){
                $patient = User::find($request->input('patient_id'));
                if ($patient->hasRole('paciente')){
                    $menu['user_id'] = $request->input('patient_id');
                }
            }

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
                $menu["menus"][$i+1] = $day_menu["recipes"];
                $menu["total_calories"] += $day_menu["total_calories"];
                $day_menu["recipes"] = [];
            }
            return response()->json($menu);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al generar el menú',
            ], 500);
        }
    }
}
