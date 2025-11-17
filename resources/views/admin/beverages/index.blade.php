@extends('layouts.app-modern')

@section('title', 'Le Tue Bevande')

@section('header')
<div class="text-center py-4">
  <div class="mb-2"><i data-lucide="glass-water" style="width: 48px; height: 48px; color: #3b82f6;"></i></div>
  <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Bevande</h1>
  <p class="lead text-muted mb-4">Bibite, vini e birre del tuo menu</p>

  <div class="d-flex justify-content-center mb-4">
    <a href="{{ route('admin.beverages.create') }}"
       class="btn btn-create btn-lg px-4 py-3"
       role="button"
       aria-label="Aggiungi una nuova bevanda"
       data-bs-toggle="tooltip" title="Crea una nuova bevanda">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuova Bevanda
    </a>
  </div>

  <div class="visually-hidden" aria-live="polite" aria-atomic="true" id="view-change-announce"></div>
  <div class="mt-3">
    @php $total = method_exists($beverages,'total') ? $beverages->total() : ($beverages->count() ?? 0); @endphp
    <span class="badge bg-success fs-6 px-3 py-2">Hai {{ $total }} {{ $total == 1 ? 'bevanda' : 'bevande' }} nel menu</span>
  </div>
</div>
@endsection

@section('content')
  @php $count = ($beverages->count() ?? 0); @endphp

  @if($count === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4"><i data-lucide="glass-water" style="width: 80px; height: 80px; color: #3b82f6; opacity: .5;"></i></div>
          <h3 class="fw-bold text-dark mb-3">Nessuna bevanda presente</h3>
          <p class="text-muted mb-4">Aggiungi la prima bevanda al tuo menu.</p>
          <a class="btn btn-success btn-lg px-4 py-3 fw-bold" href="{{ route('admin.beverages.create') }}">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea la Prima Bevanda
          </a>
        </div>
      </div>
    </div>
  @else
    <div id="beverages-container" class="transition-container list-wrapper">
      <div class="list-container">
        @foreach($beverages as $b)
          <div class="pizza-card card shadow-sm border-0 mb-3">
            <div class="card-body py-3 px-3">
              <div class="d-flex align-items-center gap-3 flex-wrap flex-md-nowrap">
                <div class="pizza-icon flex-shrink-0 d-flex align-items-center justify-content-center bg-light rounded-circle" style="height:56px;width:56px;">
                  @if(!empty($b->image_path))
                    <img src="{{ asset('storage/'.$b->image_path) }}" alt="Bevanda {{ $b->name }}" class="img-fluid rounded-circle" style="height:56px;width:56px;object-fit:cover;">
                  @else
                    <i class="fas fa-wine-bottle text-info fs-3" aria-hidden="true"></i>
                  @endif
                </div>
                <div class="flex-grow-1 min-w-0">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="fw-bold fs-5 text-dark text-truncate" style="max-width:220px;">{{ $b->name }}</span>
                  </div>
                  @if(!empty($b->description))
                    <div class="mb-1"><small class="text-muted text-truncate d-block" style="max-width:320px;">{{ \Illuminate\Support\Str::limit($b->description, 120) }}</small></div>
                  @endif
                </div>
                <div class="pizza-actions d-flex flex-column flex-md-row gap-2 ms-md-3 mt-3 mt-md-0">
                  <a href="{{ route('admin.beverages.show', $b) }}" class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Dettagli" style="border:1.5px solid #1976d2;color:#1976d2;background:transparent;">
                    <i class="fas fa-eye me-1" style="color:#1976d2;"></i><span class="d-none d-md-inline" style="color:#1976d2;">Dettagli</span>
                  </a>
                  <a href="{{ route('admin.beverages.edit', $b) }}" class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Modifica" style="border:1.5px solid #388e3c;color:#388e3c;background:transparent;">
                    <i class="fas fa-edit me-1" style="color:#388e3c;"></i><span class="d-none d-md-inline" style="color:#388e3c;">Modifica</span>
                  </a>
                  <form method="POST" action="{{ route('admin.beverages.destroy', $b) }}">
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

      @if(method_exists($beverages,'hasPages') && $beverages->hasPages())
        <div class="d-flex justify-content-center mt-5">{{ $beverages->links() }}</div>
      @endif
    </div>
  @endif
@endsection

@push('styles')
<style>
  .list-wrapper, .list-container { overflow: visible; }
  .actions-flex .btn { min-width: 110px; white-space: nowrap; }
  @media (max-width: 576px) { .actions-flex .btn { min-width: 100%; } }
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
