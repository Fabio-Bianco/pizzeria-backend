<?php

namespace App\Console\Commands;

use App\Services\AllergenDetectionService;
use Illuminate\Console\Command;

class TestAllergenDetection extends Command
{
    protected $signature = 'test:allergen-detection {ingredient}';
    protected $description = 'Testa il rilevamento allergeni per un ingrediente specifico';

    public function handle()
    {
        $ingredientName = $this->argument('ingredient');
        
        $this->info("🔍 Test rilevamento per: {$ingredientName}");
        $this->newLine();
        
        $allergens = AllergenDetectionService::detectAllergens($ingredientName);
        
        if (empty($allergens)) {
            $this->warn("⚠️  Nessun allergene rilevato");
        } else {
            $this->info("✅ Allergeni rilevati:");
            foreach ($allergens as $allergen) {
                $this->line("  • {$allergen}");
            }
        }
        
        return Command::SUCCESS;
    }
}
