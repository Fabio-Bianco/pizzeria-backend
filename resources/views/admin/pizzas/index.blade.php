@extends('layouts.app-modern')

@section('title', 'Pizze')

@section('header')
<div class="text-center py-4">
  <h1 class="h3 fw-semibold text-dark mb-2">
    <i data-lucide="pizza" style="width: 28px; height: 28px; color: #dc2626; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
    Pizze
  </h1>
  <p class="text-muted small mb-4">Gestisci le pizze del tuo menu</p>

  <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
    <a href="{{ route('admin.pizzas.create') }}"
       class="btn btn-outline-primary btn-sm"
       aria-label="Aggiungi una nuova pizza">
      <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Nuova Pizza
    </a>
    <span class="text-muted small">
      @php $total = method_exists($pizzas,'total') ? $pizzas->total() : ($pizzas->count() ?? 0); @endphp
      {{ $total }} {{ $total == 1 ? 'elemento' : 'elementi' }}
    </span>
  </div>
</div>
@endsection

@section('content')
  @php $count = ($pizzas->count() ?? 0); @endphp

  @if($count === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4"><i data-lucide="pizza" style="width: 64px; height: 64px; color: #dc2626; opacity: .4;"></i></div>
          <h3 class="h5 fw-semibold text-dark mb-3">Nessuna pizza presente</h3>
          <p class="text-muted small mb-4">Crea la prima pizza per iniziare.</p>
          <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.pizzas.create') }}" aria-label="Crea la prima pizza">
            <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Crea Prima Pizza
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
                    <i data-lucide="eye" style="width: 14px; height: 14px; margin-right: 4px;"></i><span class="d-none d-md-inline">Dettagli</span>
                  </a>
                  <a href="{{ route('admin.pizzas.edit', $pizza) }}" class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Modifica">
                    <i data-lucide="pencil" style="width: 14px; height: 14px; margin-right: 4px;"></i><span class="d-none d-md-inline">Modifica</span>
                  </a>
                  <form method="POST" action="{{ route('admin.pizzas.destroy', $pizza) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center w-100" data-bs-toggle="tooltip" title="Elimina">
                      <i data-lucide="trash-2" style="width: 14px; height: 14px; margin-right: 4px;"></i><span class="d-none d-md-inline">Elimina</span>
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
<link rel="stylesheet" href="{{ asset('css/pizza-index.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/pizza-index.js') }}"></script>
@endpush
