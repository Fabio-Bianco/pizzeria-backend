<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasCrud
{
    // 🔧 CONFIGURAZIONI SOVRASCRIVIBILI
    protected array $searchableFields = ['name', 'description'];
    protected array $sortableFields = ['name', 'price', 'created_at'];
    protected array $eagerLoadRelations = ['category:id,name', 'ingredients:id,name'];
    protected array $manyToManyRelations = ['ingredients', 'allergens', 'categories'];
    protected string $imageField = 'image_path';
    protected string $imageDisk = 'public';
    protected ?string $viewPrefix = null;
    protected ?string $routePrefix = null;
    protected ?string $uploadFolder = null;

    protected function getModelClass(): string
    {
        $controller = class_basename(static::class);
        $model = str_replace('Controller', '', $controller);
        return "App\\Models\\{$model}";
    }

    protected function getViewPrefix(): string
    {
        if ($this->viewPrefix) {
            return $this->viewPrefix;
        }
        
        $controller = class_basename(static::class);
        $resource = str_replace('Controller', '', $controller);
        $plural = Str::plural(strtolower($resource)); // 🎯 PLURALIZZAZIONE CORRETTA
        return "admin.{$plural}";
    }

    protected function getRoutePrefix(): string
    {
        if ($this->routePrefix) {
            return $this->routePrefix;
        }
        
        $controller = class_basename(static::class);
        $resource = str_replace('Controller', '', $controller);
        $plural = Str::plural(strtolower($resource)); // 🎯 PLURALIZZAZIONE CORRETTA
        return "admin.{$plural}";
    }

    public function index(Request $request)
    {
        $modelClass = $this->getModelClass();
        $query = $modelClass::query();

        // 🚀 EAGER LOADING DICHIARATIVO
        $this->applyEagerLoading($query, $modelClass);

        // 🔍 RICERCA CONFIGURABILE
        $this->applySearch($query, $request);

        // 📊 ORDINAMENTO CONFIGURABILE
        $this->applySorting($query, $request);

        $items = $query->paginate(12)->withQueryString();

        return request()->expectsJson() 
            ? response()->json($items)
            : view("{$this->getViewPrefix()}.index", $this->getIndexViewData($items));
    }

    public function create()
    {
        return view("{$this->getViewPrefix()}.create", $this->getCreateViewData());
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $modelClass = $this->getModelClass();
            $data = $this->validateRequest($request);
            
            // 🔗 GESTIONE RELAZIONI
            $relations = $this->extractRelations($data);
            
            $item = $modelClass::create($data);
            $this->syncRelations($item, $relations);
            
            return request()->expectsJson()
                ? response()->json($item->load($this->getLoadRelations()), 201)
                : redirect()->route("{$this->getRoutePrefix()}.index")->with('success', 'Elemento creato');
        });
    }

    // 🎯 ROUTE MODEL BINDING RISOLTO - USA ID ESPLICITO
    public function show($id)
    {
        $modelClass = $this->getModelClass();
        $model = $modelClass::with($this->getLoadRelations())->findOrFail($id);
        
        return request()->expectsJson()
            ? response()->json($model)
            : view("{$this->getViewPrefix()}.show", ['item' => $model]);
    }

    public function edit($id)
    {
        $modelClass = $this->getModelClass();
        $item = $modelClass::with($this->getLoadRelations())->findOrFail($id);
        
        return view("{$this->getViewPrefix()}.edit", $this->getEditViewData($item));
    }

    public function update(Request $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $modelClass = $this->getModelClass();
            $model = $modelClass::findOrFail($id);
            $data = $this->validateRequest($request, $model);
            
            // 🔗 GESTIONE RELAZIONI
            $relations = $this->extractRelations($data);
            
            $model->update($data);
            $this->syncRelations($model, $relations);

            return request()->expectsJson()
                ? response()->json($model->load($this->getLoadRelations()))
                : redirect()->route("{$this->getRoutePrefix()}.index")->with('success', 'Elemento aggiornato');
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $modelClass = $this->getModelClass();
            $model = $modelClass::findOrFail($id);
            
            // 🖼️ CLEANUP IMMAGINI CONFIGURABILE
            $this->cleanupImages($model);
            
            $model->delete();

            return request()->expectsJson()
                ? response()->noContent()
                : redirect()->route("{$this->getRoutePrefix()}.index")->with('success', 'Elemento eliminato');
        });
    }

    protected function validateRequest(Request $request, ?Model $model = null): array
    {
        // 📝 VALIDAZIONE BASE ESTENDIBILE
        $rules = array_merge([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ], $this->getValidationRules($request, $model));

        $data = $request->validate($rules);

        // 🏷️ SLUG CONDIZIONALE E UNICO
        $data = $this->handleSlugGeneration($data, $model);

        // 🖼️ GESTIONE IMMAGINI CONFIGURABILE
        if ($imagePath = $this->handleImageUpload($request, $model)) {
            $data[$this->imageField] = $imagePath;
        }

        return $data;
    }

    // 🚀 METODI DI SUPPORTO CONFIGURABILI

    protected function applyEagerLoading($query, string $modelClass): void
    {
        foreach ($this->eagerLoadRelations as $relation) {
            $relationName = explode(':', $relation)[0];
            if (method_exists($modelClass, $relationName)) {
                $query->with($relation);
            }
        }
    }

    protected function applySearch($query, Request $request): void
    {
        if ($request->filled('search')) {
            $term = "%{$request->search}%";
            $query->where(function($q) use ($term) {
                foreach ($this->searchableFields as $field) {
                    $q->orWhere($field, 'like', $term);
                }
            });
        }
    }

    protected function applySorting($query, Request $request): void
    {
        $sort = $request->get('sort', 'latest');
        
        match($sort) {
            'latest' => $query->latest(),
            default => $this->applySortField($query, $sort)
        };
    }

    protected function applySortField($query, string $sort): void
    {
        [$field, $direction] = array_pad(explode('_', $sort), 2, 'asc');
        
        if (in_array($field, $this->sortableFields)) {
            $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'asc';
            $query->orderBy($field, $direction);
        } else {
            $query->latest();
        }
    }

    protected function handleSlugGeneration(array $data, ?Model $model = null): array
    {
        if (!isset($data['name'])) {
            return $data;
        }

        $modelClass = $this->getModelClass();
        $table = (new $modelClass)->getTable();
        
        // 🎯 CONTROLLA SE COLONNA SLUG ESISTE
        if (!Schema::hasColumn($table, 'slug')) {
            return $data;
        }

        $baseSlug = Str::slug($data['name']);
        $slug = $baseSlug;
        $counter = 1;

        // 🔄 SLUG UNICO
        while (true) {
            $query = $modelClass::where('slug', $slug);
            
            // Esclude il record corrente se in update
            if ($model) {
                $query->where($model->getKeyName(), '!=', $model->getKey());
            }
            
            if (!$query->exists()) {
                break;
            }
            
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $data['slug'] = $slug;
        return $data;
    }

    protected function extractRelations(array &$data): array
    {
        $relations = [];
        
        foreach ($this->manyToManyRelations as $field) {
            if (isset($data[$field])) {
                $relations[$field] = $data[$field];
                unset($data[$field]);
            }
        }
        
        return $relations;
    }

    protected function syncRelations(Model $model, array $relations): void
    {
        foreach ($relations as $relationName => $ids) {
            if (method_exists($model, $relationName) && is_array($ids)) {
                $model->{$relationName}()->sync($ids);
            }
        }
    }

    protected function handleImageUpload(Request $request, ?Model $model = null): ?string
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        // 🗑️ CLEANUP IMMAGINE PRECEDENTE
        if ($model && $model->{$this->imageField}) {
            Storage::disk($this->imageDisk)->delete($model->{$this->imageField});
        }

        // 📁 CARTELLA CONFIGURABILE
        $folder = $this->uploadFolder ?: $this->getDefaultUploadFolder();

        return $request->file('image')->store($folder, $this->imageDisk);
    }

    protected function cleanupImages(Model $model): void
    {
        if ($model->{$this->imageField}) {
            Storage::disk($this->imageDisk)->delete($model->{$this->imageField});
        }
    }

    protected function getDefaultUploadFolder(): string
    {
        $controller = class_basename(static::class);
        $resource = str_replace('Controller', '', $controller);
        return Str::plural(strtolower($resource)); // categories, pizzas, etc.
    }

    protected function getLoadRelations(): array
    {
        return array_map(fn($rel) => explode(':', $rel)[0], $this->eagerLoadRelations);
    }

    // 🔧 METODI ESTENDIBILI NEI CONTROLLER
    protected function getValidationRules(Request $request, ?Model $model = null): array
    {
        return []; // Override nei controller per regole specifiche
    }

    protected function getIndexViewData($items): array
    {
        // Override per passare variabili personalizzate alla view index
        return compact('items');
    }

    protected function getCreateViewData(): array
    {
        // Override per passare variabili personalizzate alla view create
        return [];
    }

    protected function getEditViewData($item): array
    {
        // Override per passare variabili personalizzate alla view edit
        return compact('item');
    }
}