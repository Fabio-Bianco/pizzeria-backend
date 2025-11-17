@extends('layouts.app-modern')

@section('title', 'I Tuoi Dessert')

@section('header')
<div class="text-center py-4">
  <h1 class="h3 fw-semibold text-dark mb-2">
    <i data-lucide="cake" style="width: 28px; height: 28px; color: #d97706; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
    Dessert
  </h1>
  <p class="text-muted small mb-4">Gestisci i dessert del tuo menu</p>

  <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
    <a href="{{ route('admin.desserts.create') }}"
       class="btn btn-outline-warning btn-sm"
       aria-label="Aggiungi un nuovo dessert">
      <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Nuovo Dessert
    </a>
    <span class="text-muted small">
      @php $total = method_exists($desserts,'total') ? $desserts->total() : ($desserts->count() ?? 0); @endphp
      {{ $total }} {{ $total == 1 ? 'elemento' : 'elementi' }}
    </span>
  </div>
  <div class="visually-hidden" aria-live="polite" aria-atomic="true" id="view-change-announce"></div>
</div>
@endsection

@section('content')
  @php $count = ($desserts->count() ?? 0); @endphp

  @if($count === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4"><i data-lucide="cake" style="width: 64px; height: 64px; color: #d97706; opacity: .4;"></i></div>
          <h3 class="h5 fw-semibold text-dark mb-3">Nessun dessert presente</h3>
          <p class="text-muted small mb-4">Crea il primo dessert per iniziare.</p>
          <a class="btn btn-outline-warning btn-sm" href="{{ route('admin.desserts.create') }}" aria-label="Crea il primo dessert">
            <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Crea Primo Dessert
          </a>
        </div>
      </div>
    </div>
  @else
    <div id="desserts-container" class="transition-container list-wrapper">

      <div class="list-container">
        @foreach($desserts as $d)
          <div class="pizza-card card shadow-sm border-0 mb-3">
            <div class="card-body py-3 px-3">
              <div class="d-flex align-items-center gap-3 flex-wrap flex-md-nowrap">
                <div class="pizza-icon flex-shrink-0 d-flex align-items-center justify-content-center bg-light rounded-circle" style="height:56px;width:56px;">
                  @if(!empty($d->image_path))
                    <img src="{{ asset('storage/'.$d->image_path) }}" alt="Dolce {{ $d->name }}" class="img-fluid rounded-circle" style="height:56px;width:56px;object-fit:cover;">
                  @else
                    <i class="fas fa-cookie-bite text-warning fs-3" aria-hidden="true"></i>
                  @endif
                </div>
                <div class="flex-grow-1 min-w-0">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="d-flex align-items-center flex-wrap" style="min-width:0;">
                      <span class="fw-bold fs-5 text-dark text-truncate d-inline-block" style="max-width:220px;">{{ $d->name }}</span>
                    </div>
                    @if(!empty($d->is_gluten_free))
                      <span class="badge rounded-pill bg-glutenfree text-glutenfree ms-2 align-middle" style="font-size:0.85em;font-weight:600;padding:0.18em 0.7em;vertical-align:middle;letter-spacing:0.02em;" title="Senza glutine">Senza Glutine</span>
                    @endif
                  </div>
                  @if(!empty($d->description))
                    <div class="mb-1"><small class="text-muted text-truncate d-block" style="max-width:320px;">{{ \Illuminate\Support\Str::limit($d->description, 120) }}</small></div>
                  @endif
                  @php $collapseId = 'ingredients-collapse-dessert-'.$d->id; $collapseAllergenId = 'allergens-collapse-dessert-'.$d->id; @endphp
                  <div class="d-flex flex-row gap-2 mt-2">
                    <button class="btn btn-sm d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}" style="border:1.5px solid #8fd19e;color:#388e3c;background:transparent;">
                      <span style="font-size:1.2em;line-height:1;color:#388e3c;">&#9776;</span> <span>Vedi ingredienti</span>
                    </button>
                    <button class="btn btn-sm d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseAllergenId }}" aria-expanded="false" aria-controls="{{ $collapseAllergenId }}" style="border:1.5px solid #ffe066;color:#bfa100;background:transparent;">
                      <span style="font-size:1.2em;line-height:1;color:#bfa100;">&#9776;</span> <span>Vedi allergeni</span>
                    </button>
                  </div>
                  <div class="collapse mt-2 w-100" id="{{ $collapseId }}">
                    @if($d->ingredients && $d->ingredients->count() > 0)
                      <ul class="list-unstyled mb-0 ps-2 small">
                        @foreach($d->ingredients as $ingredient)
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
                    @if($d->allergens && $d->allergens->count() > 0)
                      <ul class="list-unstyled mb-0 ps-2 small">
                        @foreach($d->allergens as $allergen)
                          <li class="py-1 d-flex align-items-center gap-2">
                            <span>{{ $allergen->name }}</span>
                          </li>
                        @endforeach
                      </ul>
                    @else
                      <div class="text-muted small ps-2">Nessun allergene</div>
                    @endif
                  </div>
                </div>
                <div class="pizza-actions d-flex flex-column flex-md-row gap-2 ms-md-3 mt-3 mt-md-0">
                  <a href="{{ route('admin.desserts.show', $d) }}" class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Dettagli" style="border:1.5px solid #1976d2;color:#1976d2;background:transparent;">
                    <i class="fas fa-eye me-1" style="color:#1976d2;"></i><span class="d-none d-md-inline" style="color:#1976d2;">Dettagli</span>
                  </a>
                  <a href="{{ route('admin.desserts.edit', $d) }}" class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Modifica" style="border:1.5px solid #388e3c;color:#388e3c;background:transparent;">
                    <i class="fas fa-edit me-1" style="color:#388e3c;"></i><span class="d-none d-md-inline" style="color:#388e3c;">Modifica</span>
                  </a>
                  <form method="POST" action="{{ route('admin.desserts.destroy', $d) }}">
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

      @if(method_exists($desserts,'hasPages') && $desserts->hasPages())
        <div class="d-flex justify-content-center mt-5">{{ $desserts->links() }}</div>
      @endif
    </div>
  @endif
@endsection

@push('styles')
<style>
  .list-wrapper, .list-container { overflow: visible; }
  .actions-flex .btn { min-width: 110px; white-space: nowrap; }
  @media (max-width: 576px) {
    .actions-flex .btn { min-width: 100%; }
  }
  /* Badge vegano e senza glutine: palette rilassante */
  .bg-green-veg {
    background: #e6f4ea;
    border: 1.5px solid #6bbf59;
  }
  .text-green-veg {
    color: #388e3c !important;
  }
  .bg-glutenfree {
    background: #f3f6fa;
    border: 1.5px solid #7e9ebd;
  }
  .text-glutenfree {
    color: #3b5c7e !important;
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
