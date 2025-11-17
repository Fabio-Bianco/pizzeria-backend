@extends('layouts.app-modern')

@section('title', 'Nuova Bevanda')

@section('header')
<div class="d-flex align-items-center gap-3 py-3">
    <a href="{{ route('admin.beverages.index') }}" 
       class="btn btn-outline-secondary btn-sm"
       aria-label="Torna alle bevande">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
    </a>
    <div>
        <h1 class="h4 fw-semibold text-dark mb-1">
            <i data-lucide="glass-water" style="width: 24px; height: 24px; color: #2563eb; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
            Nuova Bevanda
        </h1>
        <p class="text-muted small mb-0">Compila i campi per aggiungere una bevanda</p>
    </div>
</div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <form action="{{ route('admin.beverages.store') }}" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                @csrf
                
                {{-- Informazioni Base --}}
                <div class="card border mb-3" style="border-color: #e5e7eb !important;">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark mb-3">
                            <i data-lucide="file-text" style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-right: 6px; color: #6b7280;"></i>
                            Informazioni Base
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="name" class="form-label small fw-semibold text-dark">Nome <span class="text-danger">*</span></label>
                                <input id="name" name="name" type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       placeholder="Es. Coca Cola, Birra Moretti"
                                       required
                                       autofocus>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4">
                                <label for="price" class="form-label small fw-semibold text-dark">Prezzo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">€</span>
                                    <input id="price" name="price" type="number" step="0.01" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           value="{{ old('price') }}" 
                                           placeholder="3.50"
                                           required>
                                </div>
                                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="category" class="form-label small fw-semibold text-dark">Categoria</label>
                                <select id="category" name="category" class="form-select @error('category') is-invalid @enderror">
                                    <option value="">Seleziona...</option>
                                    <option value="analcoliche" @selected(old('category') == 'analcoliche')>Analcoliche</option>
                                    <option value="alcoliche" @selected(old('category') == 'alcoliche')>Alcoliche</option>
                                    <option value="birre" @selected(old('category') == 'birre')>Birre</option>
                                    <option value="vini" @selected(old('category') == 'vini')>Vini</option>
                                    <option value="liquori" @selected(old('category') == 'liquori')>Liquori</option>
                                    <option value="caffetteria" @selected(old('category') == 'caffetteria')>Caffetteria</option>
                                </select>
                                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="formato" class="form-label small fw-semibold text-dark">Formato</label>
                                <input id="formato" name="formato" type="text" 
                                       class="form-control @error('formato') is-invalid @enderror" 
                                       value="{{ old('formato') }}" 
                                       placeholder="330ml, 0.5L, 75cl">
                                @error('formato')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label small fw-semibold text-dark">Descrizione</label>
                                <textarea id="description" name="description" rows="2" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          placeholder="Breve descrizione della bevanda">{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Dettagli Opzionali --}}
                <div class="card border mb-3" style="border-color: #e5e7eb !important;">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark mb-3">
                            <i data-lucide="sliders" style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-right: 6px; color: #6b7280;"></i>
                            Dettagli Opzionali
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="gradazione_alcolica" class="form-label small fw-semibold text-dark">Gradazione Alcolica</label>
                                <div class="input-group input-group-sm">
                                    <input id="gradazione_alcolica" name="gradazione_alcolica" type="number" step="0.1" 
                                           class="form-control @error('gradazione_alcolica') is-invalid @enderror" 
                                           value="{{ old('gradazione_alcolica') }}" 
                                           placeholder="5.0">
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('gradazione_alcolica')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4">
                                <label for="tipologia" class="form-label small fw-semibold text-dark">Tipologia</label>
                                <select id="tipologia" name="tipologia" class="form-select form-select-sm @error('tipologia') is-invalid @enderror">
                                    <option value="">Seleziona...</option>
                                    <option value="analcolica" @selected(old('tipologia') == 'analcolica')>Analcolica</option>
                                    <option value="birra" @selected(old('tipologia') == 'birra')>Birra</option>
                                    <option value="vino" @selected(old('tipologia') == 'vino')>Vino</option>
                                    <option value="liquore" @selected(old('tipologia') == 'liquore')>Liquore</option>
                                    <option value="altro" @selected(old('tipologia') == 'altro')>Altro</option>
                                </select>
                                @error('tipologia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4">
                                <label for="image" class="form-label small fw-semibold text-dark">Immagine</label>
                                <input id="image" name="image" type="file" 
                                       class="form-control form-control-sm @error('image') is-invalid @enderror" 
                                       accept=".jpg,.jpeg,.png,.webp">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label small fw-semibold text-dark">Note</label>
                                <textarea id="notes" name="notes" rows="2" 
                                          class="form-control form-control-sm @error('notes') is-invalid @enderror" 
                                          placeholder="Temperature, abbinamenti, note di servizio">{{ old('notes') }}</textarea>
                                @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           id="is_gluten_free" name="is_gluten_free" value="1"
                                           @checked(old('is_gluten_free'))>
                                    <label class="form-check-label small text-dark" for="is_gluten_free">
                                        Senza Glutine
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Azioni --}}
                <div class="d-flex justify-content-between align-items-center gap-3 py-3">
                    <small class="text-muted">
                        I campi con <span class="text-danger">*</span> sono obbligatori
                    </small>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.beverages.index') }}" 
                           class="btn btn-outline-secondary btn-sm"
                           aria-label="Annulla creazione">
                            <i data-lucide="x" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>Annulla
                        </a>
                        <button type="submit" 
                                class="btn btn-primary btn-sm"
                                aria-label="Salva bevanda">
                            <i data-lucide="check" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>Salva Bevanda
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
