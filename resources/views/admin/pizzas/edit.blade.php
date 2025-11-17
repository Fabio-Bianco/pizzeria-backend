@extends('layouts.app-modern')

@section('header')
    <h3 class="fw-semibold text-center mb-0">
        <i data-lucide="pencil" style="width: 24px; height: 24px; vertical-align: -4px;"></i>
        Modifica Pizza
    </h3>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <form action="{{ route('admin.pizzas.update', $pizza) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Informazioni Base -->
                <div class="card border mb-4" style="border-color: #e5e7eb !important;">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-4">Informazioni Base</h6>

                        <div class="mb-3">
                            <label for="name" class="form-label small text-muted mb-1">Nome Pizza</label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $pizza->name) }}" 
                                required 
                                autofocus
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label small text-muted mb-1">Prezzo (€)</label>
                            <input 
                                type="number" 
                                step="0.01" 
                                class="form-control @error('price') is-invalid @enderror" 
                                id="price" 
                                name="price" 
                                value="{{ old('price', $pizza->price) }}" 
                                required
                            >
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label small text-muted mb-1">Categoria</label>
                            <select 
                                class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" 
                                name="category_id" 
                                required
                            >
                                <option value="">Seleziona categoria...</option>
                                @foreach($categories as $category)
                                    <option 
                                        value="{{ $category->id }}" 
                                        data-is-white="{{ $category->is_white ? '1' : '0' }}"
                                        {{ old('category_id', $pizza->category_id) == $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label small text-muted mb-1">Note</label>
                            <textarea 
                                class="form-control @error('notes') is-invalid @enderror" 
                                id="notes" 
                                name="notes" 
                                rows="3"
                            >{{ old('notes', $pizza->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label small text-muted mb-1">Immagine</label>
                            @if($pizza->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $pizza->image) }}" alt="{{ $pizza->name }}" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                            <input 
                                type="file" 
                                class="form-control @error('image') is-invalid @enderror" 
                                id="image" 
                                name="image" 
                                accept="image/*"
                            >
                            <small class="text-muted">Lascia vuoto per mantenere l'immagine corrente</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Ingredienti -->
                <div class="card border mb-4" style="border-color: #e5e7eb !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-semibold mb-0">Ingredienti</h6>
                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#newIngredientModal">
                                <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
                                Nuovo Ingrediente
                            </button>
                        </div>

                        <div class="mb-3">
                            <label for="ingredients" class="form-label small text-muted mb-1">Seleziona ingredienti</label>
                            <select 
                                class="form-select @error('ingredients') is-invalid @enderror" 
                                id="ingredients" 
                                name="ingredients[]" 
                                multiple
                            >
                                @foreach($ingredients as $ingredient)
                                    <option 
                                        value="{{ $ingredient->id }}"
                                        data-is-tomato="{{ $ingredient->is_tomato ? '1' : '0' }}"
                                        {{ in_array($ingredient->id, old('ingredients', $pizza->ingredients ? $pizza->ingredients->pluck('id')->toArray() : [])) ? 'selected' : '' }}
                                    >
                                        {{ $ingredient->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ingredients')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Allergeni -->
                <div class="card border mb-4" style="border-color: #e5e7eb !important;">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-3">Gestione Allergeni</h6>
                        
                        <div class="alert alert-info mb-3">
                            <i data-lucide="info" style="width: 16px; height: 16px; vertical-align: -2px;"></i>
                            Gli allergeni vengono rilevati automaticamente dagli ingredienti selezionati
                        </div>

                        <div id="allergen-checkboxes" class="mb-3">
                            @foreach($allergens as $allergen)
                                <div class="form-check">
                                    <input 
                                        class="form-check-input allergen-checkbox" 
                                        type="checkbox" 
                                        name="allergens[]" 
                                        value="{{ $allergen->id }}" 
                                        id="allergen_{{ $allergen->id }}"
                                        {{ in_array($allergen->id, old('allergens', $pizza->allergens ? $pizza->allergens->pluck('id')->toArray() : [])) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label small" for="allergen_{{ $allergen->id }}">
                                        {{ $allergen->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div id="final-allergen-preview" class="mt-3 p-3" style="background-color: #f8f9fa; border-radius: 0.375rem; display: none;">
                            <h6 class="fw-semibold small mb-2">Allergeni Finali:</h6>
                            <div id="final-allergen-list" class="d-flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Pulsanti Azione -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-secondary">
                        <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
                        Annulla
                    </a>
                    <button type="submit" class="btn btn-outline-success">
                        <i data-lucide="save" style="width: 16px; height: 16px;"></i>
                        Salva Modifiche
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Modal per Nuovo Ingrediente -->
<div class="modal fade" id="newIngredientModal" tabindex="-1" aria-labelledby="newIngredientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newIngredientModalLabel">Nuovo Ingrediente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="new_ingredient_name" class="form-label small text-muted mb-1">Nome Ingrediente</label>
                    <input type="text" class="form-control" id="new_ingredient_name" required>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="new_ingredient_is_tomato">
                    <label class="form-check-label small" for="new_ingredient_is_tomato">
                        Contiene pomodoro
                    </label>
                </div>
                <div class="mb-3">
                    <label for="new_ingredient_allergens" class="form-label small text-muted mb-1">Allergeni</label>
                    <select class="form-select" id="new_ingredient_allergens" multiple size="5">
                        @foreach($allergens as $allergen)
                            <option value="{{ $allergen->id }}">{{ $allergen->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                    <i data-lucide="x" style="width: 16px; height: 16px;"></i>
                    Annulla
                </button>
                <button type="button" class="btn btn-outline-success btn-sm" id="saveNewIngredient">
                    <i data-lucide="check" style="width: 16px; height: 16px;"></i>
                    Salva
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/scripts/choices.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/styles/choices.min.css">
<link rel="stylesheet" href="{{ asset('css/choices-custom.css') }}">

@include('partials.pizza-edit-script')
@endsection
