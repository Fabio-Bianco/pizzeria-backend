<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Beverage;
use Illuminate\Http\JsonResponse;

class BeverageApiController extends Controller
{
    /**
     * 🥤 Lista tutte le bevande
     */
    public function index(): JsonResponse
    {
        $beverages = Beverage::orderBy('name')
            ->get()
            ->map(function ($beverage) {
                return [
                    'id' => $beverage->id,
                    'name' => $beverage->name,
                    'slug' => $beverage->slug,
                    'price' => (float) $beverage->price,
                    'description' => $beverage->description,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $beverages,
            'meta' => [
                'total' => $beverages->count(),
            ]
        ]);
    }

    /**
     * 👁️ Mostra singola bevanda
     */
    public function show(Beverage $beverage): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $beverage->id,
                'name' => $beverage->name,
                'slug' => $beverage->slug,
                'price' => (float) $beverage->price,
                'description' => $beverage->description,
            ]
        ]);
    }
}
