<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Beverage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'price', 'description', 'manual_allergens', 'image_path',
        'formato', 'tipologia', 'gradazione_alcolica', 'is_gluten_free',
    ];

    protected $casts = [
        'manual_allergens' => 'array',
        'image_path' => 'string',
        'is_gluten_free' => 'boolean',
    ];

    /**
     * Relazione molti-a-molti con Allergen
     */
    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(Allergen::class)->withTimestamps();
    }

    /**
     * Ottieni gli allergeni aggiunti manualmente
     * Le bevande solitamente non hanno ingredienti, quindi solo manuali
     */
    public function getManualAllergens(): Collection
    {
        if (empty($this->manual_allergens)) {
            return collect();
        }

        if (!isset($this->_cached_manual_allergens)) {
            $this->_cached_manual_allergens = Allergen::whereIn('id', $this->manual_allergens)->get();
        }

        return $this->_cached_manual_allergens;
    }

    /**
     * Ottieni tutti gli allergeni (per bevande = solo manuali)
     */
    public function getAllAllergens(): Collection
    {
        if (!isset($this->_cached_all_allergens)) {
            // Per le bevande, generalmente solo allergeni manuali
            // (raramente hanno "ingredienti" strutturati come le pizze)
            $this->_cached_all_allergens = $this->getManualAllergens()->sortBy('name');
        }

        return $this->_cached_all_allergens;
    }

    /**
     * Verifica se la bevanda contiene un allergene specifico
     */
    public function hasAllergen(int $allergenId): bool
    {
        return $this->getAllAllergens()->contains('id', $allergenId);
    }
}
