<?php

use \App\Http\Controllers\Api\ShoppingListController;
use App\Http\Controllers\Api\ChatMessageController;
use App\Http\Controllers\Api\CommuneController;
use App\Http\Controllers\Api\ContactCardController;
use App\Http\Controllers\Api\DayMenuController;
use App\Http\Controllers\Api\EnumController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\FoodIndicatorController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\NutritionalPlanController;
use App\Http\Controllers\Api\NutritionalProfileController;
use App\Http\Controllers\Api\NutritionalRequirementController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PortionController;
use App\Http\Controllers\Api\ProgressController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\ServicePortionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VisitController;
use App\Http\Controllers\Auth\LoginController;
use App\Mail\PatientAccount;
use App\Mail\SendPassword;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'apiLogin'])->name('login');
Route::post('register', [LoginController::class, 'register'])->name('register');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('check-session', [LoginController::class, 'checkSession'])->name('check-session');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Rutas Usuarios
    Route::get('usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('usuario/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('usuario/{user}', [UserController::class, 'update'])->name('users.update');
    Route::put('usuario/nutricionista/{user}', [UserController::class, 'updateNutritionist'])->name('users.updateNutritionist');
    Route::delete('usuario/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('usuario/{user}/perfil-nutricional', [UserController::class, 'nutritionalProfile'])->name('users.nutritionalProfile');
    Route::get('roles', [UserController::class, 'roleList'])->name('users.roles');

    // Rutas Recetas
    Route::get('recetas', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('receta/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
    Route::post('receta', [RecipeController::class, 'store'])->name('recipes.store');
    Route::put('receta/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('receta/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
    Route::post('receta/generar', [RecipeController::class, 'getRecipeFromApi'])->name('recipes.generate');

    // Rutas DayMenus
    Route::get('menus-diarios', [DayMenuController::class, 'index'])->name('dayMenus.index');
    Route::get('menu-diario/{dayMenu}', [DayMenuController::class, 'show'])->name('dayMenus.show');
    Route::post('menu-diario', [DayMenuController::class, 'store'])->name('dayMenus.store');
    Route::put('menu-diario/{dayMenu}', [DayMenuController::class, 'update'])->name('dayMenus.update');
    Route::delete('menu-diario/{dayMenu}', [DayMenuController::class, 'destroy'])->name('dayMenus.destroy');
    Route::post('menu-diario/generar', [DayMenuController::class, 'generateDayMenu'])->name('dayMenus.generate');

    // Rutas Menus
    Route::apiResource('menu', MenuController::class)->except('index')->names('menu');
    Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
    Route::post('menu/generar', [MenuController::class, 'generateMenu'])->name('menu.generate');

    //Listado con todos los menus (diarios, semanales, mensuales)
    Route::get('all-menus', [MenuController::class, 'menusList'])->name('menus.list');

    // Rutas Perfiles Nutricionales
    Route::get('perfiles-nutricionales', [NutritionalProfileController::class, 'index'])->name('nutritionalProfiles.index');
    Route::get('perfil-nutricional/{nutritionalProfile}', [NutritionalProfileController::class, 'show'])->name('nutritionalProfiles.show');
    Route::post('perfil-nutricional', [NutritionalProfileController::class, 'store'])->name('nutritionalProfiles.store');
    Route::put('perfil-nutricional/{nutritionalProfile}', [NutritionalProfileController::class, 'update'])->name('nutritionalProfiles.update');
    Route::delete('perfil-nutricional/{nutritionalProfile}', [NutritionalProfileController::class, 'destroy'])->name('nutritionalProfiles.destroy');

    // Rutas Pacientes
    Route::get('pacientes', [PatientController::class, 'index'])->name('patients.index')->withTrashed();
    Route::get('paciente/{patient}', [PatientController::class, 'show'])->name('patients.show');
    Route::post('paciente', [PatientController::class, 'store'])->name('patients.store');
    Route::post('basico-paciente',[PatientController::class, 'basicUserToPatient'])->name('patients.basic');
    Route::put('paciente/{patient}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('paciente/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::put('paciente/restore/{patient}', [PatientController::class, 'restore'])->name('patients.restore')->withTrashed();

    // Rutas Planes Nutricionales
    Route::get('planes-nutricionales', [NutritionalPlanController::class, 'index'])->name('nutritionalPlans.index');
    Route::get('plan-nutricional/{patient}', [NutritionalPlanController::class, 'show'])->name('nutritionalPlans.show');
    Route::post('plan-nutricional', [NutritionalPlanController::class, 'store'])->name('nutritionalPlans.store');
    Route::put('plan-nutricional/{nutritionalPlan}', [NutritionalPlanController::class, 'update'])->name('nutritionalPlans.update');
    Route::delete('plan-nutricional/{nutritionalPlan}', [NutritionalPlanController::class, 'destroy'])->name('nutritionalPlans.destroy');

    // Rutas Progreso
    Route::get('progresos', [ProgressController::class, 'index'])->name('progress.index');
    Route::get('progreso/{patient}', [ProgressController::class, 'show'])->name('progress.show');
    Route::post('progreso', [ProgressController::class, 'store'])->name('progress.store');
    Route::put('progreso/{progress}', [ProgressController::class, 'update'])->name('progress.update');
    Route::delete('progreso/{progress}', [ProgressController::class, 'destroy'])->name('progress.destroy');

    // Rutas Consultas
    Route::get('consultas', [VisitController::class, 'index'])->name('visits.index');
    Route::get('consulta/{visit}', [VisitController::class, 'show'])->name('visits.show');
    Route::post('consulta', [VisitController::class, 'store'])->name('visits.store');
    Route::put('consulta/{visit}', [VisitController::class, 'update'])->name('visits.update');
    Route::delete('consulta/{visit}', [VisitController::class, 'destroy'])->name('visits.destroy');

    // Rutas Requerimientos Nutricionales
    Route::get('requerimientos-nutricionales', [NutritionalRequirementController::class, 'index'])->name('nutritionalRequirements.index');
    Route::get('requerimiento-nutricional/{patient}', [NutritionalRequirementController::class, 'show'])->name('nutritionalRequirements.show');
    Route::post('requerimiento-nutricional', [NutritionalRequirementController::class, 'store'])->name('nutritionalRequirements.store');
    Route::put('requerimiento-nutricional/{nutritionalRequirement}', [NutritionalRequirementController::class, 'update'])->name('nutritionalRequirements.update');
    Route::delete('requerimiento-nutricional/{nutritionalRequirement}', [NutritionalRequirementController::class, 'destroy'])->name('nutritionalRequirements.destroy');

    // Rutas Indicadores de Alimentos
    Route::get('indicadores-alimentos', [FoodIndicatorController::class, 'index'])->name('foodIndicators.index');

    // Rutas Porciones
    Route::get('porciones', [PortionController::class, 'index'])->name('portions.index');
    Route::get('porcion/{patient}', [PortionController::class, 'show'])->name('portions.show');
    Route::post('porcion', [PortionController::class, 'store'])->name('portions.store');
    Route::put('porcion/{portion}', [PortionController::class, 'update'])->name('portions.update');
    Route::delete('porcion/{portion}', [PortionController::class, 'destroy'])->name('portions.destroy');

    // Rutas Porciones de Servicio
    Route::get('porciones-servicio', [ServicePortionController::class, 'index'])->name('servicePortions.index');
    Route::get('porcion-servicio/{patient}', [ServicePortionController::class, 'show'])->name('servicePortions.show');
    Route::post('porcion-servicio', [ServicePortionController::class, 'store'])->name('servicePortions.store');
    Route::put('porcion-servicio/{servicePortion}', [ServicePortionController::class, 'update'])->name('servicePortions.update');
    Route::delete('porcion-servicio/{servicePortion}', [ServicePortionController::class, 'destroy'])->name('servicePortions.destroy');

    // Rutas Tarjetas de contacto
    Route::get('tarjetas', [ContactCardController::class, 'index'])->name('contactCards.index');
    Route::get('tarjeta/{user}', [ContactCardController::class, 'show'])->name('contactCards.show');
    Route::post('tarjeta', [ContactCardController::class, 'store'])->name('contactCards.store');
    Route::put('tarjeta/{user}', [ContactCardController::class, 'update'])->name('contactCards.update');
    Route::delete('tarjeta/{contactCard}', [ContactCardController::class, 'destroy'])->name('contactCards.destroy');

    // Rutas Experiencias
    Route::get('experiencias', [ExperienceController::class, 'index'])->name('experiences.index');
    Route::get('experiencia/{experience}', [ExperienceController::class, 'show'])->name('experiences.show');
    Route::post('experiencia', [ExperienceController::class, 'store'])->name('experiences.store');
    Route::put('experiencia/{experience}', [ExperienceController::class, 'update'])->name('experiences.update');
    Route::delete('experiencia/{experience}', [ExperienceController::class, 'destroy'])->name('experiences.destroy');

    // Rutas Chat
    Route::get('/messages/{user}', [ChatMessageController::class, 'getMessage'])->name('chat.getMessage');
    Route::get('/all-messages', [ChatMessageController::class, 'allMessages'])->name('chat.allMessages');
    Route::post('/messages/{user}', [ChatMessageController::class, 'sendMessage'])->name('chat.sendMessage');
    Broadcast::routes(['middleware' => ['auth:sanctum']]);

    //Rutas de Regiones
    Route::apiResource('regions', RegionController::class)->only('index', 'show');

    //Rutas de Comunas
    Route::apiResource('communes', CommuneController::class)->only('index', 'show');


    // Rutas Lista de compras
    Route::get('/shopping-lists', [ShoppingListController::class, 'index'])->name('shoppinList.index');
    Route::get('/shopping-list/{menuId}', [ShoppingListController::class, 'show'])->name('shoppingList.show');
    Route::get('/progress-bar/{menuId}', [ShoppingListController::class, 'getProgress'])->name('shoppingList.progress');

    //Test mail
    /* Route::get('/testmail', function () {
        $email = 'benjita.siete@gmail.com';
        $patient_user = User::find(5);
        $nutritionist = User::find(3);
        Mail::to($email)->send(new PatientAccount($patient_user, $nutritionist));
    });
    Route::get('/testmail2', function () {
        $password = Str::random(12);
        $email = 'benjita.siete@gmail.com';
        Mail::to($email)->send(new SendPassword($password));
    }); */

    //Health Enums
    Route::prefix('enum')->group(function () {
        Route::get('/health-types', [EnumController::class, 'healthTypes']);
        Route::get('/experience-types', [EnumController::class, 'experienceTypes']);
    });
});
