<?php

namespace Database\Seeders;

use App\Models\Allergen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AllergenSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Glutine',
            'Lattosio',
            'Uova',
            'Soia',
            'Arachidi',
            'Frutta a guscio',
            'Pesce',
            'Crostacei',
            'Molluschi',
            'Sesamo',
            'Sedano',
            'Senape',
            'Solfiti',
            'Anidride Solforosa',
            'Lupini',
            'Nichel',
        ];
        foreach ($items as $name) {
            Allergen::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
