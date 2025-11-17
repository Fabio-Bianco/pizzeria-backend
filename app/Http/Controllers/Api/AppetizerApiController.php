<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appetizer;
use Illuminate\Http\JsonResponse;

class AppetizerApiController extends Controller
{
    /**
     * 🥗 Lista tutti gli antipasti
     */
    public function index(): JsonResponse
    {
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
                        'slug' => $ing->slug,
                    ]),
                    'allergens' => $appetizer->getAllAllergens()->map(fn($all) => [
                        'id' => $all->id,
                        'name' => $all->name,
                        'slug' => $all->slug,
                    ])->values(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $appetizers,
            'meta' => [
                'total' => $appetizers->count(),
            ]
        ]);
    }

    /**
     * 👁️ Mostra singolo antipasto
     */
    public function show(Appetizer $appetizer): JsonResponse
    {
        $appetizer->load(['ingredients.allergens']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $appetizer->id,
                'name' => $appetizer->name,
                'slug' => $appetizer->slug,
                'price' => (float) $appetizer->price,
                'description' => $appetizer->description,
                'ingredients' => $appetizer->ingredients->map(fn($ing) => [
                    'id' => $ing->id,
                    'name' => $ing->name,
                    'slug' => $ing->slug,
                ]),
                'allergens' => $appetizer->getAllAllergens()->map(fn($all) => [
                    'id' => $all->id,
                    'name' => $all->name,
                    'slug' => $all->slug,
                ])->values(),
            ]
        ]);
    }
}
