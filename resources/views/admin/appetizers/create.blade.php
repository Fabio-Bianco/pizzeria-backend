@extends('layouts.app-modern')

@section('title', 'Nuovo Antipasto')

@section('header')
<div class="d-flex align-items-center gap-3 py-3">
    <a href="{{ route('admin.appetizers.index') }}" 
       class="btn btn-outline-secondary btn-sm"
       aria-label="Torna agli antipasti">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
    </a>
    <div>
        <h1 class="h4 fw-semibold text-dark mb-1">
            <i data-lucide="salad" style="width: 24px; height: 24px; color: #059669; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
            Nuovo Antipasto
        </h1>
        <p class="text-muted small mb-0">Compila i campi per aggiungere un antipasto</p>
    </div>
</div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <form action="{{ route('admin.appetizers.store') }}" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                @csrf
                
                {{-- Informazioni Base --}}
                <div class="card border mb-3" style="border-color: #e5e7eb !important;">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark mb-3">
                            <i data-lucide="file-text" style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-right: 6px; color: #6b7280;"></i>
                            Informazioni Base
                        </h6>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="name" class="form-label fw-semibold">
                                            <i class="fas fa-salad me-1"></i>
                                            Nome Antipasto <span class="text-danger">*</span>
                                        </label>
                                        <input id="name" name="name" type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name') }}" 
                                               placeholder="Es. Bruschette, Antipasto misto, Tagliere..."
                                               required>
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="price" class="form-label fw-semibold">
                                            <i class="fas fa-euro-sign me-1"></i>
                                            Prezzo <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">€</span>
                                            <input id="price" name="price" type="number" step="0.01" 
                                                   class="form-control @error('price') is-invalid @enderror" 
                                                   value="{{ old('price') }}" 
                                                   placeholder="8.50"
                                                   required>
                                        </div>
                                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="description" class="form-label fw-semibold">
                                            <i class="fas fa-align-left me-1"></i>
                                            Descrizione
                                        </label>
                                        <textarea id="description" name="description" rows="3" 
                                                  class="form-control @error('description') is-invalid @enderror" 
                                                  placeholder="Descrivi l'antipasto...">{{ old('description') }}</textarea>
                                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="notes" class="form-label fw-semibold">
                                            <i class="fas fa-sticky-note me-1"></i>
                                            Note
                                        </label>
                                        <textarea id="notes" name="notes" rows="2" 
                                                  class="form-control @error('notes') is-invalid @enderror" 
                                                  placeholder="Note aggiuntive...">{{ old('notes') }}</textarea>
                                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Ingredienti e Opzioni (colonna destra) --}}
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-seedling text-success me-2"></i>
                                    Ingredienti e Opzioni
                                </h5>
                            </div>
                            <div class="card-body">
                                {{-- Checkbox Vegano --}}
                                <div class="mb-4">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="is_vegan" name="is_vegan" value="1" 
                                               @checked(old('is_vegan', false))>
                                        <label class="form-check-label fw-semibold" for="is_vegan">
                                            <i class="fas fa-leaf text-success me-1"></i>
                                            Vegano
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_gluten_free" name="is_gluten_free" value="1" 
                                               @checked(old('is_gluten_free', false))>
                                        <label class="form-check-label fw-semibold text-dark" for="is_gluten_free">
                                            <i class="fas fa-bread-slice me-1 text-dark"></i>
                                            <span class="text-dark">Senza Glutine</span>
                                        </label>
                                    </div>
                                    <small class="text-muted">Contrassegna se l'antipasto è adatto ai vegani o a chi è intollerante al glutine</small>
                                </div>

                                {{-- Ingredienti --}}
                                @if(isset($ingredients) && $ingredients->isNotEmpty())
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="ingredients" class="form-label fw-semibold mb-0">
                                            <i class="fas fa-list me-1"></i>
                                            Ingredienti Principali
                                        </label>
                                        <button type="button" class="btn btn-sm btn-outline-success px-2 py-1 ms-2 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#newIngredientModal">
                                            <i class="fas fa-plus me-1"></i> Aggiungi ingrediente
                                        </button>
                                    </div>
                                    <select id="ingredients" name="ingredients[]" multiple 
                                            class="form-select @error('ingredients') is-invalid @enderror" 
                                            data-choices 
                                            data-store-url="{{ route('admin.ingredients.store') }}"
                                            placeholder="Cerca e seleziona ingredienti...">
                                        @foreach ($ingredients as $ingredient)
                                            <option value="{{ $ingredient->id }}" 
                                                    @selected(collect(old('ingredients',[]))->contains($ingredient->id))>
                                                {{ $ingredient->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ingredients')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Aiuta a calcolare automaticamente gli allergeni
                                    </div>
                                </div>
                                <!-- Modal nuovo ingrediente (riuso markup pizze) -->
                                <div class="modal fade" id="newIngredientModal" tabindex="-1" aria-labelledby="newIngredientModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="newIngredientModalLabel">
                                                    <i class="fas fa-plus me-2 text-success"></i>Nuovo Ingrediente
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label for="ni_name" class="form-label fw-semibold">Nome Ingrediente</label>
                                                <input type="text" id="ni_name" class="form-control mb-3" placeholder="Es. Prosciutto cotto, Olive nere...">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annulla</button>
                                                <button type="button" class="btn btn-success" id="ni_save">Crea Ingrediente</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                {{-- Spazio per allergeni calcolati automaticamente --}}
                                <div class="mt-4 p-3 bg-light rounded">
                                    <h6 class="mb-2">
                                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                        Allergeni
                                    </h6>
                                    <small class="text-muted">
                                        Gli allergeni verranno calcolati automaticamente in base agli ingredienti selezionati
                                    </small>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-hand-paper me-1 text-warning"></i>
                                        Allergeni Aggiuntivi
                                    </label>
                                    <div class="row g-1" id="manual-allergens-container">
                                        @foreach(($allergens ?? []) as $allergen)
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="manual_allergens[]"
                                                           value="{{ $allergen->id }}"
                                                           id="allergen_{{ $allergen->id }}"
                                                           @checked(collect(old('manual_allergens',[]))->contains($allergen->id))>
                                                    <label class="form-check-label small" for="allergen_{{ $allergen->id }}">
                                                        {{ $allergen->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('manual_allergens')<div class="text-danger mt-1 small">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pulsanti azione --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">I campi con <span class="text-danger">*</span> sono obbligatori</small>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-secondary btn-sm" aria-label="Annulla">
                            <i data-lucide="x" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>Annulla
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm" aria-label="Salva antipasto">
                            <i data-lucide="check" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>Salva Antipasto
                        </button>
                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
