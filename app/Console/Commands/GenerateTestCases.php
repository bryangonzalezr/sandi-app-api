<?php

namespace App\Console\Commands;

use App\Enums\GetMethod;
use App\Enums\NutritionalState;
use App\Enums\RestFactor;
use App\Http\Controllers\Api\VisitController;
use App\Models\ChatMessage;
use App\Models\DayMenu;
use App\Models\Menu;
use App\Models\NutritionalPlan;
use App\Models\NutritionalProfile;
use App\Models\NutritionalRequirement;
use App\Models\Patient;
use App\Models\Portion;
use App\Models\Progress;
use App\Models\Recipe;
use App\Models\ServicePortion;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GenerateTestCases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:cases {recipes=10} {day_menus=8} {weekly_menus=8} {monthly_menus=5} {visits=3} {nutritional_plans=2} {chats=1}';

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
        $nutritional_plans = $this->argument('nutritional_plans');
        $chats = $this->argument('chats');
        if ($visits){
            $patient_id = fake()->randomElement($this->patients_ids);
            $this->patient = User::with('nutritionalPlan')->find($patient_id);
            $this->factory(new Visit, $visits, 'Consultas');
        }
        $this->factory(new Recipe, $recipes, 'Recetas');
        $this->factory(new DayMenu, $day_menus, 'Menus Diarios');
        $this->factory(new Menu, $weekly_menus, 'Menus Semanales');
        $this->factory(new Menu, $monthly_menus, 'Menus Mensuales');
        if ($nutritional_plans){
            $this->factory(new NutritionalPlan, $nutritional_plans, 'Planes Nutricionales');
            unset($this->patient);
        }
        $this->factory(new ChatMessage, $chats, 'Chats');

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
                $this->error('error: '.$response[1]);
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

    public function addNutritionalRequirements(): void
    {
        $patient = $this->patient;
        $nutritionalProfile = $patient->nutritionalProfile;
        $method = fake()->randomElement(GetMethod::values());
        $morbid_antecedents = [
            $nutritionalProfile->morbid_antecedents["dm2"] ,
            $nutritionalProfile->morbid_antecedents["hta"],
            $nutritionalProfile->morbid_antecedents["tiroides"],
            $nutritionalProfile->morbid_antecedents["dislipidemia"],

        ];

        foreach($morbid_antecedents as $i => $antecedent){
            if(!$antecedent){
                $morbid_antecedents[$i] = 'No';
            }else{
                $morbid_antecedents[$i] = 'Si';
            }
        }

        $morbid_antecedents[] = $nutritionalProfile->morbid_antecedents["otros"] == null ? 'No' : $nutritionalProfile->morbid_antecedents["otros"];
        $rest_factor = $method == GetMethod::HarrisBenedict ? fake()->randomElement(RestFactor::values()) : RestFactor::No->value;
        $requirements_path = app_path('Scripts') . '/requirements.py';
        $params = [
            $requirements_path,   // Ruta del script
            $method,
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
               $this->error('error: '. $response[1]);
               return;
        } elseif ($response[0] == 'ok'){
            if($response[1] == '0'){
                $this->error('error: '. $response[1]);
            }
            $this->nutritional_requirements = NutritionalRequirement::updateOrCreate([
                'patient_id'    => $this->patient->id,
            ],
                [
                    'method'        => $method,
                    'rest_type'     => $rest_factor,
                    'get'           => floatval($response[1]),
                    'proteina'      => floatval($response[2]),
                    'lipidos'       => floatval($response[3]),
                    'carbohidratos' => floatval($response[4]),
                    'agua'          => floatval($response[5]),
                ]);

        }
    }

    public function addPortions(): void
    {
        $this->portions = Portion::create([
            'cereales' => fake()->numberBetween(0, 5),
            'verduras_gral'=> fake()->numberBetween(0, 5),
            'verduras_libre_cons'=> fake()->numberBetween(0, 5),
            'frutas'=> fake()->numberBetween(0, 5),
            'carnes_ag'=> fake()->numberBetween(0, 5),
            'carnes_bg'=> fake()->numberBetween(0, 5),
            'legumbres'=> fake()->numberBetween(0, 5),
            'lacteos_ag'=> fake()->numberBetween(0, 5),
            'lacteos_bg'=> fake()->numberBetween(0, 5),
            'lacteos_mg'=> fake()->numberBetween(0, 5),
            'aceites_grasas'=> fake()->numberBetween(0, 5),
            'alim_ricos_lipidos'=> fake()->numberBetween(0, 5),
            'azucares'=> fake()->numberBetween(0, 5),
            'total_calorias'=> fake()->numberBetween(0, 5),
            'patient_id'=> $this->patient->id,
        ]);
    }

    public function addServicePortions(): void
    {
        // Ahora distribuimos las porciones en las comidas de forma aleatoria
        $comidas = ['desayuno', 'colacion', 'almuerzo', 'once', 'cena'];

        // Distribuir las porciones
        $distribuirPorciones = function($porciones) use ($comidas) {
            $resultado = [];

            foreach ($porciones as $tipo => $cantidad) {
                $reparto = array_fill_keys($comidas, 0);

                for ($i = 0; $i < $cantidad; $i++) {
                    $comida = $comidas[array_rand($comidas)];
                    $reparto[$comida]++;
                }

                $resultado[$tipo] = $reparto;
            }
            return $resultado;
        };


        // Llamamos a la función para distribuir las porciones
        $service_portions = $distribuirPorciones([
            'cereales' => $this->portions->cereales,
            'verduras_gral' => $this->portions->verduras_gral,
            'verduras_libre_cons' => $this->portions->verduras_libre_cons,
            'frutas' => $this->portions->frutas,
            'carnes_ag' => $this->portions->carnes_ag,
            'carnes_bg' => $this->portions->carnes_bg,
            'legumbres' => $this->portions->legumbres,
            'lacteos_ag' => $this->portions->lacteos_ag,
            'lacteos_bg' => $this->portions->lacteos_bg,
            'lacteos_mg' => $this->portions->lacteos_mg,
            'aceites_grasas' => $this->portions->aceites_grasas,
            'alim_ricos_lipidos' => $this->portions->alim_ricos_lipidos,
            'azucares' => $this->portions->azucares,
        ]);

        $this->service_portions = ServicePortion::create([
            'desayuno' => [
                'cereales' => $service_portions['cereales']['desayuno'],
                'verduras_gral' => $service_portions['verduras_gral']['desayuno'],
                'verduras_libre_cons' => $service_portions['verduras_libre_cons']['desayuno'],
                'frutas' => $service_portions['frutas']['desayuno'],
                'carnes_ag' => $service_portions['carnes_ag']['desayuno'],
                'carnes_bg' => $service_portions['carnes_bg']['desayuno'],
                'legumbres' => $service_portions['legumbres']['desayuno'],
                'lacteos_ag' => $service_portions['lacteos_ag']['desayuno'],
                'lacteos_bg' => $service_portions['lacteos_bg']['desayuno'],
                'lacteos_mg' => $service_portions['lacteos_mg']['desayuno'],
                'aceites_grasas' => $service_portions['aceites_grasas']['desayuno'],
                'alim_ricos_lipidos' => $service_portions['alim_ricos_lipidos']['desayuno'],
                'azucares' =>  $service_portions['azucares']['desayuno'],
            ],
            'colacion' => [
                'cereales' => $service_portions['cereales']['colacion'],
                'verduras_gral' => $service_portions['verduras_gral']['colacion'],
                'verduras_libre_cons' => $service_portions['verduras_libre_cons']['colacion'],
                'frutas' => $service_portions['frutas']['colacion'],
                'carnes_ag' => $service_portions['carnes_ag']['colacion'],
                'carnes_bg' => $service_portions['carnes_bg']['colacion'],
                'legumbres' => $service_portions['legumbres']['colacion'],
                'lacteos_ag' => $service_portions['lacteos_ag']['colacion'],
                'lacteos_bg' => $service_portions['lacteos_bg']['colacion'],
                'lacteos_mg' => $service_portions['lacteos_mg']['colacion'],
                'aceites_grasas' => $service_portions['aceites_grasas']['colacion'],
                'alim_ricos_lipidos' => $service_portions['alim_ricos_lipidos']['colacion'],
                'azucares' =>  $service_portions['azucares']['colacion'],
            ],
            'almuerzo' => [
                'cereales' => $service_portions['cereales']['almuerzo'],
                'verduras_gral' => $service_portions['verduras_gral']['almuerzo'],
                'verduras_libre_cons' => $service_portions['verduras_libre_cons']['almuerzo'],
                'frutas' => $service_portions['frutas']['almuerzo'],
                'carnes_ag' => $service_portions['carnes_ag']['almuerzo'],
                'carnes_bg' => $service_portions['carnes_bg']['almuerzo'],
                'legumbres' => $service_portions['legumbres']['almuerzo'],
                'lacteos_ag' => $service_portions['lacteos_ag']['almuerzo'],
                'lacteos_bg' => $service_portions['lacteos_bg']['almuerzo'],
                'lacteos_mg' => $service_portions['lacteos_mg']['almuerzo'],
                'aceites_grasas' => $service_portions['aceites_grasas']['almuerzo'],
                'alim_ricos_lipidos' => $service_portions['alim_ricos_lipidos']['almuerzo'],
                'azucares' =>  $service_portions['azucares']['almuerzo'],
            ],
            'once' => [
                'cereales' => $service_portions['cereales']['once'],
                'verduras_gral' => $service_portions['verduras_gral']['once'],
                'verduras_libre_cons' => $service_portions['verduras_libre_cons']['once'],
                'frutas' => $service_portions['frutas']['once'],
                'carnes_ag' => $service_portions['carnes_ag']['once'],
                'carnes_bg' => $service_portions['carnes_bg']['once'],
                'legumbres' => $service_portions['legumbres']['once'],
                'lacteos_ag' => $service_portions['lacteos_ag']['once'],
                'lacteos_bg' => $service_portions['lacteos_bg']['once'],
                'lacteos_mg' => $service_portions['lacteos_mg']['once'],
                'aceites_grasas' => $service_portions['aceites_grasas']['once'],
                'alim_ricos_lipidos' => $service_portions['alim_ricos_lipidos']['once'],
                'azucares' =>  $service_portions['azucares']['once'],
            ],
            'cena' => [
                'cereales' => $service_portions['cereales']['cena'],
                'verduras_gral' => $service_portions['verduras_gral']['cena'],
                'verduras_libre_cons' => $service_portions['verduras_libre_cons']['cena'],
                'frutas' => $service_portions['frutas']['cena'],
                'carnes_ag' => $service_portions['carnes_ag']['cena'],
                'carnes_bg' => $service_portions['carnes_bg']['cena'],
                'legumbres' => $service_portions['legumbres']['cena'],
                'lacteos_ag' => $service_portions['lacteos_ag']['cena'],
                'lacteos_bg' => $service_portions['lacteos_bg']['cena'],
                'lacteos_mg' => $service_portions['lacteos_mg']['cena'],
                'aceites_grasas' => $service_portions['aceites_grasas']['cena'],
                'alim_ricos_lipidos' => $service_portions['alim_ricos_lipidos']['cena'],
                'azucares' =>  $service_portions['azucares']['cena'],
            ],
            'total_calorias' => $this->portions->total_calorias,
            'patient_id' => $this->patient->id,
        ]);
    }

    public function addNutritionalPlans($count)
    {
        for($i=0; $i < $count; $i++) {
            $this->addNutritionalRequirements();
            $this->addPortions();
            $this->addServicePortions();

            $nutritional_plan = NutritionalPlan::firstOrCreate([
                'patient_id' => $this->patient->id,
                ],[
                'desayuno'  => fake()->paragraph(),
                'colacion' => fake()->paragraph(),
                'almuerzo' => fake()->paragraph(),
                'once' => fake()->paragraph(),
                'cena' => fake()->paragraph(),
                'general_recommendations' => fake()->paragraph(),
                'forbidden_foods' => fake()->paragraph(),
                'free_foods' => fake()->paragraph(),
            ]);
        }

    }

    public function addChats($count){
        for($i=0; $i < $count; $i++){
            $patient_id = fake()->randomElement($this->patients_ids);
            $nutritionist_messages = [
                'Hola, ¿como va la semana?',
                'No olvides nuestra próxima cita el'. now()->addMonth() . 'a las 10:15',
                'Has hecho un gran progreso, sigue así',
                'Es importante hidratarse bien; intenta beber al menos 2 litros de agua al día',
                '¡Gran trabajo esta semana! Cada pequeño paso cuenta.'
            ];

            $patient_messages = [
                '¿Podrías aclararme algunas dudas sobre el plan de comidas que me diste?',
                'He estado siguiendo el plan y me siento más enérgico/a.',
                '¿Podrías recomendarme algunas recetas fáciles y saludables para la cena?',
                'Estoy considerando tomar un suplemento de proteínas. ¿Es recomendable en mi caso?',
                'Me gustaría programar otra cita para revisar mi progreso.'
            ];

            ChatMessage::create([
                'sender_id' => $this->nutritionist_id,
                'receiver_id' => $patient_id,
                'text'  => fake()->randomElement($nutritionist_messages)
            ]);

            ChatMessage::create([
                'sender_id' => $patient_id,
                'receiver_id' => $this->nutritionist_id,
                'text'  => fake()->randomElement($patient_messages)
            ]);
        }

    }

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

                if ($nameObj == 'Planes Nutricionales') {
                    $this->addNutritionalPlans($count);
                    $bar->advance($step);

                    continue;
                }

                if ($nameObj == 'Chats') {
                    $this->addChats($count);
                    $bar->advance($step);

                    continue;
                }

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
