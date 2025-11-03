<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\AllergenController;
use App\Http\Controllers\AppetizerController;
use App\Http\Controllers\BeverageController;
use App\Http\Controllers\DessertController;

// API unificate - stessi controller, risposte automaticamente JSON
Route::prefix('v1')->name('api.')->group(function () {
    Route::apiResource('categories', CategoryController::class)->only(['index','show']);
    Route::apiResource('pizzas', PizzaController::class)->only(['index','show']);
    Route::apiResource('ingredients', IngredientController::class)->only(['index','show']);
    Route::apiResource('allergens', AllergenController::class)->only(['index','show']);
    Route::apiResource('appetizers', AppetizerController::class)->only(['index','show']);
    Route::apiResource('beverages', BeverageController::class)->only(['index','show']);
    Route::apiResource('desserts', DessertController::class)->only(['index','show']);
});
