<?php

namespace App\Observers;

use App\Models\Ingredient;
use App\Services\AllergenDetectionService;

class IngredientObserver
{
    /**
     * Gestisce l'evento "created" per un ingrediente
     * Auto-rileva e assegna allergeni quando viene creato un nuovo ingrediente
     */
    public function created(Ingredient $ingredient): void
    {
        // Aspetta che la transazione sia completata
        \DB::afterCommit(function () use ($ingredient) {
            AllergenDetectionService::autoAssignAllergens($ingredient, false);
        });
    }

    /**
     * Gestisce l'evento "updated" per un ingrediente
     * Se il nome cambia, ri-rileva gli allergeni
     */
    public function updated(Ingredient $ingredient): void
    {
        // Solo se il nome è cambiato
        if ($ingredient->wasChanged('name')) {
            \DB::afterCommit(function () use ($ingredient) {
                // Non sovrascrivere allergeni esistenti, aggiungi solo nuovi
                AllergenDetectionService::autoAssignAllergens($ingredient, false);
            });
        }
    }
}
