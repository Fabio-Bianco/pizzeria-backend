<?php

namespace App\Http\Controllers;

use App\Models\Beverage;
use App\Support\SlugService;
use Illuminate\Http\Request;

class BeverageController extends Controller
{
    // 📋 Mostra tutte le bevande
    public function index(Request $request)
    {
        $beverages = Beverage::query();
        
        // 🔍 Cerca per nome o categoria
        if ($request->search) {
            $beverages->where('name', 'like', "%{$request->search}%")
                     ->orWhere('category', 'like', "%{$request->search}%");
        }
        
        // 📊 Ordina per nome
        $beverages->orderBy('name');
        
        return view('beverages.index', [
            'beverages' => $beverages->paginate(10)
        ]);
    }
    
    // ➕ Form per nuova bevanda
    public function create()
    {
        return view('beverages.create');
    }
    
    // 💾 Salva nuova bevanda
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:beverages',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|max:255',
            'is_alcoholic' => 'boolean'
        ]);
        
        Beverage::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'is_alcoholic' => $request->boolean('is_alcoholic'),
            'slug' => SlugService::unique(new Beverage(), $request->name)
        ]);
        
        return redirect()->route('beverages.index')
                        ->with('success', 'Bevanda creata!');
    }
    
    // 👁️ Mostra bevanda specifica
    public function show(Beverage $beverage)
    {
        return view('beverages.show', compact('beverage'));
    }
    
    // ✏️ Form per modificare bevanda
    public function edit(Beverage $beverage)
    {
        return view('beverages.edit', compact('beverage'));
    }
    
    // 🔄 Aggiorna bevanda
    public function update(Request $request, Beverage $beverage)
    {
        $request->validate([
            'name' => 'required|max:255|unique:beverages,name,' . $beverage->id,
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|max:255',
            'is_alcoholic' => 'boolean'
        ]);
        
        $beverage->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'is_alcoholic' => $request->boolean('is_alcoholic'),
            'slug' => $request->name !== $beverage->name 
                ? SlugService::unique(new Beverage(), $request->name, $beverage->id)
                : $beverage->slug
        ]);
        
        return redirect()->route('beverages.index')
                        ->with('success', 'Bevanda aggiornata!');
    }
    
    // 🗑️ Elimina bevanda
    public function destroy(Beverage $beverage)
    {
        $beverage->delete();
        
        return redirect()->route('beverages.index')
                        ->with('success', 'Bevanda eliminata!');
    }
}