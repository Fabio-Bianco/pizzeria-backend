<?php

namespace App\Console\Commands;

use App\Models\Ingredient;
use Illuminate\Console\Command;

class ShowMissingAllergens extends Command
{
    protected $signature = 'show:missing-allergens';
    protected $description = 'Mostra ingredienti senza allergeni';

    public function handle()
    {
        $ingredients = Ingredient::doesntHave('allergens')->get();
        
        $this->info("Ingredienti senza allergeni ({$ingredients->count()}):");
        $this->newLine();
        
        foreach ($ingredients as $ing) {
            $this->line("  • {$ing->name}");
        }
        
        return Command::SUCCESS;
    }
}
