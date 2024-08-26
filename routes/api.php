<?php

use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

    //Rutas Usuarios
    Route::apiResource('usuarios', UserController::class);

    //Rutas Menus
    Route::apiResource('menus', MenuController::class);

    //Rutas Recetas
    Route::apiResource('receta', RecipeController::class)->except('index');
    Route::get('recetas', [RecipeController::class, 'index']);
    Route::post('receta/eda', [RecipeController::class, 'getRecipeFromApi']);
});
