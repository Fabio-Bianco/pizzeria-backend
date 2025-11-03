<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class IngredientController extends BaseController
{
    // 🔧 CONFIGURAZIONI SPECIFICHE
    protected array $searchableFields = ['name', 'description'];
    protected array $sortableFields = ['name', 'created_at'];
    protected array $eagerLoadRelations = ['allergens:id,name'];
    protected array $manyToManyRelations = ['allergens'];

    // 📝 VALIDAZIONE SPECIFICA
    protected function getValidationRules(Request $request, ?Model $model = null): array
    {
        return [
            'allergens' => 'array',
            'allergens.*' => 'exists:allergens,id',
            'is_tomato' => 'boolean'
        ];
    }

    // 🔧 DATI EXTRA PER LE VIEW
    protected function getCreateViewData(): array
    {
        return [
            'allergens' => \App\Models\Allergen::orderBy('name')->get()
        ];
    }

    protected function getEditViewData($item): array
    {
        return [
            'ingredient' => $item, // View si aspetta $ingredient, non $item
            'allergens' => \App\Models\Allergen::orderBy('name')->get()
        ];
    }

    protected function getIndexViewData($items): array
    {
        return ['ingredients' => $items]; // View si aspetta $ingredients, non $items
    }

    // AJAX endpoint specifico per form intelligenti
    public function getAllergensForIngredients(Request $request)
    {
        $ingredientIds = $request->input('ingredient_ids', []);
        if (empty($ingredientIds)) return response()->json(['allergens' => []]);

        $allergens = \App\Models\Allergen::whereHas('ingredients', fn($q) => $q->whereIn('ingredients.id', $ingredientIds))
            ->get(['id', 'name'])->unique('id');

        return response()->json(['allergens' => $allergens]);
    }
}
