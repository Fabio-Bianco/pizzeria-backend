@extends('layouts.app-modern')

@section('header')
    <h3 class="fw-semibold text-center mb-0">
        <i data-lucide="pencil" style="width: 24px; height: 24px; vertical-align: -4px;"></i>
        Modifica Antipasto
    </h3>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <form action="{{ route('admin.appetizers.update', $appetizer) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Informazioni Base -->
                <div class="card border mb-4" style="border-color: #e5e7eb !important;">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-4">Informazioni Base</h6>

                        <div class="mb-3">
                            <label for="name" class="form-label small text-muted mb-1">Nome Antipasto</label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $appetizer->name) }}" 
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
                                value="{{ old('price', $appetizer->price) }}" 
                                required
                            >
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label small text-muted mb-1">Descrizione</label>
                            <textarea 
                                class="form-control @error('description') is-invalid @enderror" 
                                id="description" 
                                name="description" 
                                rows="3"
                            >{{ old('description', $appetizer->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label small text-muted mb-1">Immagine</label>
                            @if($appetizer->image_path)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $appetizer->image_path) }}" alt="{{ $appetizer->name }}" class="img-thumbnail" style="max-width: 200px;">
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

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="is_vegan" 
                                        name="is_vegan" 
                                        value="1"
                                        {{ old('is_vegan', $appetizer->is_vegan) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label small" for="is_vegan">
                                        Vegano
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="is_gluten_free" 
                                        name="is_gluten_free" 
                                        value="1"
                                        {{ old('is_gluten_free', $appetizer->is_gluten_free) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label small" for="is_gluten_free">
                                        Senza Glutine
                                    </label>
                                </div>
                            </div>
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
                                        {{ in_array($ingredient->id, old('ingredients', $appetizer->ingredients ? $appetizer->ingredients->pluck('id')->toArray() : [])) ? 'selected' : '' }}
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
                                        {{ in_array($allergen->id, old('allergens', $appetizer->allergens ? $appetizer->allergens->pluck('id')->toArray() : [])) ? 'checked' : '' }}
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
                    <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-secondary">
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

<style>
    /* Migliora contrasto Choices.js */
    .choices__inner {
        background-color: #ffffff !important;
        border: 1px solid #dee2e6 !important;
        min-height: 44px !important;
    }
    .choices__list--multiple .choices__item {
        background-color: #10b981 !important;
        border: 1px solid #059669 !important;
        color: #ffffff !important;
        font-weight: 500 !important;
    }
    .choices__list--dropdown .choices__item--selectable {
        background-color: #ffffff !important;
        color: #1f2937 !important;
    }
    .choices__list--dropdown .choices__item--selectable.is-highlighted {
        background-color: #10b981 !important;
        color: #ffffff !important;
    }
    [data-theme="dark"] .choices__inner {
        background-color: #1f2937 !important;
        border-color: #374151 !important;
    }
    [data-theme="dark"] .choices__list--dropdown .choices__item--selectable {
        background-color: #1f2937 !important;
        color: #f3f4f6 !important;
    }
    [data-theme="dark"] .choices__list--dropdown .choices__item--selectable.is-highlighted {
        background-color: #10b981 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inizializza Choices.js
        const ingredientsSelect = new Choices('#ingredients', {
            removeItemButton: true,
            searchEnabled: true,
            searchPlaceholderValue: 'Cerca ingredienti...',
            noResultsText: 'Nessun risultato trovato',
            itemSelectText: 'Clicca per selezionare',
            placeholderValue: 'Seleziona ingredienti',
        });

        // Rilevamento automatico allergeni
        function updateAllergens() {
            const selectedIngredients = ingredientsSelect.getValue(true);
            
            if (selectedIngredients.length === 0) {
                document.querySelectorAll('.allergen-checkbox').forEach(cb => cb.checked = false);
                document.getElementById('final-allergen-preview').style.display = 'none';
                return;
            }

            fetch('{{ route('admin.ajax.ingredients-allergens') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ ingredients: selectedIngredients })
            })
            .then(response => response.json())
            .then(data => {
                document.querySelectorAll('.allergen-checkbox').forEach(checkbox => {
                    if (data.allergens.includes(parseInt(checkbox.value))) {
                        checkbox.checked = true;
                    }
                });
                updateFinalAllergenPreview();
            })
            .catch(error => console.error('Errore:', error));
        }

        // Aggiorna preview allergeni finali
        function updateFinalAllergenPreview() {
            const checkedAllergens = Array.from(document.querySelectorAll('.allergen-checkbox:checked'));
            const previewDiv = document.getElementById('final-allergen-preview');
            const listDiv = document.getElementById('final-allergen-list');

            if (checkedAllergens.length === 0) {
                previewDiv.style.display = 'none';
                return;
            }

            listDiv.innerHTML = checkedAllergens.map(cb => {
                const label = document.querySelector(`label[for="${cb.id}"]`).textContent.trim();
                return `<span class="badge bg-danger">${label}</span>`;
            }).join('');

            previewDiv.style.display = 'block';
        }

        document.getElementById('ingredients').addEventListener('change', updateAllergens);
        document.querySelectorAll('.allergen-checkbox').forEach(cb => {
            cb.addEventListener('change', updateFinalAllergenPreview);
        });

        // Inizializza stato
        updateAllergens();

        // Gestione creazione nuovo ingrediente
        document.getElementById('saveNewIngredient').addEventListener('click', function() {
            const name = document.getElementById('new_ingredient_name').value.trim();
            const allergenSelect = document.getElementById('new_ingredient_allergens');
            const selectedAllergens = Array.from(allergenSelect.selectedOptions).map(opt => opt.value);

            if (!name) {
                alert('Inserisci il nome dell\'ingrediente');
                return;
            }

            fetch('{{ route('admin.ingredients.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    name: name,
                    allergens: selectedAllergens
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    ingredientsSelect.setChoices([{
                        value: data.ingredient.id,
                        label: data.ingredient.name,
                        selected: true
                    }], 'value', 'label', false);

                    const modal = bootstrap.Modal.getInstance(document.getElementById('newIngredientModal'));
                    modal.hide();

                    document.getElementById('new_ingredient_name').value = '';
                    allergenSelect.selectedIndex = -1;

                    updateAllergens();
                } else {
                    alert('Errore durante la creazione dell\'ingrediente');
                }
            })
            .catch(error => {
                console.error('Errore:', error);
                alert('Errore durante la creazione dell\'ingrediente');
            });
        });
    });
</script>
@endsection
