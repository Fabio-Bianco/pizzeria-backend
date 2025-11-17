<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pizza;
use App\Models\Category;
use App\Models\Appetizer;
use App\Models\Beverage;
use App\Models\Dessert;
use App\Models\Allergen;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    /**
     * 📋 Endpoint aggregato: Restituisce tutto il menu in una chiamata
     * Ottimizzato per ridurre le chiamate HTTP dal frontend
     */
    public function index(): JsonResponse
    {
        // Carica tutto con eager loading per performance
        $categories = Category::with(['pizzas' => function ($query) {
            $query->with(['ingredients.allergens'])
                  ->orderBy('name');
        }])->orderBy('name')->get();

        $pizzas = Pizza::with(['category', 'ingredients.allergens'])
            ->orderBy('name')
            ->get()
            ->map(function ($pizza) {
                return [
                    'id' => $pizza->id,
                    'name' => $pizza->name,
                    'slug' => $pizza->slug,
                    'price' => (float) $pizza->price,
                    'description' => $pizza->description,
                    'notes' => $pizza->notes,
                    'is_vegan' => (bool) $pizza->is_vegan,
                    'image_url' => $pizza->image_path ? asset('storage/' . $pizza->image_path) : null,
                    'category' => $pizza->category ? [
                        'id' => $pizza->category->id,
                        'name' => $pizza->category->name,
                        'slug' => $pizza->category->slug,
                        'is_white' => (bool) $pizza->category->is_white,
                    ] : null,
                    'ingredients' => $pizza->ingredients->map(fn($ing) => [
                        'id' => $ing->id,
                        'name' => $ing->name,
                        'slug' => $ing->slug,
                    ]),
                    'allergens' => $pizza->getAllAllergens()->map(fn($all) => [
                        'id' => $all->id,
                        'name' => $all->name,
                        'slug' => $all->slug,
                    ])->values(),
                ];
            });

        $appetizers = Appetizer::with(['ingredients.allergens'])
            ->orderBy('name')
            ->get()
            ->map(function ($appetizer) {
                return [
                    'id' => $appetizer->id,
                    'name' => $appetizer->name,
                    'slug' => $appetizer->slug,
                    'price' => (float) $appetizer->price,
                    'description' => $appetizer->description,
                    'ingredients' => $appetizer->ingredients->map(fn($ing) => [
                        'id' => $ing->id,
                        'name' => $ing->name,
                    ]),
                    'allergens' => $appetizer->getAllAllergens()->map(fn($all) => [
                        'id' => $all->id,
                        'name' => $all->name,
                    ])->values(),
                ];
            });

        $beverages = Beverage::orderBy('name')->get()->map(function ($beverage) {
            return [
                'id' => $beverage->id,
                'name' => $beverage->name,
                'slug' => $beverage->slug,
                'price' => (float) $beverage->price,
                'description' => $beverage->description,
            ];
        });

        $desserts = Dessert::with(['ingredients.allergens'])
            ->orderBy('name')
            ->get()
            ->map(function ($dessert) {
                return [
                    'id' => $dessert->id,
                    'name' => $dessert->name,
                    'slug' => $dessert->slug,
                    'price' => (float) $dessert->price,
                    'description' => $dessert->description,
                    'ingredients' => $dessert->ingredients->map(fn($ing) => [
                        'id' => $ing->id,
                        'name' => $ing->name,
                    ]),
                    'allergens' => $dessert->getAllAllergens()->map(fn($all) => [
                        'id' => $all->id,
                        'name' => $all->name,
                    ])->values(),
                ];
            });

        $allergens = Allergen::orderBy('name')->get()->map(function ($allergen) {
            return [
                'id' => $allergen->id,
                'name' => $allergen->name,
                'slug' => $allergen->slug,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'categories' => $categories,
                'pizzas' => $pizzas,
                'appetizers' => $appetizers,
                'beverages' => $beverages,
                'desserts' => $desserts,
                'allergens' => $allergens,
            ],
            'meta' => [
                'total_pizzas' => $pizzas->count(),
                'total_appetizers' => $appetizers->count(),
                'total_beverages' => $beverages->count(),
                'total_desserts' => $desserts->count(),
                'timestamp' => now()->toIso8601String(),
            ]
        ]);
    }
}
