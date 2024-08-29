<?php

use App\Http\Controllers\Api\DayMenuController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\NutritionalPlanController;
use App\Http\Controllers\Api\NutritionalProfileController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\ProgressController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VisitController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;


Route::post('login', [LoginController::class, 'apiLogin']);

Route::middleware(['auth:sanctum'])->group(function () {

    //Rutas Usuarios
    Route::apiResource('usuario', UserController::class)->except('store');
    Route::get('roles', [UserController::class, 'roleList']);

    //Rutas Recetas
    Route::apiResource('receta', RecipeController::class)->except('index');
    Route::get('recetas', [RecipeController::class, 'index']);
    Route::post('receta/generar', [RecipeController::class, 'getRecipeFromApi']);

    //Rutas DayMenus
    Route::apiResource('menu-diario', DayMenuController::class);
    Route::post('menu-diario/generar', [DayMenuController::class, 'generateDayMenu']);

    //Rutas Menus
    Route::apiResource('menu', MenuController::class);
    Route::post('menu/generar', [MenuController::class, 'generateMenu']);

    //Rutas Perfiles Nutricionales
    Route::apiResource('perfil-nutricional', NutritionalProfileController::class);

    //Rutas Pacientes
    Route::apiResource('paciente',PatientController::class);

    //Rutas Planes Nutricionales
    Route::apiResource('plan-nutricional', NutritionalPlanController::class);

    //Rutas Progreso
    Route::apiResource('progreso', ProgressController::class);

    //Rutas de Consultas
    Route::apiResource('consulta', VisitController::class);

});
