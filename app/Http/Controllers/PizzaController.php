<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Allergen;
use App\Support\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PizzaController extends Controller
{
    // 📋 Mostra tutte le pizze
    public function index(Request $request)
    {
        $pizzas = Pizza::with('category', 'ingredients');
        
        // 🔍 Cerca per nome
        if ($request->search) {
            $pizzas->where('name', 'like', "%{$request->search}%");
        }
        
        // 📊 Ordina per nome
        $pizzas->orderBy('name');
        
        return view('admin.pizzas.index', [
            'pizzas' => $pizzas->paginate(10)
        ]);
    }
    
    // ➕ Form per creare nuova pizza
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        $allergens = Allergen::orderBy('name')->get();
        
        return view('admin.pizzas.create', compact('categories', 'ingredients', 'allergens'));
    }
    
    // 💾 Salva nuova pizza
    public function store(Request $request)
    {
        // ✅ Controlla che i dati siano corretti
        $request->validate([
            'name' => 'required|max:255|unique:pizzas',
            'description' => 'nullable',
            'notes' => 'nullable',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
            'manual_allergens' => 'array',
            'manual_allergens.*' => 'exists:allergens,id',
            'is_vegan' => 'boolean',
            'image' => 'nullable|image|max:2048'
        ]);
        
        // 📝 Crea la pizza
        $pizza = Pizza::create([
            'name' => $request->name,
            'description' => $request->description,
            'notes' => $request->notes,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'is_vegan' => $request->boolean('is_vegan'),
            'manual_allergens' => $request->manual_allergens ?? [],
            'slug' => SlugService::unique(new Pizza(), $request->name),
            'image_path' => $request->hasFile('image') ? $request->file('image')->store('pizzas', 'public') : null
        ]);
        
        // 🔗 Collega gli ingredienti
        if ($request->ingredients) {
            $pizza->ingredients()->sync($request->ingredients);
        }
        
        return redirect()->route('pizzas.index')
                        ->with('success', 'Pizza creata!');
    }
    
    // 👁️ Mostra pizza specifica
    public function show(Pizza $pizza)
    {
        $pizza->load('category', 'ingredients');
        return view('admin.pizzas.show', compact('pizza'));
    }
    
    // ✏️ Form per modificare pizza
    public function edit(Pizza $pizza)
    {
        $categories = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        $allergens = Allergen::orderBy('name')->get();
        $pizza->load('category', 'ingredients');
        
        return view('admin.pizzas.edit', compact('pizza', 'categories', 'ingredients', 'allergens'));
    }
    
    // 🔄 Aggiorna pizza
    public function update(Request $request, Pizza $pizza)
    {
        // ✅ Controlla che i dati siano corretti
        $request->validate([
            'name' => 'required|max:255|unique:pizzas,name,' . $pizza->id,
            'description' => 'nullable',
            'notes' => 'nullable',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
            'manual_allergens' => 'array',
            'manual_allergens.*' => 'exists:allergens,id',
            'is_vegan' => 'boolean',
            'image' => 'nullable|image|max:2048'
        ]);
        
        // 🗑️ Elimina vecchia immagine se carica una nuova
        if ($request->hasFile('image') && $pizza->image_path) {
            Storage::disk('public')->delete($pizza->image_path);
        }
        
        // 📝 Aggiorna la pizza
        $pizza->update([
            'name' => $request->name,
            'description' => $request->description,
            'notes' => $request->notes,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'is_vegan' => $request->boolean('is_vegan'),
            'manual_allergens' => $request->manual_allergens ?? [],
            'slug' => $request->name !== $pizza->name ? SlugService::unique(new Pizza(), $request->name, $pizza->id) : $pizza->slug,
            'image_path' => $request->hasFile('image') ? $request->file('image')->store('pizzas', 'public') : $pizza->image_path
        ]);
        
        // 🔗 Aggiorna gli ingredienti
        $pizza->ingredients()->sync($request->ingredients ?? []);
        
        return redirect()->route('pizzas.index')
                        ->with('success', 'Pizza aggiornata!');
    }
    
    // 🗑️ Elimina pizza
    public function destroy(Pizza $pizza)
    {
        // 🗑️ Elimina immagine
        if ($pizza->image_path) {
            Storage::disk('public')->delete($pizza->image_path);
        }
        
        // 🔗 Rimuovi ingredienti
        $pizza->ingredients()->detach();
        
        // 🗑️ Elimina la pizza
        $pizza->delete();
        
        return redirect()->route('pizzas.index')
                        ->with('success', 'Pizza eliminata!');
    }
}
