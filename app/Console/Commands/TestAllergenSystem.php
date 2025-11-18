<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pizza;
use App\Models\Dessert;
use App\Models\Appetizer;

class TestAllergenSystem extends Command
{
    protected $signature = 'test:allergens';
    protected $description = 'Testa il sistema intelligente di gestione allergeni';

    public function handle()
    {
        $this->info('=== TEST SISTEMA ALLERGENI INTELLIGENTE ===');
        $this->newLine();

        // Test Pizza
        $pizza = Pizza::with(['ingredients.allergens', 'category'])->first();

        if ($pizza) {
            $this->info("🍕 PIZZA: {$pizza->name}");
            $this->line(str_repeat("-", 50));
            
            // Ingredienti
            $this->newLine();
            $this->info("📦 INGREDIENTI ({$pizza->ingredients->count()}):");
            foreach ($pizza->ingredients as $ingredient) {
                $this->line("  • {$ingredient->name}");
                if ($ingredient->allergens->isNotEmpty()) {
                    $this->line("    └─ Allergeni: {$ingredient->allergens->pluck('name')->join(', ')}");
                }
            }
            
            // Allergeni automatici
            $this->newLine();
            $this->warn("⚠️  ALLERGENI AUTOMATICI (da ingredienti):");
            $automatic = $pizza->getAutomaticAllergens();
            if ($automatic->isEmpty()) {
                $this->line("  (nessuno)");
            } else {
                foreach ($automatic as $allergen) {
                    $this->line("  • {$allergen->name}");
                }
            }
            
            // Allergeni manuali
            $this->newLine();
            $this->comment("✏️  ALLERGENI MANUALI (override):");
            $manual = $pizza->getManualAllergens();
            if ($manual->isEmpty()) {
                $this->line("  (nessuno)");
            } else {
                foreach ($manual as $allergen) {
                    $this->line("  • {$allergen->name}");
                }
            }
            
            // Allergeni totali
            $this->newLine();
            $this->info("🎯 ALLERGENI FINALI (esposti al cliente):");
            $all = $pizza->getAllAllergens();
            if ($all->isEmpty()) {
                $this->line("  ✅ Nessun allergene!");
            } else {
                foreach ($all as $allergen) {
                    $this->line("  • {$allergen->name}");
                }
            }
            
            $this->newLine();
            $this->line(str_repeat("=", 50));
            
        } else {
            $this->error("❌ Nessuna pizza trovata nel database");
        }

        // Test Dessert
        $this->newLine(2);
        $dessert = Dessert::with(['ingredients.allergens'])->first();

        if ($dessert) {
            $this->info("🍰 TEST DESSERT: {$dessert->name}");
            $this->line("Allergeni automatici: " . $dessert->getAutomaticAllergens()->pluck('name')->join(', '));
            $this->line("Allergeni manuali: " . ($dessert->getManualAllergens()->isEmpty() ? '(nessuno)' : $dessert->getManualAllergens()->pluck('name')->join(', ')));
            $this->line("Allergeni totali: " . $dessert->getAllAllergens()->pluck('name')->join(', '));
        }

        $this->newLine();
        $this->info("✅ Test completato!");
        
        return 0;
    }
}
