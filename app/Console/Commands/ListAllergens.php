<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Allergen;

class ListAllergens extends Command
{
    protected $signature = 'list:allergens';
    protected $description = 'Lista tutti gli allergeni nel database';

    public function handle()
    {
        $allergens = Allergen::orderBy('name')->get();
        
        $this->info("Allergeni nel database ({$allergens->count()}):");
        $this->newLine();
        
        $data = $allergens->map(fn($a) => [$a->id, $a->name])->toArray();
        $this->table(['ID', 'Nome'], $data);

        return Command::SUCCESS;
    }
}
