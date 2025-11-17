@extends('layouts.app-modern')

@section('title', $dessert->name)

@section('header')
<div class="text-center py-4">
    <h3 class="fw-semibold mb-2">
        <i data-lucide="eye" style="width: 24px; height: 24px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
        {{ $dessert->name }}
    </h3>
    <p class="text-muted mb-0">Dettagli del dessert</p>
</div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            {{-- Informazioni principali --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle text-warning me-2"></i>
                        Informazioni Generali
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        @if($dessert->image_path)
                            <div class="col-12 col-md-4">
                                <img src="{{ asset('storage/'.$dessert->image_path) }}" 
                                     alt="{{ $dessert->name }}" 
                                     class="img-fluid rounded shadow-sm"
                                     style="max-height: 250px; width: 100%; object-fit: cover;">
                            </div>
                        @endif
                        
                        <div class="col-12 {{ $dessert->image_path ? 'col-md-8' : '' }}">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <strong class="me-2">Nome:</strong>
                                        <span class="fs-5 fw-bold text-warning">{{ $dessert->name }}</span>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <strong class="me-2">Prezzo:</strong>
                                        <span class="fs-4 fw-bold text-success">€{{ number_format($dessert->price, 2, ',', '.') }}</span>
                                    </div>
                                </div>

                                @if($dessert->description)
                                    <div class="col-12">
                                        <strong>Descrizione:</strong>
                                        <div class="mt-2 p-3 bg-light rounded">
                                            {{ $dessert->description }}
                                        </div>
                                    </div>
                                @endif

                                @if($dessert->notes)
                                    <div class="col-12">
                                        <strong>Note:</strong>
                                        <div class="mt-2 p-3 bg-info bg-opacity-10 rounded border border-info border-opacity-25">
                                            <i class="fas fa-sticky-note text-info me-2"></i>
                                            {{ $dessert->notes }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ingredienti --}}
            @if($dessert->ingredients && $dessert->ingredients->isNotEmpty())
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-seedling text-success me-2"></i>
                        Ingredienti ({{ $dessert->ingredients->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        @foreach($dessert->ingredients as $ingredient)
                            <div class="col-auto">
                                <span class="badge bg-light text-dark fs-6 px-3 py-2">
                                    <i class="fas fa-seedling me-1"></i>
                                    {{ $ingredient->name }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Allergeni automatici --}}
            @php
                $automaticAllergens = $dessert->getAutomaticAllergens();
            @endphp
            @if($automaticAllergens->isNotEmpty())
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                        Allergeni Rilevati ({{ $automaticAllergens->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        @foreach($automaticAllergens as $allergen)
                            <div class="col-auto">
                                <span class="badge bg-danger fs-6 px-3 py-2">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    {{ $allergen->name }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <div class="alert alert-warning mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Attenzione:</strong> Questi allergeni sono stati rilevati automaticamente dagli ingredienti selezionati.
                    </div>
                </div>
            </div>
            @endif

            {{-- Azioni --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            <small>
                                <i class="fas fa-calendar me-1"></i>
                                Creato il {{ $dessert->created_at->format('d/m/Y H:i') }}
                                @if($dessert->updated_at && $dessert->updated_at != $dessert->created_at)
                                    • Aggiornato il {{ $dessert->updated_at->format('d/m/Y H:i') }}
                                @endif
                            </small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.desserts.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-list me-2"></i>
                                Lista Dessert
                            </a>
                            <a href="{{ route('admin.desserts.edit', $dessert) }}" class="btn btn-success px-4">
                                <i class="fas fa-edit me-2"></i>
                                Modifica
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <a href="{{ route('admin.desserts.index') }}" class="btn btn-outline-secondary btn-sm">
                    Torna all'elenco
                </a>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.desserts.edit', $dessert) }}" class="btn btn-outline-warning btn-sm">
                        <i data-lucide="pencil" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
                        Modifica
                    </a>
                    <form method="POST" action="{{ route('admin.desserts.destroy', $dessert) }}" 
                          data-confirm="Sei sicuro di voler eliminare il dessert '{{ $dessert->name }}'?" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i data-lucide="trash-2" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
                            Elimina
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection