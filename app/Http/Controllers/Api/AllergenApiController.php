<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Allergen;
use Illuminate\Http\JsonResponse;

class AllergenApiController extends Controller
{
    /**
     * ⚠️ Lista tutti gli allergeni (per filtri frontend)
     */
    public function index(): JsonResponse
    {
        $allergens = Allergen::orderBy('name')
            ->get()
            ->map(function ($allergen) {
                return [
                    'id' => $allergen->id,
                    'name' => $allergen->name,
                    'slug' => $allergen->slug,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $allergens,
            'meta' => [
                'total' => $allergens->count(),
            ]
        ]);
    }
}
