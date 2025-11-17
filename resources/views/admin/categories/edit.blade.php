@extends('layouts.app-modern')

@section('title', 'Modifica Categoria')

@section('header')
<div class="text-center py-4">
    <h3 class="fw-semibold mb-2">
        <i data-lucide="pencil" style="width: 24px; height: 24px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
        Modifica: {{ $category->name }}
    </h3>
    <p class="text-muted mb-0">Aggiorna le informazioni della categoria</p>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="card border mb-3" style="border-color: #e5e7eb !important;">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Informazioni Base</h6>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label small text-muted mb-1">
                            Nome Categoria <span class="text-danger">*</span>
                        </label>
                        <input id="name" 
                               name="name" 
                               type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $category->name) }}" 
                               placeholder="Es. Classiche, Speciali, Gourmet..."
                               required
                               autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label small text-muted mb-1">
                            Descrizione
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="3" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  placeholder="Breve descrizione della categoria...">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               value="1" 
                               id="is_white" 
                               name="is_white" 
                               @checked(old('is_white', $category->is_white))>
                        <label class="form-check-label small" for="is_white">
                            Pizza bianca (senza pomodoro)
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    I campi con <span class="text-danger">*</span> sono obbligatori
                </small>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="btn btn-outline-secondary btn-sm">
                        Annulla
                    </a>
                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                        <i data-lucide="save" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
                        Salva Modifiche
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
