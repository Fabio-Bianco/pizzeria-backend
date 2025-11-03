<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class PizzaController extends BaseController
{
    // 🔧 CONFIGURAZIONI SPECIFICHE
    protected array $searchableFields = ['name', 'description', 'notes'];
    protected array $sortableFields = ['name', 'price', 'created_at'];
    protected array $eagerLoadRelations = ['category:id,name', 'ingredients:id,name'];
    protected array $manyToManyRelations = ['ingredients'];
    protected ?string $uploadFolder = 'pizzas';

    // 🔧 DATI EXTRA PER LE VIEW
    protected function getCreateViewData(): array
    {
        return [
            'categories' => \App\Models\Category::orderBy('name')->get(),
            'ingredients' => \App\Models\Ingredient::orderBy('name')->get(),
            'allergens' => \App\Models\Allergen::orderBy('name')->get()
        ];
    }

    protected function getEditViewData($item): array
    {
        return [
            'pizza' => $item, // View si aspetta $pizza, non $item
            'categories' => \App\Models\Category::orderBy('name')->get(),
            'ingredients' => \App\Models\Ingredient::orderBy('name')->get(),
            'allergens' => \App\Models\Allergen::orderBy('name')->get()
        ];
    }

    protected function getIndexViewData($items): array
    {
        return ['pizzas' => $items]; // View si aspetta $pizzas, non $items
    }

    // 📝 VALIDAZIONE SPECIFICA
    protected function getValidationRules(Request $request, ?Model $model = null): array
    {
        return [
            'notes' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
            'image' => 'nullable|image|max:2048',
            'is_gluten_free' => 'boolean',
            'is_vegan' => 'boolean',
            'manual_allergens' => 'array'
        ];
    }
}
