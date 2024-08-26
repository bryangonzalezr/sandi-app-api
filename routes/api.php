<?php

use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('usuarios', UserController::class);
    Route::apiResource('menus', MenuController::class);
    Route::apiResource('receta', RecipeController::class)->except('index');
    Route::get('recetas', [RecipeController::class, 'index']);
    Route::get('receta/api/', [RecipeController::class, 'getRecipeFromApi']);
});
