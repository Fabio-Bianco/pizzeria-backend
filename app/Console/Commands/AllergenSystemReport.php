<?php

namespace App\Console\Commands;

use App\Models\Allergen;
use App\Models\Ingredient;
use App\Models\Pizza;
use App\Models\Appetizer;
use App\Models\Dessert;
use App\Models\Beverage;
use Illuminate\Console\Command;

class AllergenSystemReport extends Command
{
    protected $signature = 'report:allergen-system';
    protected $description = 'Report completo sul sistema di tracciamento allergeni per tutto il menu';

    public function handle()
    {
        $this->info('═══════════════════════════════════════════════════════════════');
        $this->info('   📊 REPORT SISTEMA ALLERGENI - MENU COMPLETO');
        $this->info('═══════════════════════════════════════════════════════════════');
        $this->newLine();

        // 1. STATISTICHE GENERALI
        $this->section1_GeneralStats();
        
        // 2. INGREDIENTI E ALLERGENI
        $this->section2_Ingredients();
        
        // 3. PIZZE
        $this->section3_Pizzas();
        
        // 4. ANTIPASTI
        $this->section4_Appetizers();
        
        // 5. DESSERT
        $this->section5_Desserts();
        
        // 6. BEVANDE
        $this->section6_Beverages();
        
        // 7. RACCOMANDAZIONI
        $this->section7_Recommendations();

        return Command::SUCCESS;
    }

    private function section1_GeneralStats()
    {
        $this->line('┌─────────────────────────────────────────────────────────────┐');
        $this->line('│ 1. STATISTICHE GENERALI                                     │');
        $this->line('└─────────────────────────────────────────────────────────────┘');
        $this->newLine();

        $allergensCount = Allergen::count();
        $ingredientsCount = Ingredient::count();
        $ingredientsWithAllergens = Ingredient::has('allergens')->count();
        $ingredientsWithoutAllergens = Ingredient::doesntHave('allergens')->count();
        
        $pizzasCount = Pizza::count();
        $appetizersCount = Appetizer::count();
        $dessertsCount = Dessert::count();
        $beveragesCount = Beverage::count();

        $data = [
            ['Allergeni nel database', $allergensCount, '✅'],
            ['Ingredienti totali', $ingredientsCount, '✅'],
            ['Ingredienti con allergeni', $ingredientsWithAllergens, $ingredientsWithAllergens > 0 ? '✅' : '⚠️'],
            ['Ingredienti senza allergeni', $ingredientsWithoutAllergens, $ingredientsWithoutAllergens == 0 ? '✅' : '⚠️'],
            ['', '', ''],
            ['Pizze nel menu', $pizzasCount, '✅'],
            ['Antipasti nel menu', $appetizersCount, '✅'],
            ['Dessert nel menu', $dessertsCount, '✅'],
            ['Bevande nel menu', $beveragesCount, '✅'],
        ];

        $this->table(['Categoria', 'Valore', 'Status'], $data);
        $this->newLine();
    }

    private function section2_Ingredients()
    {
        $this->line('┌─────────────────────────────────────────────────────────────┐');
        $this->line('│ 2. INGREDIENTI E ALLERGENI                                  │');
        $this->line('└─────────────────────────────────────────────────────────────┘');
        $this->newLine();

        // Ingredienti CON allergeni
        $ingredientsWithAllergens = Ingredient::has('allergens')
            ->with('allergens')
            ->orderBy('name')
            ->get();

        if ($ingredientsWithAllergens->isNotEmpty()) {
            $this->info("✅ Ingredienti con allergeni associati ({$ingredientsWithAllergens->count()}):");
            $this->newLine();
            
            $data = $ingredientsWithAllergens->map(fn($ing) => [
                $ing->name,
                $ing->allergens->pluck('name')->implode(', '),
                '✅'
            ])->toArray();
            
            $this->table(['Ingrediente', 'Allergeni', 'Status'], $data);
        }

        $this->newLine();

        // Ingredienti SENZA allergeni
        $ingredientsWithoutAllergens = Ingredient::doesntHave('allergens')
            ->orderBy('name')
            ->get();

        if ($ingredientsWithoutAllergens->isNotEmpty()) {
            $this->warn("⚠️  Ingredienti senza allergeni associati ({$ingredientsWithoutAllergens->count()}):");
            $this->newLine();
            
            foreach ($ingredientsWithoutAllergens as $ing) {
                $this->line("  • {$ing->name}");
            }
            
            $this->newLine();
            $this->comment("💡 Questi ingredienti potrebbero non avere allergeni (es: verdure, salumi puri)");
            $this->comment("   oppure necessitano di essere associati manualmente.");
        }

        $this->newLine();
    }

    private function section3_Pizzas()
    {
        $this->line('┌─────────────────────────────────────────────────────────────┐');
        $this->line('│ 3. 🍕 PIZZE - Tracciamento Allergeni                        │');
        $this->line('└─────────────────────────────────────────────────────────────┘');
        $this->newLine();

        $pizzas = Pizza::with(['ingredients.allergens'])->get();

        if ($pizzas->isEmpty()) {
            $this->warn("⚠️  Nessuna pizza nel database");
            $this->newLine();
            return;
        }

        foreach ($pizzas as $pizza) {
            $automaticAllergens = $pizza->getAutomaticAllergens();
            $manualAllergens = $pizza->getManualAllergens();
            $allAllergens = $pizza->getAllAllergens();

            $status = '✅';
            if ($automaticAllergens->isEmpty() && $manualAllergens->isEmpty()) {
                $status = '⚠️';
            }

            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->line("{$status} Pizza: {$pizza->name}");
            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            
            // Ingredienti
            $this->line("📦 Ingredienti ({$pizza->ingredients->count()}):");
            foreach ($pizza->ingredients as $ing) {
                $ingAllergens = $ing->allergens->pluck('name')->implode(', ');
                if ($ingAllergens) {
                    $this->line("  • {$ing->name} → {$ingAllergens}");
                } else {
                    $this->line("  • {$ing->name}");
                }
            }
            
            $this->newLine();
            
            // Allergeni automatici
            $this->line("⚙️  Allergeni AUTOMATICI (da ingredienti):");
            if ($automaticAllergens->isEmpty()) {
                $this->line("  (nessuno)");
            } else {
                foreach ($automaticAllergens as $allergen) {
                    $this->line("  • {$allergen->name}");
                }
            }
            
            $this->newLine();
            
            // Allergeni manuali
            $this->line("✏️  Allergeni MANUALI (override):");
            if ($manualAllergens->isEmpty()) {
                $this->line("  (nessuno)");
            } else {
                foreach ($manualAllergens as $allergen) {
                    $this->line("  • {$allergen->name}");
                }
            }
            
            $this->newLine();
            
            // Allergeni finali
            $this->line("🎯 Allergeni FINALI (esposti al cliente):");
            if ($allAllergens->isEmpty()) {
                $this->line("  (nessuno)");
            } else {
                foreach ($allAllergens as $allergen) {
                    $this->line("  • {$allergen->name}");
                }
            }
            
            $this->newLine();
        }
    }

    private function section4_Appetizers()
    {
        $this->line('┌─────────────────────────────────────────────────────────────┐');
        $this->line('│ 4. 🥗 ANTIPASTI - Tracciamento Allergeni                    │');
        $this->line('└─────────────────────────────────────────────────────────────┘');
        $this->newLine();

        $appetizers = Appetizer::with(['ingredients.allergens'])->get();

        if ($appetizers->isEmpty()) {
            $this->warn("⚠️  Nessun antipasto nel database");
            $this->newLine();
            return;
        }

        foreach ($appetizers as $appetizer) {
            $automaticAllergens = $appetizer->getAutomaticAllergens();
            $manualAllergens = $appetizer->getManualAllergens();
            $allAllergens = $appetizer->getAllAllergens();

            $status = '✅';
            if ($automaticAllergens->isEmpty() && $manualAllergens->isEmpty()) {
                $status = '⚠️';
            }

            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->line("{$status} Antipasto: {$appetizer->name}");
            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            
            if ($appetizer->ingredients->isNotEmpty()) {
                $this->line("📦 Ingredienti ({$appetizer->ingredients->count()}):");
                foreach ($appetizer->ingredients as $ing) {
                    $ingAllergens = $ing->allergens->pluck('name')->implode(', ');
                    if ($ingAllergens) {
                        $this->line("  • {$ing->name} → {$ingAllergens}");
                    } else {
                        $this->line("  • {$ing->name}");
                    }
                }
                $this->newLine();
            }
            
            $this->line("🎯 Allergeni FINALI: " . ($allAllergens->isEmpty() ? '(nessuno)' : $allAllergens->pluck('name')->implode(', ')));
            $this->newLine();
        }
    }

    private function section5_Desserts()
    {
        $this->line('┌─────────────────────────────────────────────────────────────┐');
        $this->line('│ 5. 🍰 DESSERT - Tracciamento Allergeni                      │');
        $this->line('└─────────────────────────────────────────────────────────────┘');
        $this->newLine();

        $desserts = Dessert::with(['ingredients.allergens'])->get();

        if ($desserts->isEmpty()) {
            $this->warn("⚠️  Nessun dessert nel database");
            $this->newLine();
            return;
        }

        foreach ($desserts as $dessert) {
            $automaticAllergens = $dessert->getAutomaticAllergens();
            $manualAllergens = $dessert->getManualAllergens();
            $allAllergens = $dessert->getAllAllergens();

            $status = '✅';
            if ($automaticAllergens->isEmpty() && $manualAllergens->isEmpty()) {
                $status = '⚠️';
            }

            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->line("{$status} Dessert: {$dessert->name}");
            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            
            if ($dessert->ingredients->isNotEmpty()) {
                $this->line("📦 Ingredienti ({$dessert->ingredients->count()}):");
                foreach ($dessert->ingredients as $ing) {
                    $ingAllergens = $ing->allergens->pluck('name')->implode(', ');
                    if ($ingAllergens) {
                        $this->line("  • {$ing->name} → {$ingAllergens}");
                    } else {
                        $this->line("  • {$ing->name}");
                    }
                }
                $this->newLine();
            }
            
            $this->line("🎯 Allergeni FINALI: " . ($allAllergens->isEmpty() ? '(nessuno)' : $allAllergens->pluck('name')->implode(', ')));
            $this->newLine();
        }
    }

    private function section6_Beverages()
    {
        $this->line('┌─────────────────────────────────────────────────────────────┐');
        $this->line('│ 6. 🥤 BEVANDE - Tracciamento Allergeni                      │');
        $this->line('└─────────────────────────────────────────────────────────────┘');
        $this->newLine();

        $beverages = Beverage::all();

        if ($beverages->isEmpty()) {
            $this->warn("⚠️  Nessuna bevanda nel database");
            $this->newLine();
            return;
        }

        $count = $beverages->count();
        $this->info("📊 Bevande totali: {$count}");
        $this->newLine();
        
        foreach ($beverages as $beverage) {
            $name = $beverage->name;
            $size = $beverage->size;
            $this->line("  • {$name} ({$size})");
        }
        
        $this->newLine();
        $this->comment("💡 Le bevande generalmente non hanno allergeni specifici.");
        $this->comment("   Se necessario, possono essere aggiunti allergeni manuali.");
        $this->newLine();
    }

    private function section7_Recommendations()
    {
        $this->line('┌─────────────────────────────────────────────────────────────┐');
        $this->line('│ 7. 💡 RACCOMANDAZIONI E AZIONI CONSIGLIATE                  │');
        $this->line('└─────────────────────────────────────────────────────────────┘');
        $this->newLine();

        $recommendations = [];
        $ingredientsWithoutAllergens = Ingredient::doesntHave('allergens')->count();
        
        if ($ingredientsWithoutAllergens > 0) {
            $recommendations[] = [
                '⚠️',
                'Ingredienti senza allergeni',
                "Ci sono {$ingredientsWithoutAllergens} ingredienti senza allergeni associati",
                'php artisan allergens:detect-missing'
            ];
        } else {
            $recommendations[] = [
                '✅',
                'Ingredienti completi',
                'Tutti gli ingredienti hanno allergeni associati o non ne necessitano',
                '-'
            ];
        }

        $pizzasWithoutAllergens = Pizza::with('ingredients.allergens')
            ->get()
            ->filter(fn($p) => $p->getAllAllergens()->isEmpty())
            ->count();
        
        if ($pizzasWithoutAllergens > 0) {
            $recommendations[] = [
                '⚠️',
                'Pizze senza allergeni',
                "{$pizzasWithoutAllergens} pizze non hanno allergeni tracciati",
                'Verifica ingredienti o aggiungi allergeni manuali'
            ];
        } else {
            $recommendations[] = [
                '✅',
                'Pizze complete',
                'Tutte le pizze hanno allergeni tracciati',
                '-'
            ];
        }

        $recommendations[] = [
            '📅',
            'Manutenzione periodica',
            'Esegui controlli settimanali',
            'php artisan report:allergen-system'
        ];

        $recommendations[] = [
            '🤖',
            'Sistema automatico',
            'Observer attivo: nuovi ingredienti ricevono allergeni automaticamente',
            'Nessuna azione richiesta'
        ];

        $this->table(['Status', 'Area', 'Descrizione', 'Comando/Azione'], $recommendations);
        $this->newLine();

        // RIEPILOGO FINALE
        $this->info('═══════════════════════════════════════════════════════════════');
        $this->info('   ✅ RIEPILOGO SISTEMA');
        $this->info('═══════════════════════════════════════════════════════════════');
        $this->newLine();
        
        $totalAllergens = Allergen::count();
        $totalIngredients = Ingredient::count();
        $ingredientsWithAllergens = Ingredient::has('allergens')->count();
        $coverage = $totalIngredients > 0 ? round(($ingredientsWithAllergens / $totalIngredients) * 100, 1) : 0;
        
        $this->line("🔢 Allergeni nel sistema: {$totalAllergens}");
        $this->line("📦 Ingredienti totali: {$totalIngredients}");
        $this->line("✅ Ingredienti con allergeni: {$ingredientsWithAllergens}");
        $this->line("📊 Copertura: {$coverage}%");
        $this->newLine();
        
        if ($coverage >= 80) {
            $this->info("🎉 Sistema funzionante correttamente! Ottima copertura.");
        } elseif ($coverage >= 50) {
            $this->warn("⚠️  Sistema funzionante ma può essere migliorato.");
        } else {
            $this->error("❌ Sistema necessita attenzione. Molti ingredienti senza allergeni.");
        }
        
        $this->newLine();
    }
}
