<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'is_white'];

    /**
     * ═══════════════════════════════════════════════════════════
     * RELAZIONI ELOQUENT
     * ═══════════════════════════════════════════════════════════
     */

    /**
     * Relazione One-to-Many: Una categoria ha molte pizze
     * Laravel cerca automaticamente 'category_id' nella tabella pizzas
     * Restituisce una Collection di oggetti Pizza
     */
    public function pizzas(): HasMany
    {
        return $this->hasMany(Pizza::class);
    }
}
