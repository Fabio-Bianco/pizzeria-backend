<?php

namespace Database\Seeders;

use App\Models\Allergen;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            // Formaggi e latticini
            'Mozzarella' => ['Lattosio'],
            'Gorgonzola' => ['Lattosio'],
            'Parmigiano' => ['Lattosio'],
            'Scamorza' => ['Lattosio'],
            'Ricotta' => ['Lattosio'],
            'Mascarpone' => ['Lattosio'],
            'Stracchino' => ['Lattosio'],
            
            // Verdure e vegetali
            'Pomodoro' => ['Nichel'],
            'Basilico' => [],
            'Funghi champignon' => ['Nichel'],
            'Funghi porcini' => ['Nichel'],
            'Rucola' => [],
            'Cipolla rossa' => [],
            'Carciofi' => [],
            'Peperoni' => [],
            'Zucchine' => [],
            'Melanzane' => [],
            'Patate' => [],
            'Mais' => [],
            'Spinaci' => [],
            
            // Salumi e carni
            'Prosciutto cotto' => [],
            'Prosciutto crudo' => [],
            'Salame piccante' => [],
            'Salame dolce' => [],
            'Wurstel' => [],
            'Speck' => [],
            'Bresaola' => [],
            'Salsiccia' => [],
            
            // Pesce e frutti di mare
            'Tonno' => ['Pesce'],
            'Acciughe' => ['Pesce'],
            'Salmone' => ['Pesce'],
            'Frutti di mare' => ['Molluschi', 'Crostacei'],
            'Gamberetti' => ['Crostacei'],
            
            // Altro
            'Olive nere' => [],
            'Olive verdi' => [],
            'Uova' => ['Uova'],
            'Farina' => ['Glutine'],
        ];

        foreach ($map as $name => $allergens) {
            $ingredient = Ingredient::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'is_tomato' => Str::slug($name) === 'pomodoro']
            );

            $ids = Allergen::whereIn('name', $allergens)->pluck('id');
            $ingredient->allergens()->syncWithoutDetaching($ids);
        }
    }
}
