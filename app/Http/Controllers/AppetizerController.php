<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class AppetizerController extends BaseController
{
    // 🔧 CONFIGURAZIONI SPECIFICHE
    protected array $searchableFields = ['name', 'description'];
    protected array $sortableFields = ['name', 'price', 'created_at'];
    protected array $eagerLoadRelations = ['ingredients:id,name'];
    protected array $manyToManyRelations = ['ingredients'];
    protected ?string $uploadFolder = 'appetizers';

    // 📝 VALIDAZIONE SPECIFICA
    protected function getValidationRules(Request $request, ?Model $model = null): array
    {
        return [
            'price' => 'required|numeric|min:0',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
            'image' => 'nullable|image|max:2048',
            'is_gluten_free' => 'boolean'
        ];
    }

    // 🔧 NOME VARIABILE PERSONALIZZATO PER VIEW
    protected function getIndexViewData($items): array
    {
        return ['appetizers' => $items]; // View si aspetta $appetizers, non $items
    }

    protected function getCreateViewData(): array
    {
        return [
            'ingredients' => \App\Models\Ingredient::orderBy('name')->get()
        ];
    }

    protected function getEditViewData($item): array
    {
        return [
            'appetizer' => $item, // View si aspetta $appetizer, non $item
            'ingredients' => \App\Models\Ingredient::orderBy('name')->get()
        ];
    }
}