<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Allergen;
use App\Support\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IngredientController extends Controller
{
    // 📋 Mostra tutti gli ingredienti
    public function index(Request $request)
    {
        $ingredients = Ingredient::with('allergens');
        
        // 🔍 Cerca per nome
        if ($request->search) {
            $ingredients->where('name', 'like', "%{$request->search}%");
        }
        
        // 📊 Ordina per nome
        $ingredients->orderBy('name');
        
        return view('admin.ingredients.index', [
            'ingredients' => $ingredients->paginate(10)
        ]);
    }
    
    // ➕ Form per nuovo ingrediente
    public function create()
    {
        $allergens = Allergen::orderBy('name')->get();
        return view('admin.ingredients.create', compact('allergens'));
    }
    
    // 💾 Salva nuovo ingrediente
    public function store(Request $request)
    {
        // ✅ Controlla che i dati siano corretti
        $request->validate([
            'name' => 'required|max:255|unique:ingredients',
            'description' => 'nullable',
            'is_tomato' => 'boolean',
            'allergens' => 'array',
            'allergens.*' => 'exists:allergens,id',
            'image' => 'nullable|image|max:2048'
        ]);
        
        // 📝 Crea l'ingrediente
        $ingredient = Ingredient::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_tomato' => $request->boolean('is_tomato'),
            'slug' => SlugService::unique(new Ingredient(), $request->name),
            'image' => $request->hasFile('image') ? $request->file('image')->store('ingredients', 'public') : null
        ]);
        
        // 🔗 Collega gli allergeni
        if ($request->allergens) {
            $ingredient->allergens()->sync($request->allergens);
        }
        
        return redirect()->route('ingredients.index')
                        ->with('success', 'Ingrediente creato!');
    }
    
    // 👁️ Mostra ingrediente specifico
    public function show(Ingredient $ingredient)
    {
        $ingredient->load('allergens');
        return view('admin.ingredients.show', compact('ingredient'));
    }
    
    // ✏️ Form per modificare ingrediente
    public function edit(Ingredient $ingredient)
    {
        $allergens = Allergen::orderBy('name')->get();
        $ingredient->load('allergens');
        
        return view('admin.ingredients.edit', compact('ingredient', 'allergens'));
    }
    
    // 🔄 Aggiorna ingrediente
    public function update(Request $request, Ingredient $ingredient)
    {
        // ✅ Controlla che i dati siano corretti
        $request->validate([
            'name' => 'required|max:255|unique:ingredients,name,' . $ingredient->id,
            'description' => 'nullable',
            'is_tomato' => 'boolean',
            'allergens' => 'array',
            'allergens.*' => 'exists:allergens,id',
            'image' => 'nullable|image|max:2048'
        ]);
        
        // 🗑️ Elimina vecchia immagine se carica una nuova
        if ($request->hasFile('image') && $ingredient->image) {
            Storage::disk('public')->delete($ingredient->image);
        }
        
        // 📝 Aggiorna l'ingrediente
        $ingredient->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_tomato' => $request->boolean('is_tomato'),
            'slug' => $request->name !== $ingredient->name ? SlugService::unique(new Ingredient(), $request->name, $ingredient->id) : $ingredient->slug,
            'image' => $request->hasFile('image') ? $request->file('image')->store('ingredients', 'public') : $ingredient->image
        ]);
        
        // 🔗 Aggiorna gli allergeni
        $ingredient->allergens()->sync($request->allergens ?? []);
        
        return redirect()->route('ingredients.index')
                        ->with('success', 'Ingrediente aggiornato!');
    }
    
    // 🗑️ Elimina ingrediente
    public function destroy(Ingredient $ingredient)
    {
        // ⚠️ Controlla se è usato in ricette
        if ($ingredient->pizzas()->count() > 0 || $ingredient->appetizers()->count() > 0 || $ingredient->desserts()->count() > 0) {
            return back()->with('error', 'Non puoi eliminare un ingrediente usato in ricette!');
        }
        
        // 🗑️ Elimina immagine
        if ($ingredient->image) {
            Storage::disk('public')->delete($ingredient->image);
        }
        
        // 🔗 Rimuovi allergeni
        $ingredient->allergens()->detach();
        
        // 🗑️ Elimina l'ingrediente
        $ingredient->delete();
        
        return redirect()->route('ingredients.index')
                        ->with('success', 'Ingrediente eliminato!');
    }
    
    // 💬 Ottieni allergeni per ingredienti specifici (AJAX)
    public function getAllergensForIngredients(Request $request)
    {
        $ingredientIds = $request->ingredient_ids ?? [];
        
        if (empty($ingredientIds)) {
            return response()->json(['allergens' => []]);
        }
        
        $allergens = Allergen::whereHas('ingredients', function ($query) use ($ingredientIds) {
            $query->whereIn('ingredients.id', $ingredientIds);
        })->get(['id', 'name']);
        
        return response()->json(['allergens' => $allergens]);
    }
}
