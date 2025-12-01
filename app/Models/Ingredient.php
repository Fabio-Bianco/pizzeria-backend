<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'is_tomato'];

    /**
     * ═══════════════════════════════════════════════════════════
     * RELAZIONI ELOQUENT - Many-to-Many
     * ═══════════════════════════════════════════════════════════
     */

    /**
     * Relazione Many-to-Many: Un ingrediente è in molte pizze
     * Usa tabella pivot 'ingredient_pizza'
     */
    public function pizzas(): BelongsToMany
    {
        return $this->belongsToMany(Pizza::class)->withTimestamps();
    }

    /**
     * Relazione Many-to-Many: Un ingrediente è in molti antipasti
     * Usa tabella pivot 'appetizer_ingredient'
     */
    public function appetizers(): BelongsToMany
    {
        return $this->belongsToMany(Appetizer::class)->withTimestamps();
    }

    /**
     * Relazione Many-to-Many: Un ingrediente è in molti dessert
     * Usa tabella pivot 'dessert_ingredient'
     */
    public function desserts(): BelongsToMany
    {
        return $this->belongsToMany(Dessert::class)->withTimestamps();
    }

    /**
     * Relazione Many-to-Many: Un ingrediente contiene molti allergeni
     * Usa tabella pivot 'allergen_ingredient' (CORE del sistema)
     * Questa è la relazione chiave per il calcolo automatico allergeni
     */
    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(Allergen::class)->withTimestamps();
    }
}
