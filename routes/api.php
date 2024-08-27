<?php

use App\Http\Controllers\Api\DayMenuController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

    //Rutas Usuarios
    Route::apiResource('usuario', UserController::class)->except('store');
    Route::get('roles', [UserController::class, 'roleList']);

    //Rutas Recetas
    Route::apiResource('receta', RecipeController::class)->except('index');
    Route::get('recetas', [RecipeController::class, 'index']);
    Route::post('receta/eda', [RecipeController::class, 'getRecipeFromApi']);

    //Rutas DayMenus
    Route::apiResource('menu-diario', DayMenuController::class);
    Route::post('menu-diario/generar', [DayMenuController::class, 'generateDayMenu']);

    //Rutas Menus
    Route::apiResource('menu', MenuController::class);
    Route::post('menu/generar', [MenuController::class, 'generateMenu']);



});
