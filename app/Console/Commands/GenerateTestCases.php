<?php

namespace App\Console\Commands;

use App\Enums\NutritionalState;
use App\Http\Controllers\Api\VisitController;
use App\Models\DayMenu;
use App\Models\Menu;
use App\Models\NutritionalPlan;
use App\Models\NutritionalProfile;
use App\Models\Patient;
use App\Models\Progress;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GenerateTestCases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:cases {recipes=10} {day_menus=8} {weekly_menus=8} {monthly_menus=5} {visits=3} {nutritional_plans=3}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pobla la base de datos con datos de prueba';

    public $nutritionist_id = 3;

    public $patients_ids = [4, 5, 6];

    public $patient;

    public $nutritional_requirements;

    public $portions;

    public $service_portions;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $recipes = $this->argument('recipes');
        $day_menus = $this->argument('day_menus');
        $weekly_menus = $this->argument('weekly_menus');
        $monthly_menus = $this->argument('monthly_menus');
        $visits = $this->argument('visits');
        //$nutritional_plans = $this->argument('nutritional_plans');
        if ($visits){
            $patient_id = fake()->randomElement($this->patients_ids);
            $this->patient = User::find($patient_id);
            $this->factory(new Visit, $visits, 'Consultas');
            unset($this->patient);
        }
        $this->factory(new Recipe, $recipes, 'Recetas');
        $this->factory(new DayMenu, $day_menus, 'Menus Diarios');
        $this->factory(new Menu, $weekly_menus, 'Menus Semanales');
        $this->factory(new Menu, $monthly_menus, 'Menus Mensuales');
        /*if ($nutritional_plans) {
            $this->factory(new NutritionalPlan, $nutritional_plans, 'Planes Nutricionales');
        }*/

        return 0;
    }


    public function addRecipes($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $patient_id = fake()->randomElement($this->patients_ids);
            $recipe = Recipe::factory()->make();
            Recipe::create([
                'label' => $recipe->label,
                'dietLabels' => $recipe->dietLabels,
                'healthLabels' => $recipe->healthLabels,
                'ingredientLines' => $recipe->ingredientLines,
                'calories' => $recipe->calories,
                'mealType' => $recipe->mealType,
                'dishType' => $recipe->dishType,
                'instructions' => $recipe->instructions,
                'user_id' => $patient_id,
                'sandi_recipe' => $recipe->sandi_recipe,
            ]);
        }
    }

    public function addDayMenus($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $recipes = [];

            $recipe_calories = 0;
            for ($j = 0; $j < 3; $j++) {
                $recipe = Recipe::factory()->make();
                $recipes[] = [
                    'label' => $recipe->label,
                    'dietLabels' => $recipe->dietLabels,
                    'healthLabels' => $recipe->healthLabels,
                    'ingredientLines' => $recipe->ingredientLines,
                    'calories' => $recipe->calories,
                    'mealType' => $recipe->mealType,
                    'dishType' => $recipe->dishType,
                    'instructions' => $recipe->instructions,
                    'sandi_recipe' => $recipe->sandi_recipe,
                ];
                $recipe_calories += $recipe->calories;
            }

            $patient_id = fake()->randomElement($this->patients_ids);
            $day_menu = DayMenu::factory()->make();
            DayMenu::create([
                'name' => $day_menu->name,
                'type' => $day_menu->type,
                'recipes' => $recipes,
                'total_calories' => $recipe_calories,
                'user_id' => $patient_id,
                'sandi_recipe' => $day_menu->sandi_recipe,
            ]);
        }
    }

    public function addWeeklyMenus($count)
    {

        for ($i = 0; $i < $count; $i++) {
            $day_menus = [];
            $day_menu_calories = 0;
            for ($j = 0; $j < 7; $j++) {
                $recipes = [];
                $recipe_calories = 0;
                for ($k = 0; $k < 3; $k++) {
                    $recipe = Recipe::factory()->make();
                    $recipes[] = [
                        'label' => $recipe->label,
                        'dietLabels' => $recipe->dietLabels,
                        'healthLabels' => $recipe->healthLabels,
                        'ingredientLines' => $recipe->ingredientLines,
                        'calories' => $recipe->calories,
                        'mealType' => $recipe->mealType,
                        'dishType' => $recipe->dishType,
                        'instructions' => $recipe->instructions,
                        'sandi_recipe' => $recipe->sandi_recipe,
                    ];
                    $recipe_calories += $recipe->calories;
                }

                $day_menu = DayMenu::factory()->make();
                $day_menus[]= [
                    'name' => $day_menu->name,
                    'type' => $day_menu->type,
                    'recipes' => $recipes,
                    'total_calories' => $recipe_calories,
                    'sandi_recipe' => $day_menu->sandi_recipe,
                ];
                $day_menu_calories += $day_menu->total_calories;
            }
            $patient_id = fake()->randomElement($this->patients_ids);
            $weekly_menu = Menu::factory()->make();
            Menu::create([
                'name' => $weekly_menu->name,
                'type' => 'semanal',
                'timespan' => 7,
                'menus' => $day_menus,
                'total_calories' => $day_menu_calories,
                'user_id' => $patient_id,
                'sandi_recipe' => $weekly_menu->sandi_recipe,
            ]);
        }
    }

    public function addMonthlyMenus($count)
    {
        $timespan= fake()->randomElement([7,28,29,30,31]);

        for ($i = 0; $i < $count; $i++) {
            $day_menus = [];
            $day_menu_calories = 0;
            for ($j = 0; $j < $timespan; $j++) {
                $recipes = [];
                $recipe_calories = 0;
                for ($k = 0; $k < 3; $k++) {
                    $recipe = Recipe::factory()->make();
                    $recipes[] = [
                        'label' => $recipe->label,
                        'dietLabels' => $recipe->dietLabels,
                        'healthLabels' => $recipe->healthLabels,
                        'ingredientLines' => $recipe->ingredientLines,
                        'calories' => $recipe->calories,
                        'mealType' => $recipe->mealType,
                        'dishType' => $recipe->dishType,
                        'instructions' => $recipe->instructions,
                        'sandi_recipe' => $recipe->sandi_recipe,
                    ];
                    $recipe_calories += $recipe->calories;
                }

                $day_menu = DayMenu::factory()->make();
                $day_menus[]= [
                    'name' => $day_menu->name,
                    'type' => $day_menu->type,
                    'recipes' => $recipes,
                    'total_calories' => $recipe_calories,
                    'sandi_recipe' => $day_menu->sandi_recipe,
                ];
                $day_menu_calories += $day_menu->total_calories;
            }

            $patient_id = fake()->randomElement($this->patients_ids);
            $monthly_menu = Menu::factory()->make();
            Menu::create([
                'name' => $monthly_menu->name,
                'type' => 'mensual',
                'timespan' => $timespan,
                'menus' => $day_menus,
                'total_calories' => $day_menu_calories,
                'user_id' => $patient_id,
                'sandi_recipe' => $monthly_menu->sandi_recipe,
            ]);
        }
    }

    public function addVisits($count)
    {
        $height = fake()->randomFloat(2, 1, 2);
        $weight = fake()->randomFloat(2, 40, 120);
        for ($i = 0; $i < $count; $i++) {
            $data = [
                'height' => $height,
                'weight' => $weight,
                'bicipital_skinfold' => fake()->numberBetween(3, 15),
                'tricipital_skinfold' => fake()->numberBetween(6, 25),
                'subscapular_skinfold' => fake()->numberBetween(8, 20),
                'supraspinal_skinfold' => fake()->numberBetween(6, 20),
                'suprailiac_skinfold' => fake()->numberBetween(8, 20),
                'thigh_skinfold' => fake()->numberBetween(10, 30),
                'calf_skinfold' => fake()->numberBetween(8, 25),
                'abdomen_skinfold' => fake()->numberBetween(10, 30),
                'pb_relaj' => fake()->numberBetween(20, 40),
                'pb_contra' => fake()->numberBetween(0, 45),
                'forearm' => fake()->numberBetween(0, 35),
                'thigh' => fake()->numberBetween(0, 70),
                'calf' => fake()->numberBetween(0, 45),
                'waist' => fake()->numberBetween(0, 110),
                'thorax' => fake()->numberBetween(0, 120),
            ];
            $patient_user = User::where('id', $this->patient->id)->first();
            $nutritional_profile = NutritionalProfile::where('patient_id', $this->patient->id)->first();
            $nutritional_profile->update($data);
            $progress_path = app_path('Scripts') . '/progress.py';
            $params = [
                $progress_path,
                $data['bicipital_skinfold'],
                $data['tricipital_skinfold'],
                $data['subscapular_skinfold'],
                $data['supraspinal_skinfold'],
                $data['suprailiac_skinfold'],
                $data['thigh_skinfold'],
                $data['calf_skinfold'],
                $data['abdomen_skinfold'],
                $data['pb_relaj'],
                $data['pb_contra'],
                $data['forearm'],
                $data['thigh'],
                $data['calf'],
                $data['waist'],
                $data['thorax'],
                $data['weight'],
                $data['height'],
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
            } elseif ($response[0] == 'ok') {
                $visit = Visit::create([
                    'patient_id' => $this->patient->id,
                    'date' => now(),
                ]);

                if(NutritionalState::tryFrom($response[10])){
                    $nutritional_profile->update([
                        'nutritional_state' => $response[10],
                    ]);
                }

                $progress = Progress::create([
                    'patient_id'          => $this->patient->id,
                    'height'              => $data['height'],
                    'weight'              => $data['weight'],
                    'date'                => now(),
                    'imc'                 => floatval($response[1]),
                    'fat_percentage'      => floatval($response[3]),
                    'muscular_percentage' => floatval($response[6]),
                    'nutritional_state'   => $response[10],
                ]);
            }
        }
    }

    /*public function addPortions($count)
    {

    }

    public function addServicePortions($count)
    {

    }

    public function addNutritionalRequirements($count)
    {

    }

    public function addNutritionalPlans($count)
    {

    }*/

    public function factory($fakerObj, $max, $nameObj)
    {
        if ($max) {

            $this->info("Creando $nameObj: ");
            $start = microtime(true);

            $bar = $this->output->createProgressBar((int)$max);
            $bar->start();

            $count = 1000;
            $step = $count <= $max ? $count : $max;
            $condition = true;
            while ($condition) {

                if ($count < $max) {
                    $max -= $count;
                } else {
                    $count = $max;
                    $condition = false;
                }

                $faker = $fakerObj::factory();

                if ($nameObj == 'Consultas') {
                    $this->addVisits($count);
                    $bar->advance($step);

                    continue;
                }

                if ($nameObj == 'Recetas') {
                    $this->addRecipes($count);
                    $bar->advance($step);

                    continue;
                }

                if ($nameObj == 'Menus Diarios') {
                    $this->addDayMenus($count);
                    $bar->advance($step);

                    continue;
                }

                if ($nameObj == 'Menus Semanales') {
                    $this->addWeeklyMenus($count);
                    $bar->advance($step);

                    continue;
                }

                if ($nameObj == 'Menus Mensuales') {
                    $this->addMonthlyMenus($count);
                    $bar->advance($step);

                    continue;
                }

                /*if ($nameObj == 'Planes Nutricionales') {
                    $this->addNutritionalPlans($count);
                    $bar->advance($step);

                    continue;
                }*/

                $result = $faker->count($count)->create();

                $bar->advance($step);
            }

            $time_elapsed_secs = (microtime(true) - $start) * 1000;
            $bar->finish();

            if ($time_elapsed_secs >= 1000) {
                $this->info(' ......s ' . $time_elapsed_secs / 1000);
            } else {
                $this->info(' ......ms ' . $time_elapsed_secs);
            }

            $this->newLine();
        }
    }
}
