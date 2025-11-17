<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PizzaApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\IngredientApiController;
use App\Http\Controllers\Api\AllergenApiController;
use App\Http\Controllers\Api\AppetizerApiController;
use App\Http\Controllers\Api\BeverageApiController;
use App\Http\Controllers\Api\DessertApiController;

// 🌐 API PUBBLICHE v1 - Per frontend React (menu vetrina)
Route::prefix('v1')->name('api.v1.')->group(function () {
    
    // 📋 Menu completo (endpoint aggregato per performance)
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    
    // 🍕 Pizze
    Route::get('/pizzas', [PizzaApiController::class, 'index'])->name('pizzas.index');
    Route::get('/pizzas/{pizza:slug}', [PizzaApiController::class, 'show'])->name('pizzas.show');
    
    // 📂 Categorie
    Route::get('/categories', [CategoryApiController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category:slug}', [CategoryApiController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category:slug}/pizzas', [CategoryApiController::class, 'pizzas'])->name('categories.pizzas');
    
    // 🥗 Antipasti
    Route::get('/appetizers', [AppetizerApiController::class, 'index'])->name('appetizers.index');
    Route::get('/appetizers/{appetizer:slug}', [AppetizerApiController::class, 'show'])->name('appetizers.show');
    
    // 🥤 Bevande
    Route::get('/beverages', [BeverageApiController::class, 'index'])->name('beverages.index');
    Route::get('/beverages/{beverage:slug}', [BeverageApiController::class, 'show'])->name('beverages.show');
    
    // 🍰 Dolci
    Route::get('/desserts', [DessertApiController::class, 'index'])->name('desserts.index');
    Route::get('/desserts/{dessert:slug}', [DessertApiController::class, 'show'])->name('desserts.show');
    
    // 🧪 Ingredienti (per filtri frontend)
    Route::get('/ingredients', [IngredientApiController::class, 'index'])->name('ingredients.index');
    
    // ⚠️ Allergeni (per filtri frontend)
    Route::get('/allergens', [AllergenApiController::class, 'index'])->name('allergens.index');
});
