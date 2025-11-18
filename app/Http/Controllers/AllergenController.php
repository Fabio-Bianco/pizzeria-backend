<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use App\Support\SlugService;
use Illuminate\Http\Request;

class AllergenController extends Controller
{
    // 📋 Mostra tutti gli allergeni
    public function index(Request $request)
    {
        $allergens = Allergen::query();
        
        // 🔍 Cerca per nome
        if ($request->search) {
            $allergens->where('name', 'like', "%{$request->search}%");
        }
        
        // 📊 Ordina per nome
        $allergens->orderBy('name');
        
        return view('admin.allergens.index', [
            'allergens' => $allergens->paginate(10)
        ]);
    }
    
    // ➕ Form per nuovo allergene
    public function create()
    {
        return view('admin.allergens.create');
    }
    
    // 💾 Salva nuovo allergene
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:allergens',
            'description' => 'nullable',
            'icon' => 'nullable|max:255'
        ]);
        
        Allergen::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'slug' => SlugService::unique(new Allergen(), $request->name)
        ]);
        
        return redirect()->route('admin.allergens.index')
                        ->with('success', 'Allergene creato!');
    }
    
    // 👁️ Mostra allergene specifico
    public function show(Allergen $allergen)
    {
        return view('admin.allergens.show', compact('allergen'));
    }
    
    // ✏️ Form per modificare allergene
    public function edit(Allergen $allergen)
    {
        return view('admin.allergens.edit', compact('allergen'));
    }
    
    // 🔄 Aggiorna allergene
    public function update(Request $request, Allergen $allergen)
    {
        $request->validate([
            'name' => 'required|max:255|unique:allergens,name,' . $allergen->id,
            'description' => 'nullable',
            'icon' => 'nullable|max:255'
        ]);
        
        $allergen->update([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'slug' => $request->name !== $allergen->name 
                ? SlugService::unique(new Allergen(), $request->name, $allergen->id)
                : $allergen->slug
        ]);
        
        return redirect()->route('admin.allergens.index')
                        ->with('success', 'Allergene aggiornato!');
    }
    
    // 🗑️ Elimina allergene
    public function destroy(Allergen $allergen)
    {
        // ⚠️ Controlla se è usato da ingredienti
        if ($allergen->ingredients()->count() > 0) {
            return back()->with('error', 'Non puoi eliminare un allergene usato da ingredienti!');
        }
        
        $allergen->delete();
        
        return redirect()->route('admin.allergens.index')
                        ->with('success', 'Allergene eliminato!');
    }
}
