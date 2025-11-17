@extends('layouts.app-modern')

@section('title', 'I Tuoi Antipasti')

@section('header')
<div class="text-center py-4">
  <div class="mb-2"><i data-lucide="salad" style="width: 48px; height: 48px; color: #10b981;"></i></div>
  <h1 class="display-6 fw-bold text-dark mb-2">I Tuoi Antipasti</h1>
  <p class="lead text-muted mb-4">Tutti gli antipasti e stuzzichini del tuo menu</p>

  <div class="d-flex justify-content-center mb-4">
    <a href="{{ route('admin.appetizers.create') }}"
       class="btn btn-create btn-lg px-4 py-3"
       role="button"
       aria-label="Aggiungi un nuovo antipasto"
       data-bs-toggle="tooltip" title="Crea un nuovo antipasto">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuovo Antipasto
    </a>
  </div>

  <div class="visually-hidden" aria-live="polite" aria-atomic="true" id="view-change-announce"></div>
  <div class="mt-3">
    @php $total = method_exists($appetizers,'total') ? $appetizers->total() : ($appetizers->count() ?? 0); @endphp
    <span class="badge bg-success fs-6 px-3 py-2">Hai {{ $total }} {{ $total == 1 ? 'antipasto' : 'antipasti' }} nel menu</span>
  </div>
</div>
@endsection

@section('content')
  @php $count = ($appetizers->count() ?? 0); @endphp

  @if($count === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4"><i data-lucide="salad" style="width: 80px; height: 80px; color: #10b981; opacity: .5;"></i></div>
          <h3 class="fw-bold text-dark mb-3">Non hai ancora nessun antipasto!</h3>
          <p class="text-muted mb-4">Inizia subito creando il tuo primo antipasto per il menu.</p>
          <a class="btn btn-success btn-lg px-4 py-3 fw-bold" href="{{ route('admin.appetizers.create') }}">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea il Primo Antipasto
          </a>
        </div>
      </div>
    </div>
  @else
    <div id="appetizers-container" class="transition-container list-wrapper">
      <div class="list-container">
        @foreach($appetizers as $a)
          <div class="pizza-card card shadow-sm border-0 mb-3">
            <div class="card-body py-3 px-3">
              <div class="d-flex align-items-center gap-3 flex-wrap flex-md-nowrap">
                <div class="pizza-icon flex-shrink-0 d-flex align-items-center justify-content-center bg-light rounded-circle" style="height:56px;width:56px;">
                  @if(!empty($a->image_path))
                    <img src="{{ asset('storage/'.$a->image_path) }}" alt="Antipasto {{ $a->name }}" class="img-fluid rounded-circle" style="height:56px;width:56px;object-fit:cover;">
                  @else
                    <i class="fas fa-seedling text-success fs-3" aria-hidden="true"></i>
                  @endif
                </div>
                <div class="flex-grow-1 min-w-0">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="d-flex flex-column align-items-start min-w-0">
                      <span class="fw-bold fs-5 text-dark text-truncate d-inline-block" style="max-width:220px;">{{ $a->name }}</span>
                    </div>
                  </div>
                  @if(!empty($a->description))
                    <div class="mb-1"><small class="text-muted text-truncate d-block" style="max-width:320px;">{{ \Illuminate\Support\Str::limit($a->description, 120) }}</small></div>
                  @endif
                  @if($a->allergens && $a->allergens->count() > 0)
                    @php $collapseAllergenId = 'allergens-collapse-appetizer-'.$a->id; @endphp
                    <button class="btn btn-sm btn-outline-warning mt-2 d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseAllergenId }}" aria-expanded="false" aria-controls="{{ $collapseAllergenId }}">
                      <i class="fas fa-exclamation-triangle"></i> <span>Vedi allergeni</span>
                    </button>
                    <div class="collapse mt-2 w-100" id="{{ $collapseAllergenId }}">
                      <ul class="list-unstyled mb-0 ps-2 small">
                        @foreach($a->allergens as $allergen)
                          <li class="py-1 d-flex align-items-center gap-2">
                            <i class="fas fa-circle text-warning" style="font-size:0.5em;"></i> <span>{{ $allergen->name }}</span>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                  @if($a->ingredients && $a->ingredients->count() > 0)
                    @php $collapseId = 'ingredients-collapse-appetizer-'.$a->id; $collapseAllergenId = 'allergens-collapse-appetizer-'.$a->id; @endphp
                    <div class="d-flex flex-row gap-2 mt-2">
                      <button class="btn btn-sm d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}" style="border:1.5px solid #8fd19e;color:#388e3c;background:transparent;">
                        <span style="font-size:1.2em;line-height:1;color:#388e3c;">&#9776;</span> <span>Vedi ingredienti</span>
                      </button>
                      <button class="btn btn-sm d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseAllergenId }}" aria-expanded="false" aria-controls="{{ $collapseAllergenId }}" style="border:1.5px solid #ffe066;color:#bfa100;background:transparent;">
                        <span style="font-size:1.2em;line-height:1;color:#bfa100;">&#9776;</span> <span>Vedi allergeni</span>
                      </button>
                    </div>
                    <div class="collapse mt-2 w-100" id="{{ $collapseId }}">
                      @if($a->ingredients && $a->ingredients->count() > 0)
                        <ul class="list-unstyled mb-0 ps-2 small">
                          @foreach($a->ingredients as $ingredient)
                            <li class="py-1 d-flex align-items-center gap-2">
                              <span>{{ $ingredient->name }}</span>
                            </li>
                          @endforeach
                        </ul>
                      @else
                        <div class="text-muted small ps-2">Nessun ingrediente</div>
                      @endif
                    </div>
                    <div class="collapse mt-2 w-100" id="{{ $collapseAllergenId }}">
                      @if($a->allergens && $a->allergens->count() > 0)
                        <ul class="list-unstyled mb-0 ps-2 small">
                          @foreach($a->allergens as $allergen)
                            <li class="py-1 d-flex align-items-center gap-2">
                              <span>{{ $allergen->name }}</span>
                            </li>
                          @endforeach
                        </ul>
                      @else
                        <div class="text-muted small ps-2">Nessun allergene</div>
                      @endif
                    </div>
                  @endif
                </div>
                <div class="pizza-actions d-flex flex-column flex-md-row gap-2 ms-md-3 mt-3 mt-md-0">
                  <a href="{{ route('admin.appetizers.show', $a) }}" class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Dettagli" style="border:1.5px solid #1976d2;color:#1976d2;background:transparent;">
                    <i class="fas fa-eye me-1" style="color:#1976d2;"></i><span class="d-none d-md-inline" style="color:#1976d2;">Dettagli</span>
                  </a>
                  <a href="{{ route('admin.appetizers.edit', $a) }}" class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Modifica" style="border:1.5px solid #388e3c;color:#388e3c;background:transparent;">
                    <i class="fas fa-edit me-1" style="color:#388e3c;"></i><span class="d-none d-md-inline" style="color:#388e3c;">Modifica</span>
                  </a>
                  <form method="POST" action="{{ route('admin.appetizers.destroy', $a) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center w-100" data-bs-toggle="tooltip" title="Elimina" style="border:1.5px solid #d32f2f;color:#d32f2f;background:transparent;">
                      <i class="fas fa-trash me-1" style="color:#d32f2f;"></i><span class="d-none d-md-inline" style="color:#d32f2f;">Elimina</span>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      @if(method_exists($appetizers,'hasPages') && $appetizers->hasPages())
        <div class="d-flex justify-content-center mt-5">{{ $appetizers->links() }}</div>
      @endif
    </div>
  @endif
@endsection

@push('styles')
<style>
  .list-wrapper, .list-container { overflow: visible; }
  .actions-flex .btn { min-width: 110px; white-space: nowrap; }
  @media (max-width: 576px) { .actions-flex .btn { min-width: 100%; } }
  .bg-green-veg {
    background: #e6f4ea;
    border: 1.5px solid #6bbf59;
  }
  .text-green-veg {
    color: #388e3c !important;
  }
</style>
@endpush

@push('scripts')
<script>
(function () {
  if (window.bootstrap) {
    const triggers = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    triggers.forEach(el => new bootstrap.Tooltip(el));
  }
})();
</script>
@endpush
