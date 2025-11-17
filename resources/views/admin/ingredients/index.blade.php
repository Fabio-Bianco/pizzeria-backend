@extends('layouts.app-modern')

@section('title', 'Ingredienti')

@section('header')
<div class="text-center py-4">
  <div class="mb-2"><i data-lucide="leaf" style="width: 48px; height: 48px; color: #10b981;"></i></div>
  <h1 class="display-6 fw-bold text-dark mb-2">Ingredienti</h1>
  <p class="lead text-muted mb-4">Gestisci gli ingredienti per le tue ricette</p>

  {{-- Bottone Aggiungi centrato --}}
  <div class="d-flex justify-content-center mb-4">
    <a href="{{ route('admin.ingredients.create') }}"
       class="btn btn-create btn-lg px-4 py-3"
       role="button"
       aria-label="Aggiungi un nuovo ingrediente"
       data-bs-toggle="tooltip" 
       title="Crea un nuovo ingrediente">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuovo Ingrediente
    </a>
  </div>

  <div class="mt-3">
    @php $total = method_exists($ingredients,'total') ? $ingredients->total() : ($ingredients->count() ?? 0); @endphp
    <span class="badge badge-success fs-6 px-3 py-2">
      Hai {{ $total }} {{ $total == 1 ? 'ingrediente' : 'ingredienti' }} disponibili
    </span>
  </div>
</div>
@endsection

@section('content')
  {{-- Barra filtri: ricerca e ordinamento --}}
  <x-filter-toolbar
    search
    searchPlaceholder="Cerca per nome o descrizione…"
    :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A']"
    :reset-url="route('admin.ingredients.index')"
  />
  @if(($ingredients->count() ?? 0) === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4"><i data-lucide="leaf" style="width: 80px; height: 80px; color: #10b981; opacity: .5;"></i></div>
          <h3 class="fw-bold text-dark mb-3">Nessun ingrediente presente</h3>
          <p class="text-muted mb-4">Crea il tuo primo ingrediente per iniziare.</p>
          <a class="btn btn-create btn-lg px-4 py-3" href="{{ route('admin.ingredients.create') }}">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea il Primo Ingrediente
          </a>
        </div>
      </div>
    </div>
  @else

    {{-- Lista ingredienti: elenco semplice, azioni sempre visibili a destra --}}
    <div class="list-container">
      @foreach($ingredients as $ingredient)
        <div class="d-flex align-items-center list-item-pizza">
          <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-2 mb-1">
              <h6 class="mb-0 text-truncate">{{ $ingredient->name }}</h6>
            </div>
            @if(!empty($ingredient->description))
              <div class="text-muted small mb-1">{{ \Illuminate\Support\Str::limit($ingredient->description, 100) }}</div>
            @endif
            @if($ingredient->allergens && $ingredient->allergens->count() > 0)
              <div class="mb-1">
                <span class="badge badge-neutral small">Allergeni: {{ $ingredient->allergens->pluck('name')->implode(', ') }}</span>
              </div>
            @endif
          </div>
          <div class="d-flex align-items-center gap-2 ms-3 flex-shrink-0">
            <a href="{{ route('admin.ingredients.edit', $ingredient) }}"
               class="btn btn-success btn-sm d-flex align-items-center gap-1"
               title="Modifica ingrediente">
              <i class="fas fa-edit me-1" aria-hidden="true"></i> <span>Modifica</span>
            </a>
            <form method="POST" action="{{ route('admin.ingredients.destroy', $ingredient) }}" class="d-inline" data-item-name="{{ $ingredient->name }}">
              @csrf @method('DELETE')
              <button type="submit"
                      class="btn btn-danger btn-sm d-flex align-items-center gap-1"
                      title="Elimina ingrediente">
                <i class="fas fa-trash me-1" aria-hidden="true"></i> <span>Elimina</span>
              </button>
            </form>
          </div>
        </div>
      @endforeach
    </div>

    @if(method_exists($ingredients,'hasPages') && $ingredients->hasPages())
      <div class="d-flex justify-content-center mt-5">
        {{ $ingredients->links() }}
      </div>
    @endif
  @endif
@endsection