<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dessert;
use Illuminate\Http\JsonResponse;

class DessertApiController extends Controller
{
    /**
     * 🍰 Lista tutti i dolci
     */
    public function index(): JsonResponse
    {
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
                        'slug' => $ing->slug,
                    ]),
                    'allergens' => $dessert->getAllAllergens()->map(fn($all) => [
                        'id' => $all->id,
                        'name' => $all->name,
                        'slug' => $all->slug,
                    ])->values(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $desserts,
            'meta' => [
                'total' => $desserts->count(),
            ]
        ]);
    }

    /**
     * 👁️ Mostra singolo dolce
     */
    public function show(Dessert $dessert): JsonResponse
    {
        $dessert->load(['ingredients.allergens']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $dessert->id,
                'name' => $dessert->name,
                'slug' => $dessert->slug,
                'price' => (float) $dessert->price,
                'description' => $dessert->description,
                'ingredients' => $dessert->ingredients->map(fn($ing) => [
                    'id' => $ing->id,
                    'name' => $ing->name,
                    'slug' => $ing->slug,
                ]),
                'allergens' => $dessert->getAllAllergens()->map(fn($all) => [
                    'id' => $all->id,
                    'name' => $all->name,
                    'slug' => $all->slug,
                ])->values(),
            ]
        ]);
    }
}
