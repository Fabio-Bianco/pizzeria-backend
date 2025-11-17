<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryApiController extends Controller
{
    /**
     * 📂 Lista tutte le categorie
     */
    public function index(): JsonResponse
    {
        $categories = Category::withCount('pizzas')
            ->orderBy('name')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'is_white' => (bool) $category->is_white,
                    'pizzas_count' => $category->pizzas_count,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * 👁️ Mostra singola categoria
     */
    public function show(Category $category): JsonResponse
    {
        $category->loadCount('pizzas');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
                'is_white' => (bool) $category->is_white,
                'pizzas_count' => $category->pizzas_count,
            ]
        ]);
    }

    /**
     * 🍕 Pizze di una categoria specifica
     */
    public function pizzas(Category $category): JsonResponse
    {
        $pizzas = $category->pizzas()
            ->with(['ingredients.allergens'])
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
                    'ingredients' => $pizza->ingredients->map(fn($ing) => [
                        'id' => $ing->id,
                        'name' => $ing->name,
                    ]),
                    'allergens' => $pizza->getAllAllergens()->map(fn($all) => [
                        'id' => $all->id,
                        'name' => $all->name,
                    ])->values(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $pizzas,
            'meta' => [
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                ],
                'total' => $pizzas->count(),
            ]
        ]);
    }
}
