<?php


use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('register',[LoginController::class,'register']);
Route::post('login',[LoginController::class,'login']);
Route::post('logout',[LoginController::class,'logout']);
