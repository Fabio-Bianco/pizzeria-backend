<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Allergen;
use App\Support\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PizzaController extends Controller
{
    /**
     * Display a listing of the pizzas.
     */
    public function index(Request $request)
    {
        // Base query with relationships
        $query = Pizza::with(['category:id,name', 'ingredients:id,name']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }
        
        // Sorting
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        
        if (in_array($sortField, ['name', 'price', 'created_at'])) {
            $query->orderBy($sortField, $sortDirection);
        }
        
        // Pagination
        $pizzas = $query->paginate(10);
        
        // Return appropriate response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $pizzas
            ]);
        }
        
        return view('admin.pizzas.index', compact('pizzas'));
    }
    
    /**
     * Show the form for creating a new pizza.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        $allergens = Allergen::orderBy('name')->get();
        
        return view('admin.pizzas.create', compact('categories', 'ingredients', 'allergens'));
    }
    
    /**
     * Store a newly created pizza in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255|unique:pizzas,name',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
            'manual_allergens' => 'array',
            'manual_allergens.*' => 'exists:allergens,id',
            'is_vegan' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        try {
            // Prepare data
            $data = $request->only(['name', 'description', 'notes', 'price', 'category_id', 'is_vegan']);
            $data['slug'] = SlugService::unique(new Pizza(), $data['name']);
            $data['is_vegan'] = $request->boolean('is_vegan');
            $data['manual_allergens'] = $request->get('manual_allergens', []);
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image_path'] = $request->file('image')->store('pizzas', 'public');
            }
            
            // Create pizza
            $pizza = Pizza::create($data);
            
            // Sync ingredients relationship
            if ($request->filled('ingredients')) {
                $pizza->ingredients()->sync($request->get('ingredients'));
            }
            
            // Success response
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pizza creata con successo.',
                    'data' => $pizza->load(['category', 'ingredients'])
                ], 201);
            }
            
            return redirect()->route('pizzas.index')
                           ->with('success', 'Pizza creata con successo.');
                           
        } catch (\Exception $e) {
            Log::error('Errore nella creazione pizza: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errore nella creazione della pizza.'
                ], 500);
            }
            
            return back()->withInput()
                        ->with('error', 'Errore nella creazione della pizza.');
        }
    }
    
    /**
     * Display the specified pizza.
     */
    public function show(Pizza $pizza)
    {
        $pizza->load(['category', 'ingredients']);
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $pizza
            ]);
        }
        
        return view('admin.pizzas.show', compact('pizza'));
    }
    
    /**
     * Show the form for editing the specified pizza.
     */
    public function edit(Pizza $pizza)
    {
        $categories = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        $allergens = Allergen::orderBy('name')->get();
        $pizza->load(['category', 'ingredients']);
        
        return view('admin.pizzas.edit', compact('pizza', 'categories', 'ingredients', 'allergens'));
    }
    
    /**
     * Update the specified pizza in storage.
     */
    public function update(Request $request, Pizza $pizza)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255|unique:pizzas,name,' . $pizza->id,
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
            'manual_allergens' => 'array',
            'manual_allergens.*' => 'exists:allergens,id',
            'is_vegan' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        try {
            // Prepare data
            $data = $request->only(['name', 'description', 'notes', 'price', 'category_id', 'is_vegan']);
            $data['is_vegan'] = $request->boolean('is_vegan');
            $data['manual_allergens'] = $request->get('manual_allergens', []);
            
            // Update slug if name changed
            if ($data['name'] !== $pizza->name) {
                $data['slug'] = SlugService::unique(new Pizza(), $data['name'], $pizza->id);
            }
            
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($pizza->image_path) {
                    Storage::disk('public')->delete($pizza->image_path);
                }
                $data['image_path'] = $request->file('image')->store('pizzas', 'public');
            }
            
            // Update pizza
            $pizza->update($data);
            
            // Sync ingredients relationship
            if ($request->filled('ingredients')) {
                $pizza->ingredients()->sync($request->get('ingredients'));
            } else {
                $pizza->ingredients()->sync([]);
            }
            
            // Success response
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pizza aggiornata con successo.',
                    'data' => $pizza->fresh()->load(['category', 'ingredients'])
                ]);
            }
            
            return redirect()->route('pizzas.index')
                           ->with('success', 'Pizza aggiornata con successo.');
                           
        } catch (\Exception $e) {
            Log::error('Errore nell\'aggiornamento pizza: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errore nell\'aggiornamento della pizza.'
                ], 500);
            }
            
            return back()->withInput()
                        ->with('error', 'Errore nell\'aggiornamento della pizza.');
        }
    }
    
    /**
     * Remove the specified pizza from storage.
     */
    public function destroy(Pizza $pizza)
    {
        try {
            // Delete image if exists
            if ($pizza->image_path) {
                Storage::disk('public')->delete($pizza->image_path);
            }
            
            // Delete relationships
            $pizza->ingredients()->detach();
            
            // Delete pizza
            $pizza->delete();
            
            // Success response
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pizza eliminata con successo.'
                ]);
            }
            
            return redirect()->route('pizzas.index')
                           ->with('success', 'Pizza eliminata con successo.');
                           
        } catch (\Exception $e) {
            Log::error('Errore nell\'eliminazione pizza: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errore nell\'eliminazione della pizza.'
                ], 500);
            }
            
            return back()->with('error', 'Errore nell\'eliminazione della pizza.');
        }
    }
}
