<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Allergen;
use App\Support\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class IngredientController extends Controller
{
    /**
     * Display a listing of the ingredients.
     */
    public function index(Request $request)
    {
        // Base query with allergens relationship
        $query = Ingredient::with('allergens:id,name');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Sorting
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        
        if (in_array($sortField, ['name', 'created_at'])) {
            $query->orderBy($sortField, $sortDirection);
        }
        
        // Pagination
        $ingredients = $query->paginate(10);
        
        // Return appropriate response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $ingredients
            ]);
        }
        
        return view('ingredients.index', compact('ingredients'));
    }
    
    /**
     * Show the form for creating a new ingredient.
     */
    public function create()
    {
        $allergens = Allergen::orderBy('name')->get();
        return view('ingredients.create', compact('allergens'));
    }
    
    /**
     * Store a newly created ingredient in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name',
            'description' => 'nullable|string',
            'is_tomato' => 'boolean',
            'allergens' => 'array',
            'allergens.*' => 'exists:allergens,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        try {
            // Prepare data
            $data = $request->only(['name', 'description', 'is_tomato']);
            $data['slug'] = SlugService::unique(new Ingredient(), $data['name']);
            $data['is_tomato'] = $request->boolean('is_tomato');
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('ingredients', 'public');
            }
            
            // Create ingredient
            $ingredient = Ingredient::create($data);
            
            // Sync allergens relationship
            if ($request->filled('allergens')) {
                $ingredient->allergens()->sync($request->get('allergens'));
            }
            
            // Success response
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ingrediente creato con successo.',
                    'data' => $ingredient->load('allergens')
                ], 201);
            }
            
            return redirect()->route('ingredients.index')
                           ->with('success', 'Ingrediente creato con successo.');
                           
        } catch (\Exception $e) {
            Log::error('Errore nella creazione ingrediente: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errore nella creazione dell\'ingrediente.'
                ], 500);
            }
            
            return back()->withInput()
                        ->with('error', 'Errore nella creazione dell\'ingrediente.');
        }
    }
    
    /**
     * Display the specified ingredient.
     */
    public function show(Ingredient $ingredient)
    {
        $ingredient->load('allergens');
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $ingredient
            ]);
        }
        
        return view('ingredients.show', compact('ingredient'));
    }
    
    /**
     * Show the form for editing the specified ingredient.
     */
    public function edit(Ingredient $ingredient)
    {
        $allergens = Allergen::orderBy('name')->get();
        $ingredient->load('allergens');
        
        return view('ingredients.edit', compact('ingredient', 'allergens'));
    }
    
    /**
     * Update the specified ingredient in storage.
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name,' . $ingredient->id,
            'description' => 'nullable|string',
            'is_tomato' => 'boolean',
            'allergens' => 'array',
            'allergens.*' => 'exists:allergens,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        try {
            // Prepare data
            $data = $request->only(['name', 'description', 'is_tomato']);
            $data['is_tomato'] = $request->boolean('is_tomato');
            
            // Update slug if name changed
            if ($data['name'] !== $ingredient->name) {
                $data['slug'] = SlugService::unique(new Ingredient(), $data['name'], $ingredient->id);
            }
            
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($ingredient->image) {
                    Storage::disk('public')->delete($ingredient->image);
                }
                $data['image'] = $request->file('image')->store('ingredients', 'public');
            }
            
            // Update ingredient
            $ingredient->update($data);
            
            // Sync allergens relationship
            if ($request->filled('allergens')) {
                $ingredient->allergens()->sync($request->get('allergens'));
            } else {
                $ingredient->allergens()->sync([]);
            }
            
            // Success response
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ingrediente aggiornato con successo.',
                    'data' => $ingredient->fresh()->load('allergens')
                ]);
            }
            
            return redirect()->route('ingredients.index')
                           ->with('success', 'Ingrediente aggiornato con successo.');
                           
        } catch (\Exception $e) {
            Log::error('Errore nell\'aggiornamento ingrediente: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errore nell\'aggiornamento dell\'ingrediente.'
                ], 500);
            }
            
            return back()->withInput()
                        ->with('error', 'Errore nell\'aggiornamento dell\'ingrediente.');
        }
    }
    
    /**
     * Remove the specified ingredient from storage.
     */
    public function destroy(Ingredient $ingredient)
    {
        try {
            // Check if ingredient has associated pizzas/appetizers/desserts
            $pizzasCount = $ingredient->pizzas()->count();
            $appetizersCount = $ingredient->appetizers()->count();
            $dessertsCount = $ingredient->desserts()->count();
            
            if ($pizzasCount > 0 || $appetizersCount > 0 || $dessertsCount > 0) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Impossibile eliminare: l\'ingrediente è utilizzato in delle ricette.'
                    ], 422);
                }
                
                return back()->with('error', 'Impossibile eliminare: l\'ingrediente è utilizzato in delle ricette.');
            }
            
            // Delete image if exists
            if ($ingredient->image) {
                Storage::disk('public')->delete($ingredient->image);
            }
            
            // Delete relationships
            $ingredient->allergens()->detach();
            
            // Delete ingredient
            $ingredient->delete();
            
            // Success response
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ingrediente eliminato con successo.'
                ]);
            }
            
            return redirect()->route('ingredients.index')
                           ->with('success', 'Ingrediente eliminato con successo.');
                           
        } catch (\Exception $e) {
            Log::error('Errore nell\'eliminazione ingrediente: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errore nell\'eliminazione dell\'ingrediente.'
                ], 500);
            }
            
            return back()->with('error', 'Errore nell\'eliminazione dell\'ingrediente.');
        }
    }
    
    /**
     * AJAX endpoint for intelligent forms - get allergens for specific ingredients
     */
    public function getAllergensForIngredients(Request $request)
    {
        $ingredientIds = $request->input('ingredient_ids', []);
        
        if (empty($ingredientIds)) {
            return response()->json(['allergens' => []]);
        }
        
        $allergens = Allergen::whereHas('ingredients', function ($query) use ($ingredientIds) {
            $query->whereIn('ingredients.id', $ingredientIds);
        })->get(['id', 'name'])->unique('id');
        
        return response()->json(['allergens' => $allergens]);
    }
}
