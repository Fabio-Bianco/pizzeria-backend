<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Support\SlugService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 📋 Mostra tutte le categorie
    public function index(Request $request)
    {
        $categories = Category::query();
        
        // 🔍 Cerca per nome o descrizione
        if ($request->search) {
            $categories->where('name', 'like', "%{$request->search}%")
                      ->orWhere('description', 'like', "%{$request->search}%");
        }
        
        // 📊 Ordina i risultati
        $categories->orderBy('name');
        
        return view('admin.categories.index', [
            'categories' => $categories->paginate(10)
        ]);
    }
    
    // ➕ Mostra form per creare nuova categoria
    public function create()
    {
        return view('admin.categories.create');
    }
    
    // 💾 Salva nuova categoria
    public function store(Request $request)
    {
        // ✅ Controlla che i dati siano corretti
        $request->validate([
            'name' => 'required|max:255|unique:categories',
            'description' => 'nullable',
            'is_white' => 'boolean'
        ]);
        
        // 📝 Crea la categoria
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_white' => $request->boolean('is_white'),
            'slug' => SlugService::unique(new Category(), $request->name)
        ]);
        
        // ✅ Torna alla lista con messaggio di successo
        return redirect()->route('admin.categories.index')
                        ->with('success', 'Categoria creata!');
    }
    
    // 👁️ Mostra una categoria specifica
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }
    
    // ✏️ Mostra form per modificare categoria
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }
    
    // 🔄 Aggiorna categoria esistente
    public function update(Request $request, Category $category)
    {
        // ✅ Controlla che i dati siano corretti
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable',
            'is_white' => 'boolean'
        ]);
        
        // 📝 Aggiorna la categoria
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_white' => $request->boolean('is_white'),
            'slug' => $request->name !== $category->name 
                ? SlugService::unique(new Category(), $request->name, $category->id)
                : $category->slug
        ]);
        
        // ✅ Torna alla lista con messaggio di successo
        return redirect()->route('admin.categories.index')
                        ->with('success', 'Categoria aggiornata!');
    }
    
    // 🗑️ Elimina categoria
    public function destroy(Category $category)
    {
        // ⚠️ Controlla se ha pizze associate
        if ($category->pizzas()->count() > 0) {
            return back()->with('error', 'Non puoi eliminare una categoria con pizze!');
        }
        
        // 🗑️ Elimina la categoria
        $category->delete();
        
        // ✅ Torna alla lista con messaggio di successo
        return redirect()->route('admin.categories.index')
                        ->with('success', 'Categoria eliminata!');
    }
}
