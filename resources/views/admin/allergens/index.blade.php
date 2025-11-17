@extends('layouts.app-modern')

@section('title', 'Allergeni')

@section('header')
<div class="text-center py-4">
    <div class="mb-2"><i data-lucide="shield-alert" style="width: 48px; height: 48px; color: #dc2626;"></i></div>
    <h1 class="display-6 fw-bold text-dark mb-2">Allergeni</h1>
    <p class="lead text-muted mb-4">Gestisci gli allergeni presenti nei tuoi ingredienti e piatti</p>

    {{-- Bottone Aggiungi centrato --}}
    <div class="d-flex justify-content-center mb-4">
        <a href="{{ route('admin.allergens.create') }}"
             class="btn btn-create btn-lg px-4 py-3"
             role="button"
             aria-label="Aggiungi un nuovo allergene"
             data-bs-toggle="tooltip" 
             title="Crea un nuovo allergene">
            <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuovo Allergene
        </a>
    </div>

    @if (session('status'))
        <div class="text-success">{{ session('status') }}</div>
    @endif
</div>
@endsection

@section('content')
    <x-filter-toolbar
        search
        searchPlaceholder="Cerca per nome o descrizione…"
        :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A']"
        :reset-url="route('admin.allergens.index')"
    />

    @if($allergens->count() === 0)
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center py-5">
                    <div class="mb-4"><i data-lucide="shield-alert" style="width: 80px; height: 80px; color: #dc2626; opacity: .5;"></i></div>
                    <h3 class="fw-bold text-dark mb-3">Nessun allergene presente</h3>
                    <p class="text-muted mb-4">Crea il tuo primo allergene per iniziare.</p>
                    <a class="btn btn-create btn-lg px-4 py-3" href="{{ route('admin.allergens.create') }}">
                        <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea il Primo Allergene
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="list-container">
            @foreach($allergens as $allergen)
                <div class="d-flex align-items-center list-item-pizza">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h6 class="mb-0 text-truncate">{{ $allergen->name }}</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 ms-3 flex-shrink-0">
                        <a href="{{ route('admin.allergens.edit', $allergen) }}"
                             class="btn btn-success btn-sm d-flex align-items-center gap-1"
                             title="Modifica allergene">
                            <i class="fas fa-edit me-1" aria-hidden="true"></i> <span>Modifica</span>
                        </a>
                        <form action="{{ route('admin.allergens.destroy', $allergen) }}" method="POST" data-confirm="Sicuro?" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                            class="btn btn-danger btn-sm d-flex align-items-center gap-1"
                                            title="Elimina allergene">
                                <i class="fas fa-trash me-1" aria-hidden="true"></i> <span>Elimina</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($allergens,'hasPages') && $allergens->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $allergens->links() }}
            </div>
        @endif
    @endif
@endsection
