@extends('layouts.app-modern')

@section('title', 'Pizze')

@section('header')
<div class="text-center py-4">
  <div class="mb-2"><i data-lucide="pizza" style="width: 48px; height: 48px; color: #ef4444;"></i></div>
  <h1 class="display-6 fw-bold text-dark mb-2">Pizze</h1>
  <p class="lead text-muted mb-4">Gestisci le pizze del tuo menu</p>

  <div class="d-flex justify-content-center mb-4">
    <a href="{{ route('admin.pizzas.create') }}"
       class="btn btn-create btn-lg px-4 py-3"
       role="button"
       aria-label="Aggiungi una nuova pizza"
       data-bs-toggle="tooltip" title="Crea una nuova pizza">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuova Pizza
    </a>
  </div>

  <div class="mt-3">
    @php $total = method_exists($pizzas,'total') ? $pizzas->total() : ($pizzas->count() ?? 0); @endphp
    <span class="badge bg-success fs-6 px-3 py-2">Hai {{ $total }} {{ $total == 1 ? 'pizza' : 'pizze' }} disponibili</span>
  </div>
</div>
@endsection

@section('content')
  @php $count = ($pizzas->count() ?? 0); @endphp

  @if($count === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4"><i data-lucide="pizza" style="width: 80px; height: 80px; color: #ef4444; opacity: .5;"></i></div>
          <h3 class="fw-bold text-dark mb-3">Nessuna pizza presente</h3>
          <p class="text-muted mb-4">Crea la tua prima pizza per iniziare.</p>
          <a class="btn btn-success btn-lg px-4 py-3 fw-bold" href="{{ route('admin.pizzas.create') }}">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea la Prima Pizza
          </a>
        </div>
      </div>
    </div>
  @else
    <div class="transition-container list-wrapper">
      <div class="list-container">
        @foreach($pizzas as $pizza)
          <div class="pizza-card card shadow-sm border-0 mb-3">
            <div class="card-body py-3 px-3">
              <div class="d-flex align-items-center gap-3 flex-wrap flex-md-nowrap">
                <div class="pizza-icon flex-shrink-0 d-flex align-items-center justify-content-center bg-light rounded-circle overflow-hidden" style="height:56px;width:56px;">
                  @php
                    $pizzaName = strtolower(str_replace([' ', "'"], ['-', ''], $pizza->name));
                    $imgMap = [
                      'capricciosa' => 'capricciosa.jpg',
                      'margherita' => 'margherita.jpg',
                      'quattro-formaggi' => 'quattro-formaggi.jpg',
                    ];
                    $imgFile = $imgMap[$pizzaName] ?? null;
                  @endphp
                  @if($imgFile && file_exists(public_path('img/pizzas/' . $imgFile)))
                    <img src="{{ asset('img/pizzas/' . $imgFile) }}" alt="{{ $pizza->name }}" style="max-width:100%;max-height:100%;object-fit:cover;">
                  @else
                    <img src="{{ asset('img/pizzas/default.jpg') }}" alt="Nessuna immagine" style="max-width:100%;max-height:100%;object-fit:cover;opacity:0.5;">
                  @endif
                  <span class="d-none">{{ $imgFile }}</span>
                </div>
                <div class="flex-grow-1 min-w-0">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="d-flex flex-column align-items-start min-w-0">
                      <div class="d-flex align-items-center flex-row flex-wrap" style="min-width:0;">
                        <span class="fw-bold fs-5 text-dark d-inline-block" style="max-width:320px;">{{ $pizza->name }}</span>
                        @if(!empty($pizza->is_vegan))
                          <span class="badge rounded-pill align-middle ms-2" style="border:1.5px solid #6bbf59;color:#388e3c;background:#e6f4ea;font-size:0.85em;font-weight:600;padding:0.18em 0.7em;vertical-align:middle;letter-spacing:0.02em;">
                            <i class="fas fa-leaf me-1" style="color:#388e3c;"></i>Veg
                          </span>
                        @endif
                      </div>
                      @if($pizza->category)
                        <span class="badge rounded-pill border border-secondary text-secondary px-2 py-1 mt-1 small" style="font-size:0.85em;background:transparent;">{{ $pizza->category->name }}</span>
                      @endif
                    </div>
                  </div>
                  @if(!empty($pizza->notes))
                    <div class="mb-1"><small class="text-muted text-truncate d-block" style="max-width:320px;">{{ \Illuminate\Support\Str::limit($pizza->notes, 120) }}</small></div>
                  @endif
                  @if($pizza->ingredients && $pizza->ingredients->count() > 0)
                    @php $collapseId = 'ingredients-collapse-'.$pizza->id; $collapseAllergenId = 'allergens-collapse-'.$pizza->id; @endphp
                    <div class="d-flex flex-row gap-2 mt-2">
                      <button class="btn btn-sm d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}" style="border:1.5px solid #8fd19e;color:#388e3c;background:transparent;">
                        <span style="font-size:1.2em;line-height:1;color:#388e3c;">&#9776;</span> <span>Vedi ingredienti</span>
                      </button>
                      <button class="btn btn-sm d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseAllergenId }}" aria-expanded="false" aria-controls="{{ $collapseAllergenId }}" style="border:1.5px solid #ffe066;color:#bfa100;background:transparent;">
                        <span style="font-size:1.2em;line-height:1;color:#bfa100;">&#9776;</span> <span>Vedi allergeni</span>
                      </button>
                    </div>
                    <div class="collapse mt-2 w-100" id="{{ $collapseId }}">
                      @if($pizza->ingredients && $pizza->ingredients->count() > 0)
                        <ul class="list-unstyled mb-0 ps-2 small">
                          @foreach($pizza->ingredients as $ingredient)
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
                      @php $allAllergens = $pizza->getAllAllergens(); @endphp
                      @if($allAllergens->count() > 0)
                        <ul class="list-unstyled mb-0 ps-2 small">
                          @foreach($allAllergens as $allergen)
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
                  <a href="{{ route('admin.pizzas.show', $pizza) }}" class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Dettagli">
                    <i class="fas fa-eye me-1"></i><span class="d-none d-md-inline">Dettagli</span>
                  </a>
                  <a href="{{ route('admin.pizzas.edit', $pizza) }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Modifica">
                    <i class="fas fa-edit me-1 text-success"></i><span class="d-none d-md-inline text-success">Modifica</span>
                  </a>
                  <form method="POST" action="{{ route('admin.pizzas.destroy', $pizza) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center w-100" data-bs-toggle="tooltip" title="Elimina">
                      <i class="fas fa-trash me-1 text-danger"></i><span class="d-none d-md-inline text-danger">Elimina</span>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      @if(method_exists($pizzas,'hasPages') && $pizzas->hasPages())
        <div class="d-flex justify-content-center mt-5">{{ $pizzas->links() }}</div>
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
