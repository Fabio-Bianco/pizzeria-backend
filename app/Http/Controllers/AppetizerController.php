<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use App\Models\Appetizer;
use App\Models\Ingredient;
use App\Support\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppetizerController extends Controller
{
    // 📋 Mostra tutti gli antipasti
    public function index(Request $request)
    {
        $appetizers = Appetizer::with('ingredients');
        
        // 🔍 Cerca per nome
        if ($request->search) {
            $appetizers->where('name', 'like', "%{$request->search}%");
        }
        
        // 📊 Ordina per nome
        $appetizers->orderBy('name');
        
        return view('admin.appetizers.index', [
            'appetizers' => $appetizers->paginate(10)
        ]);
    }
    
    public function create()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        return view('admin.appetizers.create', compact('ingredients'));
    }
    
    // 💾 Salva nuovo antipasto
    public function store(Request $request)
    {
        // ✅ Controlla che i dati siano corretti
        $request->validate([
            'name' => 'required|max:255|unique:appetizers',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
            'is_gluten_free' => 'boolean',
            'image' => 'nullable|image|max:2048'
        ]);
        
        // 📝 Crea l'antipasto
        $appetizer = Appetizer::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'is_gluten_free' => $request->boolean('is_gluten_free'),
            'slug' => SlugService::unique(new Appetizer(), $request->name),
            'image' => $request->hasFile('image') ? $request->file('image')->store('appetizers', 'public') : null
        ]);
        
        // 🔗 Collega gli ingredienti
        if ($request->ingredients) {
            $appetizer->ingredients()->sync($request->ingredients);
        }
        
        return redirect()->route('appetizers.index')
                        ->with('success', 'Antipasto creato!');
    }
    
    // 👁️ Mostra antipasto specifico
    public function show(Appetizer $appetizer)
    {
        $appetizer->load('ingredients');
        return view('admin.appetizers.show', compact('appetizer'));
    }
    
    public function edit(Appetizer $appetizer)
    {
        $ingredients = Ingredient::orderBy('name')->get();
        $allergens = Allergen::orderBy('name')->get();
        $appetizer->load('ingredients');
        
        return view('admin.appetizers.edit', compact('appetizer', 'ingredients', 'allergens'));
    }
    
    // 🔄 Aggiorna antipasto
    public function update(Request $request, Appetizer $appetizer)
    {
        // ✅ Controlla che i dati siano corretti
        $request->validate([
            'name' => 'required|max:255|unique:appetizers,name,' . $appetizer->id,
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
            'is_gluten_free' => 'boolean',
            'image' => 'nullable|image|max:2048'
        ]);
        
        // 🗑️ Elimina vecchia immagine se carica una nuova
        if ($request->hasFile('image') && $appetizer->image) {
            Storage::disk('public')->delete($appetizer->image);
        }
        
        // 📝 Aggiorna l'antipasto
        $appetizer->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'is_gluten_free' => $request->boolean('is_gluten_free'),
            'slug' => $request->name !== $appetizer->name ? SlugService::unique(new Appetizer(), $request->name, $appetizer->id) : $appetizer->slug,
            'image' => $request->hasFile('image') ? $request->file('image')->store('appetizers', 'public') : $appetizer->image
        ]);
        
        // 🔗 Aggiorna gli ingredienti
        $appetizer->ingredients()->sync($request->ingredients ?? []);
        
        return redirect()->route('appetizers.index')
                        ->with('success', 'Antipasto aggiornato!');
    }
    
    // 🗑️ Elimina antipasto
    public function destroy(Appetizer $appetizer)
    {
        // 🗑️ Elimina immagine
        if ($appetizer->image) {
            Storage::disk('public')->delete($appetizer->image);
        }
        
        // 🔗 Rimuovi ingredienti
        $appetizer->ingredients()->detach();
        
        // 🗑️ Elimina l'antipasto
        $appetizer->delete();
        
        return redirect()->route('appetizers.index')
                        ->with('success', 'Antipasto eliminato!');
    }
}