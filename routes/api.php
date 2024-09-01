<?php

use App\Http\Controllers\Api\ContactCardController;
use App\Http\Controllers\Api\DayMenuController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\NutritionalPlanController;
use App\Http\Controllers\Api\NutritionalProfileController;
use App\Http\Controllers\Api\NutritionalRequirementController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PortionController;
use App\Http\Controllers\Api\ProgressController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VisitController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;


Route::post('login', [LoginController::class, 'apiLogin']);

Route::middleware(['auth:sanctum'])->group(function () {

    //Rutas Usuarios
    Route::get('usuarios', [UserController::class, 'index']);
    Route::get('usuario/{user}', [UserController::class, 'show']);
    Route::put('usuario/{user}', [UserController::class, 'update']);
    Route::delete('usuario/{user}', [UserController::class, 'destroy']);
    Route::get('usuario/{user}/perfil-nutricional', [UserController::class, 'nutritionalProfile']);
    Route::get('roles', [UserController::class, 'roleList']);

    //Rutas Recetas
    Route::get('recetas', [RecipeController::class, 'index']);
    Route::get('receta/{recipe}', [RecipeController::class, 'show']);
    Route::post('receta', [RecipeController::class, 'store']);
    Route::put('receta/{recipe}', [RecipeController::class, 'update']);
    Route::delete('receta/{recipe}', [RecipeController::class, 'destroy']);
    Route::post('receta/generar', [RecipeController::class, 'getRecipeFromApi']);

    //Rutas DayMenus
    Route::get('menus-diarios', [DayMenuController::class, 'index']);
    Route::get('menu-diario/{dayMenu}', [DayMenuController::class, 'show']);
    Route::post('menu-diario', [DayMenuController::class, 'store']);
    Route::put('menu-diario/{dayMenu}', [DayMenuController::class, 'update']);
    Route::delete('menu-diario/{dayMenu}', [DayMenuController::class, 'destroy']);
    Route::post('menu-diario/generar', [DayMenuController::class, 'generateDayMenu']);

    //Rutas Menus
    Route::apiResource('menu', MenuController::class)->except('index');
    Route::get('menus', [MenuController::class, 'index']);
    Route::post('menu/generar', [MenuController::class, 'generateMenu']);

    //Rutas Perfiles Nutricionales
    Route::get('perfiles-nutricionales', [NutritionalProfileController::class, 'index']);
    Route::get('perfil-nutricional/{nutritionalProfile}', [NutritionalProfileController::class, 'show']);
    Route::post('perfil-nutricional', [NutritionalProfileController::class, 'store']);
    Route::put('perfil-nutricional/{nutritionalProfile}', [NutritionalProfileController::class, 'update']);
    Route::delete('perfil-nutricional/{nutritionalProfile}', [NutritionalProfileController::class, 'destroy']);

    //Rutas Pacientes
    Route::get('pacientes', [PatientController::class, 'index']);
    Route::get('paciente/{patient}', [PatientController::class, 'show']);
    Route::post('paciente', [PatientController::class, 'store']);
    Route::put('paciente/{patient}', [PatientController::class, 'update']);
    Route::delete('paciente/{patient}', [PatientController::class, 'destroy']);

    //Rutas Planes Nutricionales
    Route::get('planes-nutricionales', [NutritionalPlanController::class, 'index']);
    Route::get('plan-nutricional/{nutritionalPlan}', [NutritionalPlanController::class, 'show']);
    Route::post('plan-nutricional', [NutritionalPlanController::class, 'store']);
    Route::put('plan-nutricional/{nutritionalPlan}', [NutritionalPlanController::class, 'update']);
    Route::delete('plan-nutricional/{nutritionalPlan}', [NutritionalPlanController::class, 'destroy']);

    //Rutas Progreso
    Route::get('progresos', [ProgressController::class, 'index']);
    Route::get('progreso/{progress}', [ProgressController::class, 'show']);
    Route::post('progreso', [ProgressController::class, 'store']);
    Route::put('progreso/{progress}', [ProgressController::class, 'update']);
    Route::delete('progreso/{progress}', [ProgressController::class, 'destroy']);

    //Rutas de Consultas
    Route::get('consultas', [VisitController::class, 'index']);
    Route::get('consulta/{visit}', [VisitController::class, 'show']);
    Route::post('consulta', [VisitController::class, 'store']);
    Route::put('consulta/{visit}', [VisitController::class, 'update']);
    Route::delete('consulta/{visit}', [VisitController::class, 'destroy']);

    //Rutas de Requerimientos Nutricionales
    Route::get('requerimientos-nutricionales', [NutritionalRequirementController::class, 'index']);
    Route::get('requerimiento-nutricional/{nutritionalRequirement}', [NutritionalRequirementController::class, 'show']);
    Route::post('requerimiento-nutricional', [NutritionalRequirementController::class, 'store']);
    Route::put('requerimiento-nutricional/{nutritionalRequirement}', [NutritionalRequirementController::class, 'update']);
    Route::delete('requerimiento-nutricional/{nutritionalRequirement}', [NutritionalRequirementController::class, 'destroy']);

    //Ruta de Indicadores de Alimentos
    Route::get('indicadores-alimentos', [NutritionalRequirementController::class, 'index']);

    //Rutas de Porciones
    Route::get('porciones', [PortionController::class, 'index']);
    Route::get('porcion/{portion}', [PortionController::class, 'show']);
    Route::post('porcion', [PortionController::class, 'store']);
    Route::put('porcion/{portion}', [PortionController::class, 'update']);
    Route::delete('porcion/{portion}', [PortionController::class, 'destroy']);

    //Rutas Tarjetas de contacto
    Route::get('tarjetas', [ContactCardController::class, 'index']);
    Route::get('tarjeta/{contactCard}', [ContactCardController::class, 'show']);
    Route::post('tarjeta', [ContactCardController::class, 'store']);
    Route::put('tarjeta/{contactCard}', [ContactCardController::class, 'update']);
    Route::delete('tarjeta/{contactCard}', [ContactCardController::class, 'destroy']);

});
