<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pizza;
use Illuminate\Http\JsonResponse;

class PizzaApiController extends Controller
{
    /**
     * 🍕 Lista tutte le pizze
     */
    public function index(): JsonResponse
    {
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

        return response()->json([
            'success' => true,
            'data' => $pizzas,
            'meta' => [
                'total' => $pizzas->count(),
            ]
        ]);
    }

    /**
     * 👁️ Mostra singola pizza per slug
     */
    public function show(Pizza $pizza): JsonResponse
    {
        $pizza->load(['category', 'ingredients.allergens']);

        return response()->json([
            'success' => true,
            'data' => [
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
                    'is_tomato' => (bool) $ing->is_tomato,
                ]),
                'allergens' => $pizza->getAllAllergens()->map(fn($all) => [
                    'id' => $all->id,
                    'name' => $all->name,
                    'slug' => $all->slug,
                ])->values(),
            ]
        ]);
    }
}
