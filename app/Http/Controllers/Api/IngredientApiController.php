<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\JsonResponse;

class IngredientApiController extends Controller
{
    /**
     * 🧪 Lista tutti gli ingredienti (per filtri frontend)
     */
    public function index(): JsonResponse
    {
        $ingredients = Ingredient::with('allergens')
            ->orderBy('name')
            ->get()
            ->map(function ($ingredient) {
                return [
                    'id' => $ingredient->id,
                    'name' => $ingredient->name,
                    'slug' => $ingredient->slug,
                    'is_tomato' => (bool) $ingredient->is_tomato,
                    'allergens' => $ingredient->allergens->map(fn($all) => [
                        'id' => $all->id,
                        'name' => $all->name,
                        'slug' => $all->slug,
                    ]),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $ingredients,
            'meta' => [
                'total' => $ingredients->count(),
            ]
        ]);
    }
}
