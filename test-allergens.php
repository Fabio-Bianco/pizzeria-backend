<?php

use App\Models\Pizza;
use App\Models\Ingredient;
use App\Models\Allergen;

echo "=== TEST SISTEMA ALLERGENI INTELLIGENTE ===\n\n";

// Test 1: Pizza con allergeni automatici
$pizza = Pizza::with(['ingredients.allergens', 'category'])->first();

if ($pizza) {
    echo "🍕 PIZZA: {$pizza->name}\n";
    echo str_repeat("-", 50) . "\n";
    
    // Ingredienti
    echo "\n📦 INGREDIENTI ({$pizza->ingredients->count()}):\n";
    foreach ($pizza->ingredients as $ingredient) {
        echo "  • {$ingredient->name}\n";
        if ($ingredient->allergens->isNotEmpty()) {
            echo "    └─ Allergeni: {$ingredient->allergens->pluck('name')->join(', ')}\n";
        }
    }
    
    // Allergeni automatici (calcolati da ingredienti)
    echo "\n⚠️ ALLERGENI AUTOMATICI (da ingredienti):\n";
    $automatic = $pizza->getAutomaticAllergens();
    if ($automatic->isEmpty()) {
        echo "  (nessuno)\n";
    } else {
        foreach ($automatic as $allergen) {
            echo "  • {$allergen->name}\n";
        }
    }
    
    // Allergeni manuali (override)
    echo "\n✏️ ALLERGENI MANUALI (override):\n";
    $manual = $pizza->getManualAllergens();
    if ($manual->isEmpty()) {
        echo "  (nessuno)\n";
    } else {
        foreach ($manual as $allergen) {
            echo "  • {$allergen->name}\n";
        }
    }
    
    // Allergeni totali finali
    echo "\n🎯 ALLERGENI FINALI (esposti al cliente):\n";
    $all = $pizza->getAllAllergens();
    if ($all->isEmpty()) {
        echo "  ✅ Nessun allergene!\n";
    } else {
        foreach ($all as $allergen) {
            echo "  • {$allergen->name}\n";
        }
    }
    
    echo "\n" . str_repeat("=", 50) . "\n";
    
} else {
    echo "❌ Nessuna pizza trovata nel database\n";
}

// Test 2: Verifica del sistema su Dessert
echo "\n\n🍰 TEST DESSERT:\n";
$dessert = \App\Models\Dessert::with(['ingredients.allergens'])->first();

if ($dessert) {
    echo "Dessert: {$dessert->name}\n";
    echo "Allergeni automatici: " . $dessert->getAutomaticAllergens()->pluck('name')->join(', ') . "\n";
    echo "Allergeni manuali: " . ($dessert->getManualAllergens()->isEmpty() ? '(nessuno)' : $dessert->getManualAllergens()->pluck('name')->join(', ')) . "\n";
    echo "Allergeni totali: " . $dessert->getAllAllergens()->pluck('name')->join(', ') . "\n";
}

echo "\n✅ Test completato!\n";
