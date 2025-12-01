<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Allergen;
use Illuminate\Http\Request;

class AllergenSuggestionController extends Controller
{
    // 🗄️ Database semplice di allergeni comuni
    private $knownAllergens = [
        'mozzarella' => ['Lattosio'],
        'gorgonzola' => ['Lattosio'],
        'parmigiano' => ['Lattosio'],
        'ricotta' => ['Lattosio'],
        'tonno' => ['Pesce'],
        'acciughe' => ['Pesce'],
        'salmone' => ['Pesce'],
        'gamberetti' => ['Crostacei'],
        'vongole' => ['Molluschi'],
        'calamari' => ['Molluschi'],
        'pomodoro' => ['Nichel'],
        'funghi' => ['Nichel'],
        'noci' => ['Frutta a guscio'],
        'pistacchio' => ['Frutta a guscio'],
        'mortadella' => ['Lattosio'],
        'wurstel' => ['Lattosio', 'Soia'],
    ];
    
    // 💡 Suggerisce allergeni per un ingrediente
    public function suggest(Request $request)
    {
        // ✅ Controlla che il nome sia valido
        $request->validate([
            'ingredient_name' => 'required|string|min:2'
        ]);

        $ingredientName = strtolower($request->input('ingredient_name'));
        
        // 🔍 Cerca allergeni nel nostro database
        $foundAllergens = [];
        foreach ($this->knownAllergens as $ingredient => $allergens) {
            if (str_contains($ingredientName, $ingredient)) {
                $foundAllergens = array_merge($foundAllergens, $allergens);
            }
        }
        $foundAllergens = array_unique($foundAllergens);
        
        // 📦 Recupera gli allergeni dal database
        $suggestedAllergens = Allergen::whereIn('name', $foundAllergens)->get();

        return response()->json([
            'success' => true,
            'ingredient' => $request->input('ingredient_name'),
            'suggested_allergens' => $suggestedAllergens->map(fn($a) => [
                'id' => $a->id,
                'name' => $a->name,
            ]),
            'count' => $suggestedAllergens->count(),
        ]);
    }

    // 🔄 Assegna allergeni automaticamente a tutti gli ingredienti
    public function autoDetectAll()
    {
        $ingredients = Ingredient::doesntHave('allergens')->get();
        $assigned = 0;
        
        foreach ($ingredients as $ingredient) {
            $ingredientName = strtolower($ingredient->name);
            
            // 🔍 Cerca allergeni
            $foundAllergens = [];
            foreach ($this->knownAllergens as $key => $allergens) {
                if (str_contains($ingredientName, $key)) {
                    $foundAllergens = array_merge($foundAllergens, $allergens);
                }
            }
            $foundAllergens = array_unique($foundAllergens);
            
            if (!empty($foundAllergens)) {
                $allergenIds = Allergen::whereIn('name', $foundAllergens)->pluck('id');
                $ingredient->allergens()->sync($allergenIds);
                $assigned++;
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "Allergeni assegnati automaticamente a {$assigned} ingredienti",
        ]);
    }

    // 🎯 Forza il rilevamento per un singolo ingrediente
    public function forceDetect(Ingredient $ingredient)
    {
        $ingredientName = strtolower($ingredient->name);
        
        // 🔍 Cerca allergeni
        $foundAllergens = [];
        foreach ($this->knownAllergens as $key => $allergens) {
            if (str_contains($ingredientName, $key)) {
                $foundAllergens = array_merge($foundAllergens, $allergens);
            }
        }
        $foundAllergens = array_unique($foundAllergens);
        
        $count = 0;
        if (!empty($foundAllergens)) {
            $allergenIds = Allergen::whereIn('name', $foundAllergens)->pluck('id');
            $ingredient->allergens()->sync($allergenIds);
            $count = count($allergenIds);
        }
        
        return response()->json([
            'success' => true,
            'ingredient' => $ingredient->name,
            'allergens_assigned' => $count,
            'allergens' => $ingredient->allergens()->get(),
        ]);
    }
}
