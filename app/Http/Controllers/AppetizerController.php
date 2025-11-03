<?php

namespace App\Http\Controllers;

use App\Models\Appetizer;
use App\Models\Ingredient;
use App\Support\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AppetizerController extends Controller
{
    /**
     * Display a listing of the appetizers.
     */
    public function index(Request $request)
    {
        $query = Appetizer::with('ingredients:id,name');
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        
        if (in_array($sortField, ['name', 'price', 'created_at'])) {
            $query->orderBy($sortField, $sortDirection);
        }
        
        $appetizers = $query->paginate(10);
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'data' => $appetizers]);
        }
        
        return view('appetizers.index', compact('appetizers'));
    }
    
    public function create()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        return view('appetizers.create', compact('ingredients'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:appetizers,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
            'is_gluten_free' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        try {
            $data = $request->only(['name', 'description', 'price', 'is_gluten_free']);
            $data['slug'] = SlugService::unique(new Appetizer(), $data['name']);
            $data['is_gluten_free'] = $request->boolean('is_gluten_free');
            
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('appetizers', 'public');
            }
            
            $appetizer = Appetizer::create($data);
            
            if ($request->filled('ingredients')) {
                $appetizer->ingredients()->sync($request->get('ingredients'));
            }
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Antipasto creato con successo.',
                    'data' => $appetizer->load('ingredients')
                ], 201);
            }
            
            return redirect()->route('appetizers.index')
                           ->with('success', 'Antipasto creato con successo.');
                           
        } catch (\Exception $e) {
            Log::error('Errore nella creazione antipasto: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Errore nella creazione dell\'antipasto.'], 500);
            }
            
            return back()->withInput()->with('error', 'Errore nella creazione dell\'antipasto.');
        }
    }
    
    public function show(Appetizer $appetizer)
    {
        $appetizer->load('ingredients');
        
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'data' => $appetizer]);
        }
        
        return view('appetizers.show', compact('appetizer'));
    }
    
    public function edit(Appetizer $appetizer)
    {
        $ingredients = Ingredient::orderBy('name')->get();
        $appetizer->load('ingredients');
        
        return view('appetizers.edit', compact('appetizer', 'ingredients'));
    }
    
    public function update(Request $request, Appetizer $appetizer)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:appetizers,name,' . $appetizer->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
            'is_gluten_free' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        try {
            $data = $request->only(['name', 'description', 'price', 'is_gluten_free']);
            $data['is_gluten_free'] = $request->boolean('is_gluten_free');
            
            if ($data['name'] !== $appetizer->name) {
                $data['slug'] = SlugService::unique(new Appetizer(), $data['name'], $appetizer->id);
            }
            
            if ($request->hasFile('image')) {
                if ($appetizer->image) {
                    Storage::disk('public')->delete($appetizer->image);
                }
                $data['image'] = $request->file('image')->store('appetizers', 'public');
            }
            
            $appetizer->update($data);
            
            if ($request->filled('ingredients')) {
                $appetizer->ingredients()->sync($request->get('ingredients'));
            } else {
                $appetizer->ingredients()->sync([]);
            }
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Antipasto aggiornato con successo.',
                    'data' => $appetizer->fresh()->load('ingredients')
                ]);
            }
            
            return redirect()->route('appetizers.index')
                           ->with('success', 'Antipasto aggiornato con successo.');
                           
        } catch (\Exception $e) {
            Log::error('Errore nell\'aggiornamento antipasto: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Errore nell\'aggiornamento dell\'antipasto.'], 500);
            }
            
            return back()->withInput()->with('error', 'Errore nell\'aggiornamento dell\'antipasto.');
        }
    }
    
    public function destroy(Appetizer $appetizer)
    {
        try {
            if ($appetizer->image) {
                Storage::disk('public')->delete($appetizer->image);
            }
            
            $appetizer->ingredients()->detach();
            $appetizer->delete();
            
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Antipasto eliminato con successo.']);
            }
            
            return redirect()->route('appetizers.index')
                           ->with('success', 'Antipasto eliminato con successo.');
                           
        } catch (\Exception $e) {
            Log::error('Errore nell\'eliminazione antipasto: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Errore nell\'eliminazione dell\'antipasto.'], 500);
            }
            
            return back()->with('error', 'Errore nell\'eliminazione dell\'antipasto.');
        }
    }
}