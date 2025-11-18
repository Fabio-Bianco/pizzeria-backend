<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Services\AllergenDetectionService;
use Illuminate\Http\Request;

class AllergenSuggestionController extends Controller
{
    /**
     * Suggerisce allergeni per un ingrediente specifico
     * Endpoint AJAX usato nel form di creazione/modifica ingrediente
     */
    public function suggest(Request $request)
    {
        $request->validate([
            'ingredient_name' => 'required|string|min:2'
        ]);

        $ingredientName = $request->input('ingredient_name');
        
        // Rileva allergeni suggeriti
        $suggestedAllergenNames = AllergenDetectionService::detectAllergens($ingredientName);
        
        // Recupera gli oggetti allergen dal database
        $suggestedAllergens = \App\Models\Allergen::whereIn('name', $suggestedAllergenNames)->get();

        return response()->json([
            'success' => true,
            'ingredient' => $ingredientName,
            'suggested_allergens' => $suggestedAllergens->map(fn($a) => [
                'id' => $a->id,
                'name' => $a->name,
            ]),
            'count' => $suggestedAllergens->count(),
        ]);
    }

    /**
     * Esegue auto-rilevamento per tutti gli ingredienti senza allergeni
     */
    public function autoDetectAll()
    {
        $stats = AllergenDetectionService::autoDetectMissingAllergens();
        
        return response()->json([
            'success' => true,
            'message' => "Allergeni assegnati automaticamente a {$stats['assigned']} ingredienti",
            'stats' => $stats,
        ]);
    }

    /**
     * Forza il rilevamento per un ingrediente specifico
     */
    public function forceDetect(Ingredient $ingredient)
    {
        $count = AllergenDetectionService::autoAssignAllergens($ingredient, false);
        
        return response()->json([
            'success' => true,
            'ingredient' => $ingredient->name,
            'allergens_assigned' => $count,
            'allergens' => $ingredient->allergens()->get(),
        ]);
    }
}
