<?php

namespace App\Http\Controllers;

use App\Models\Appetizer;
use App\Models\Pizza;
use App\Models\Beverage;
use App\Models\Dessert;
use App\Models\Allergen;
use App\Models\Ingredient;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // 📊 Mostra la dashboard con statistiche
    public function index()
    {
        // 📈 Conta tutti i record
        $counts = [
            'countCategories' => Category::count(),
            'countPizzas' => Pizza::count(),
            'countIngredients' => Ingredient::count(),
            'countAllergens' => Allergen::count(),
            'countAppetizers' => Appetizer::count(),
            'countBeverages' => Beverage::count(),
            'countDesserts' => Dessert::count(),
        ];

        // 📅 Ultimi record creati
        $latest = [
            'latestPizza' => Pizza::latest()->first(),
            'latestAppetizer' => Appetizer::latest()->first(),
            'latestBeverage' => Beverage::latest()->first(),
            'latestDessert' => Dessert::latest()->first(),
        ];

        return view('dashboard', array_merge($counts, $latest));
    }
}