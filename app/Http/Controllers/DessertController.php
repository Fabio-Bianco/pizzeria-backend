<?php

namespace App\Http\Controllers;

use App\Models\Dessert;
use App\Models\Ingredient;
use App\Support\SlugService;
use Illuminate\Http\Request;

class DessertController extends Controller
{
    // 📋 Mostra tutti i dolci
    public function index(Request $request)
    {
        $desserts = Dessert::with('ingredients');
        
        // 🔍 Cerca per nome
        if ($request->search) {
            $desserts->where('name', 'like', "%{$request->search}%");
        }
        
        // 📊 Ordina per nome
        $desserts->orderBy('name');
        
        return view('admin.desserts.index', [
            'desserts' => $desserts->paginate(10)
        ]);
    }
    
    // ➕ Form per nuovo dolce
    public function create()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        return view('admin.desserts.create', compact('ingredients'));
    }
    
    // 💾 Salva nuovo dolce
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:desserts',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
            'is_gluten_free' => 'boolean',
            'is_vegan' => 'boolean'
        ]);
        
        // 📝 Crea il dolce
        $dessert = Dessert::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'is_gluten_free' => $request->boolean('is_gluten_free'),
            'is_vegan' => $request->boolean('is_vegan'),
            'slug' => SlugService::unique(new Dessert(), $request->name)
        ]);
        
        // 🔗 Collega gli ingredienti
        if ($request->ingredients) {
            $dessert->ingredients()->sync($request->ingredients);
        }
        
        return redirect()->route('desserts.index')
                        ->with('success', 'Dolce creato!');
    }
    
    // 👁️ Mostra dolce specifico
    public function show(Dessert $dessert)
    {
        $dessert->load('ingredients');
        return view('admin.desserts.show', compact('dessert'));
    }
    
    // ✏️ Form per modificare dolce
    public function edit(Dessert $dessert)
    {
        $ingredients = Ingredient::orderBy('name')->get();
        $dessert->load('ingredients');
        return view('admin.desserts.edit', compact('dessert', 'ingredients'));
    }
    
    // 🔄 Aggiorna dolce
    public function update(Request $request, Dessert $dessert)
    {
        $request->validate([
            'name' => 'required|max:255|unique:desserts,name,' . $dessert->id,
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
            'is_gluten_free' => 'boolean',
            'is_vegan' => 'boolean'
        ]);
        
        // 📝 Aggiorna il dolce
        $dessert->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'is_gluten_free' => $request->boolean('is_gluten_free'),
            'is_vegan' => $request->boolean('is_vegan'),
            'slug' => $request->name !== $dessert->name 
                ? SlugService::unique(new Dessert(), $request->name, $dessert->id)
                : $dessert->slug
        ]);
        
        // 🔗 Aggiorna gli ingredienti
        $dessert->ingredients()->sync($request->ingredients ?? []);
        
        return redirect()->route('desserts.index')
                        ->with('success', 'Dolce aggiornato!');
    }
    
    // 🗑️ Elimina dolce
    public function destroy(Dessert $dessert)
    {
        // 🔗 Rimuovi collegamenti ingredienti
        $dessert->ingredients()->detach();
        
        // 🗑️ Elimina il dolce
        $dessert->delete();
        
        return redirect()->route('desserts.index')
                        ->with('success', 'Dolce eliminato!');
    }
}