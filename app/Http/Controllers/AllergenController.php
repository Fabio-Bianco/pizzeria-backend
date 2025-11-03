<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class AllergenController extends BaseController
{
    // 🔧 CONFIGURAZIONI SPECIFICHE
    protected array $searchableFields = ['name', 'description'];
    protected array $sortableFields = ['name', 'created_at'];
    protected array $eagerLoadRelations = [];
    protected array $manyToManyRelations = [];

    // 📝 VALIDAZIONE SPECIFICA
    protected function getValidationRules(Request $request, ?Model $model = null): array
    {
        return [
            'icon' => 'nullable|string|max:255'
        ];
    }

    // 🔧 NOME VARIABILE PERSONALIZZATO PER VIEW
    protected function getIndexViewData($items): array
    {
        return ['allergens' => $items]; // View si aspetta $allergens, non $items
    }

    protected function getEditViewData($item): array
    {
        return ['allergen' => $item]; // View si aspetta $allergen, non $item
    }
}
