<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Allergen extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon', 'eu_code'];

    /**
     * ═══════════════════════════════════════════════════════════
     * RELAZIONI ELOQUENT - Relazioni inverse
     * ═══════════════════════════════════════════════════════════
     */

    /**
     * Relazione Many-to-Many inversa: Un allergene è presente in molti ingredienti
     * Usa tabella pivot 'allergen_ingredient'
     * Permette query: "Quali ingredienti contengono questo allergene?"
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)->withTimestamps();
    }

    /**
     * Relazione Many-to-Many diretta: Un allergene può essere in molti antipasti
     * Usa tabella pivot 'allergen_appetizer'
     * Per allergeni dichiarati manualmente (non tramite ingredienti)
     */
    public function appetizers(): BelongsToMany
    {
        return $this->belongsToMany(Appetizer::class)->withTimestamps();
    }

    /**
     * Relazione Many-to-Many diretta: Un allergene può essere in molti dessert
     * Usa tabella pivot 'allergen_dessert'
     * Per allergeni dichiarati manualmente (non tramite ingredienti)
     */
    public function desserts(): BelongsToMany
    {
        return $this->belongsToMany(Dessert::class)->withTimestamps();
    }

    /**
     * Relazione Many-to-Many diretta: Un allergene può essere in molte bevande
     * Usa tabella pivot 'allergen_beverage'
     * Per allergeni dichiarati manualmente (bevande raramente hanno ingredienti strutturati)
     */
    public function beverages(): BelongsToMany
    {
        return $this->belongsToMany(Beverage::class)->withTimestamps();
    }
}
