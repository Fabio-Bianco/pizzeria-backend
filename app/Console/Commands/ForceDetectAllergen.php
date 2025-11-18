<?php

namespace App\Console\Commands;

use App\Models\Ingredient;
use App\Services\AllergenDetectionService;
use Illuminate\Console\Command;

class ForceDetectAllergen extends Command
{
    protected $signature = 'force:detect-allergen {ingredient}';
    protected $description = 'Forza rilevamento allergeni per un ingrediente specifico';

    public function handle()
    {
        $ingredientName = $this->argument('ingredient');
        $ingredient = Ingredient::where('name', $ingredientName)->first();
        
        if (!$ingredient) {
            $this->error("Ingrediente '{$ingredientName}' non trovato!");
            return Command::FAILURE;
        }
        
        $this->info("Ingrediente: {$ingredient->name}");
        $this->line("Allergeni attuali: " . $ingredient->allergens->pluck('name')->implode(', '));
        $this->newLine();
        
        $count = AllergenDetectionService::autoAssignAllergens($ingredient, false);
        
        $ingredient->refresh();
        
        $this->info("✅ Allergeni aggiunti: {$count}");
        $this->line("Allergeni finali: " . $ingredient->allergens->pluck('name')->implode(', '));
        
        return Command::SUCCESS;
    }
}
