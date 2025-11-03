<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class CategoryController extends BaseController
{
    // 🔧 CONFIGURAZIONI SPECIFICHE
    protected array $searchableFields = ['name', 'description'];
    protected array $sortableFields = ['name', 'created_at'];
    protected array $eagerLoadRelations = []; // Categories non hanno relazioni da caricare
    protected array $manyToManyRelations = [];

    // 📝 VALIDAZIONE SPECIFICA
    protected function getValidationRules(Request $request, ?Model $model = null): array
    {
        return [
            'is_white' => 'boolean'
        ];
    }

    // 🔧 NOME VARIABILE PERSONALIZZATO PER VIEW
    protected function getIndexViewData($items): array
    {
        return ['categories' => $items]; // View si aspetta $categories, non $items
    }

    protected function getEditViewData($item): array
    {
        return ['category' => $item]; // View si aspetta $category, non $item
    }
}
