<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ingredient;
use App\Models\Allergen;
use App\Models\Dessert;
use App\Models\Appetizer;

class FixAllergenData extends Command
{
    protected $signature = 'fix:allergen-data';
    protected $description = 'Corregge dati mancanti nel sistema allergeni';

    public function handle()
    {
        $this->info('🔧 CORREZIONE DATI ALLERGENI');
        $this->newLine();

        // 1. Granella di pistacchio → Noci
        $this->fixGranellaPistacchio();

        // 2. Tiramisù → Lattosio, Uova, Glutine
        $this->fixTiramisu();

        // 3. Bruschette → Glutine
        $this->fixBruschette();

        $this->newLine();
        $this->info('✅ Correzioni completate!');
        $this->comment('💡 Esegui: php artisan report:allergen-system per verificare');

        return Command::SUCCESS;
    }

    private function fixGranellaPistacchio()
    {
        $ingredient = Ingredient::where('name', 'Granella di pistacchio')->first();
        $allergen = Allergen::where('name', 'Frutta a guscio')->first();

        if ($ingredient && $allergen) {
            $ingredient->allergens()->syncWithoutDetaching([$allergen->id]);
            $this->line('✅ Granella di pistacchio → Frutta a guscio');
        } else {
            $this->warn('⚠️  Granella di pistacchio o allergene Frutta a guscio non trovato');
        }
    }

    private function fixTiramisu()
    {
        $tiramisu = Dessert::where('name', 'Tiramisù')->first();
        
        if (!$tiramisu) {
            $this->warn('⚠️  Tiramisù non trovato');
            return;
        }

        // Ingredienti tipici del tiramisù
        $ingredientsToAdd = [
            'Mascarpone',
            'Uova',
            'Farina', // per i savoiardi
        ];

        $ingredientIds = Ingredient::whereIn('name', $ingredientsToAdd)->pluck('id')->toArray();

        if (!empty($ingredientIds)) {
            $tiramisu->ingredients()->syncWithoutDetaching($ingredientIds);
            $this->line('✅ Tiramisù → ingredienti aggiunti (Mascarpone, Uova, Farina)');
        } else {
            $this->warn('⚠️  Ingredienti del Tiramisù non trovati nel database');
        }
    }

    private function fixBruschette()
    {
        $bruschette = Appetizer::where('name', 'Bruschette del Fornaio')->first();
        
        if (!$bruschette) {
            $this->warn('⚠️  Bruschette non trovate');
            return;
        }

        // Ingredienti tipici delle bruschette
        $ingredientsToAdd = [
            'Pomodoro',
            'Basilico',
            'Farina', // per il pane
        ];

        $ingredientIds = Ingredient::whereIn('name', $ingredientsToAdd)->pluck('id')->toArray();

        if (!empty($ingredientIds)) {
            $bruschette->ingredients()->syncWithoutDetaching($ingredientIds);
            $this->line('✅ Bruschette → ingredienti aggiunti (Pomodoro, Basilico, Farina)');
        } else {
            $this->warn('⚠️  Ingredienti delle Bruschette non trovati nel database');
        }
    }
}
