@extends('layouts.app-modern')

@section('title', 'Modifica Ingrediente')

@section('header')
<div class="text-center py-4">
    <h3 class="fw-semibold mb-2">
        <i data-lucide="pencil" style="width: 24px; height: 24px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
        Modifica: {{ $ingredient->name }}
    </h3>
    <p class="text-muted mb-0">Aggiorna le informazioni dell'ingrediente</p>
</div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <form action="{{ route('admin.ingredients.update', $ingredient) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                
                {{-- Card Informazioni Base --}}
                <div class="card border mb-3" style="border-color: #e5e7eb !important;">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Informazioni Base</h6>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label small text-muted mb-1">
                                Nome Ingrediente <span class="text-danger">*</span>
                            </label>
                            <input id="name" 
                                   name="name" 
                                   type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $ingredient->name) }}" 
                                   placeholder="Es. Mozzarella, Pomodoro, Basilico..."
                                   required
                                   autofocus>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   value="1" 
                                   id="is_tomato" 
                                   name="is_tomato" 
                                   @checked(old('is_tomato', $ingredient->is_tomato))>
                            <label class="form-check-label small" for="is_tomato">
                                È un tipo di pomodoro
                            </label>
                        </div>
                        <small class="text-muted d-block mt-1">Contrassegna se questo ingrediente è un derivato del pomodoro</small>
                    </div>
                </div>

                {{-- Card Allergeni --}}
                <div class="card border mb-3" style="border-color: #e5e7eb !important;">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Allergeni Associati</h6>
                        
                        <div class="mb-3">
                            <label for="allergens" class="form-label small text-muted mb-1">
                                Seleziona allergeni
                            </label>
                            <select id="allergens" 
                                    name="allergens[]" 
                                    multiple 
                                    class="form-select @error('allergens') is-invalid @enderror" 
                                    data-choices 
                                    placeholder="Cerca e seleziona allergeni...">
                                @foreach ($allergens as $allergen)
                                    <option value="{{ $allergen->id }}" 
                                            @selected($ingredient->allergens->pluck('id')->contains($allergen->id))>
                                        {{ $allergen->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('allergens')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            <small class="text-muted d-block mt-1">
                                Seleziona tutti gli allergeni presenti in questo ingrediente
                            </small>
                        </div>

                        @if($ingredient->allergens->isNotEmpty())
                        <div class="p-3 bg-light rounded">
                            <div class="small text-muted mb-2">Allergeni Attuali</div>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($ingredient->allergens as $allergen)
                                    <span class="badge bg-warning text-dark">{{ $allergen->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Footer con azioni --}}
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        I campi con <span class="text-danger">*</span> sono obbligatori
                    </small>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.ingredients.index') }}" 
                           class="btn btn-outline-secondary btn-sm">
                            Annulla
                        </a>
                        <button type="submit" class="btn btn-outline-success btn-sm">
                            <i data-lucide="save" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
                            Salva Modifiche
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
