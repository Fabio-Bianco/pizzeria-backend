<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class BeverageController extends BaseController
{
    // 🔧 CONFIGURAZIONI SPECIFICHE
    protected array $searchableFields = ['name', 'description', 'category'];
    protected array $sortableFields = ['name', 'price', 'created_at'];
    protected array $eagerLoadRelations = [];
    protected array $manyToManyRelations = [];
    protected ?string $uploadFolder = 'beverages';

    // 📝 VALIDAZIONE SPECIFICA
    protected function getValidationRules(Request $request, ?Model $model = null): array
    {
        return [
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'is_alcoholic' => 'boolean'
        ];
    }

    // 🔧 NOME VARIABILE PERSONALIZZATO PER VIEW
    protected function getIndexViewData($items): array
    {
        return ['beverages' => $items]; // View si aspetta $beverages, non $items
    }

    protected function getEditViewData($item): array
    {
        return ['beverage' => $item]; // View si aspetta $beverage, non $item
    }
}