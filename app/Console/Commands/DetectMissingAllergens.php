<?php

namespace App\Console\Commands;

use App\Services\AllergenDetectionService;
use Illuminate\Console\Command;

class DetectMissingAllergens extends Command
{
    protected $signature = 'allergens:detect-missing 
                            {--force : Sovrascrive allergeni esistenti}';

    protected $description = 'Rileva automaticamente allergeni mancanti per ingredienti';

    public function handle()
    {
        $this->info('🔍 Cerco ingredienti senza allergeni associati...');
        $this->newLine();

        $stats = AllergenDetectionService::autoDetectMissingAllergens();

        $this->info("📊 RISULTATI:");
        $this->table(
            ['Metrica', 'Valore'],
            [
                ['Ingredienti senza allergeni', $stats['total']],
                ['Ingredienti processati', $stats['processed']],
                ['Allergeni assegnati', $stats['assigned']],
                ['Ingredienti senza match', $stats['skipped']],
            ]
        );

        if ($stats['assigned'] > 0) {
            $this->newLine();
            $this->info("✅ Allergeni assegnati automaticamente a {$stats['assigned']} ingredienti!");
        }

        if ($stats['skipped'] > 0) {
            $this->newLine();
            $this->warn("⚠️  {$stats['skipped']} ingredienti non hanno allergeni noti nel database.");
            $this->comment("   Considera di aggiungerli manualmente o di espandere il database di rilevamento.");
        }

        return Command::SUCCESS;
    }
}
