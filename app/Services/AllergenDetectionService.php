<?php

namespace App\Services;

use App\Models\Allergen;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AllergenDetectionService
{
    /**
     * Database locale di allergeni comuni per ingredienti
     * Usato come fallback se API esterne non sono disponibili
     */
    private static $knownAllergens = [
        // Latticini
        'mozzarella' => ['Lattosio'],
        'gorgonzola' => ['Lattosio'],
        'parmigiano' => ['Lattosio'],
        'scamorza' => ['Lattosio'],
        'ricotta' => ['Lattosio'],
        'mascarpone' => ['Lattosio'],
        'stracchino' => ['Lattosio'],
        'philadelphia' => ['Lattosio'],
        'formaggio' => ['Lattosio'],
        'burro' => ['Lattosio'],
        'panna' => ['Lattosio'],
        'latte' => ['Lattosio'],
        
        // Pesce
        'tonno' => ['Pesce'],
        'acciughe' => ['Pesce'],
        'salmone' => ['Pesce'],
        'alici' => ['Pesce'],
        'pesce spada' => ['Pesce'],
        
        // Molluschi e Crostacei
        'frutti di mare' => ['Molluschi', 'Crostacei'],
        'gamberetti' => ['Crostacei'],
        'gamberi' => ['Crostacei'],
        'scampi' => ['Crostacei'],
        'vongole' => ['Molluschi'],
        'cozze' => ['Molluschi'],
        'calamari' => ['Molluschi'],
        'polpo' => ['Molluschi'],
        
        // Nichel (verdure che lo contengono)
        'pomodoro' => ['Nichel'],
        'funghi' => ['Nichel'],
        'funghi champignon' => ['Nichel'],
        'funghi porcini' => ['Nichel'],
        'asparagi' => ['Nichel'],
        'spinaci' => ['Nichel'],
        'cipolla' => ['Nichel'],
        
        // Frutta a guscio
        'noci' => ['Noci'],
        'nocciole' => ['Noci'],
        'mandorle' => ['Noci'],
        'pistacchi' => ['Noci'],
        'pistacchio' => ['Noci'],
        'crema di pistacchio' => ['Noci', 'Lattosio'],
        'granella di pistacchio' => ['Noci'],
        'pinoli' => ['Noci'],
        'anacardi' => ['Noci'],
        
        // Glutine
        'farina' => ['Glutine'],
        'pasta' => ['Glutine'],
        'pane' => ['Glutine'],
        'impasto' => ['Glutine'],
        
        // Uova
        'uova' => ['Uova'],
        'uovo' => ['Uova'],
        
        // Soia
        'soia' => ['Soia'],
        'tofu' => ['Soia'],
        
        // Sesamo
        'sesamo' => ['Sesamo'],
        
        // Sedano
        'sedano' => ['Sedano'],
        
        // Senape
        'senape' => ['Senape'],
        
        // Salumi (contengono spesso Lattosio e Soia come conservanti)
        'mortadella' => ['Lattosio'],
        'mortadella igp' => ['Lattosio'],
        'wurstel' => ['Lattosio', 'Soia'],
        
        // Verdure e ingredienti senza allergeni principali
        'basilico' => [],
        'prosciutto crudo' => [],
        'prosciutto cotto' => [],
        'salame piccante' => [],
        'salame dolce' => [],
        'speck' => [],
        'bresaola' => [],
        'olive nere' => [],
        'olive verdi' => [],
        'olive' => [],
        'peperoni' => [],
        'zucchine' => [],
        'melanzane' => [],
        'mais' => [],
        'patate' => [],
        'rucola' => [],
        'cipolla rossa' => [],
        'carciofi' => [],
    ];

    /**
     * Rileva automaticamente gli allergeni per un ingrediente
     * 
     * @param string $ingredientName Nome dell'ingrediente
     * @return array Array di nomi di allergeni rilevati
     */
    public static function detectAllergens(string $ingredientName): array
    {
        // Normalizza il nome (lowercase, rimuovi spazi extra)
        $normalized = strtolower(trim($ingredientName));
        
        // 1. Cerca nel database locale
        $localAllergens = self::searchLocalDatabase($normalized);
        
        // 2. Se disponibile, integra con OpenFoodFacts API (gratuita)
        $apiAllergens = self::searchOpenFoodFacts($normalized);
        
        // 3. Merge risultati (priorità a database locale)
        $detectedAllergens = array_unique(array_merge($localAllergens, $apiAllergens));
        
        // Log per debug
        if (!empty($detectedAllergens)) {
            Log::info("Allergeni rilevati per '{$ingredientName}': " . implode(', ', $detectedAllergens));
        } else {
            Log::warning("Nessun allergene rilevato per '{$ingredientName}'");
        }
        
        return $detectedAllergens;
    }

    /**
     * Cerca nel database locale
     */
    private static function searchLocalDatabase(string $normalized): array
    {
        $found = [];
        
        foreach (self::$knownAllergens as $ingredient => $allergens) {
            // Match esatto
            if ($normalized === $ingredient) {
                $found = array_merge($found, $allergens);
                continue;
            }
            
            // Match parziale: l'ingrediente nel DB è contenuto nel nome normalizzato
            // Es: "pistacchio" match con "granella di pistacchio"
            if (str_contains($normalized, $ingredient)) {
                $found = array_merge($found, $allergens);
                continue;
            }
            
            // Match inverso: il nome normalizzato è contenuto nell'ingrediente del DB
            // Es: "olive" match con "olive nere"
            if (str_contains($ingredient, $normalized)) {
                $found = array_merge($found, $allergens);
            }
        }
        
        return array_unique($found);
    }

    /**
     * Cerca su OpenFoodFacts API (gratuita, database mondiale ingredienti)
     * https://world.openfoodfacts.org/data
     */
    private static function searchOpenFoodFacts(string $ingredientName): array
    {
        try {
            // API gratuita di OpenFoodFacts
            $response = Http::timeout(3)
                ->withHeaders([
                    'User-Agent' => 'PizzeriaBackend/1.0 (fabio@example.com)'
                ])
                ->get('https://world.openfoodfacts.org/cgi/search.pl', [
                    'search_terms' => $ingredientName,
                    'search_simple' => 1,
                    'action' => 'process',
                    'json' => 1,
                    'page_size' => 1,
                    'fields' => 'allergens_tags'
                ]);

            if ($response->successful() && isset($response->json()['products'][0]['allergens_tags'])) {
                $allergensTags = $response->json()['products'][0]['allergens_tags'];
                return self::mapOpenFoodFactsAllergens($allergensTags);
            }
        } catch (\Exception $e) {
            Log::warning("OpenFoodFacts API non disponibile: " . $e->getMessage());
        }
        
        return [];
    }

    /**
     * Mappa i tag di OpenFoodFacts ai nostri allergeni
     */
    private static function mapOpenFoodFactsAllergens(array $tags): array
    {
        $mapping = [
            'en:milk' => 'Lattosio',
            'en:lactose' => 'Lattosio',
            'en:gluten' => 'Glutine',
            'en:eggs' => 'Uova',
            'en:fish' => 'Pesce',
            'en:crustaceans' => 'Crostacei',
            'en:molluscs' => 'Molluschi',
            'en:nuts' => 'Noci',
            'en:peanuts' => 'Arachidi',
            'en:soybeans' => 'Soia',
            'en:celery' => 'Sedano',
            'en:mustard' => 'Senape',
            'en:sesame-seeds' => 'Sesamo',
            'en:sulphur-dioxide-and-sulphites' => 'Solfiti',
            'en:lupin' => 'Lupini',
        ];
        
        $result = [];
        foreach ($tags as $tag) {
            if (isset($mapping[$tag])) {
                $result[] = $mapping[$tag];
            }
        }
        
        return $result;
    }

    /**
     * Associa automaticamente gli allergeni a un ingrediente
     * 
     * @param \App\Models\Ingredient $ingredient
     * @param bool $overwrite Se true, sovrascrive allergeni esistenti
     * @return int Numero di allergeni associati
     */
    public static function autoAssignAllergens($ingredient, bool $overwrite = false): int
    {
        // Se l'ingrediente ha già allergeni e non vogliamo sovrascrivere, esci
        if (!$overwrite && $ingredient->allergens()->count() > 0) {
            Log::info("Ingrediente '{$ingredient->name}' ha già allergeni associati. Skip.");
            return 0;
        }
        
        // Rileva allergeni
        $detectedAllergenNames = self::detectAllergens($ingredient->name);
        
        if (empty($detectedAllergenNames)) {
            return 0;
        }
        
        // Trova gli ID degli allergeni nel database
        $allergenIds = Allergen::whereIn('name', $detectedAllergenNames)->pluck('id')->toArray();
        
        if (empty($allergenIds)) {
            Log::warning("Nessun allergene trovato nel database tra: " . implode(', ', $detectedAllergenNames));
            return 0;
        }
        
        // Associa gli allergeni
        if ($overwrite) {
            $ingredient->allergens()->sync($allergenIds);
        } else {
            $ingredient->allergens()->syncWithoutDetaching($allergenIds);
        }
        
        Log::info("Associati " . count($allergenIds) . " allergeni a '{$ingredient->name}'");
        
        return count($allergenIds);
    }

    /**
     * Verifica tutti gli ingredienti senza allergeni e prova ad assegnarli
     * 
     * @return array Statistiche dell'operazione
     */
    public static function autoDetectMissingAllergens(): array
    {
        $ingredients = \App\Models\Ingredient::doesntHave('allergens')->get();
        
        $stats = [
            'total' => $ingredients->count(),
            'processed' => 0,
            'assigned' => 0,
            'skipped' => 0,
        ];
        
        foreach ($ingredients as $ingredient) {
            $stats['processed']++;
            $count = self::autoAssignAllergens($ingredient, false);
            
            if ($count > 0) {
                $stats['assigned']++;
            } else {
                $stats['skipped']++;
            }
        }
        
        return $stats;
    }
}
