@extends('layouts.app-modern')

@section('title', 'Ingredienti')

@section('header')
<div class="text-center py-4">
  <h1 class="h3 fw-semibold text-dark mb-2">
    <i data-lucide="leaf" style="width: 28px; height: 28px; color: #10b981; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
    Ingredienti
  </h1>
  <p class="text-muted small mb-4">Gestisci gli ingredienti del menu</p>

  <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
    <a href="{{ route('admin.ingredients.create') }}"
       class="btn btn-outline-success btn-sm"
       aria-label="Aggiungi un nuovo ingrediente">
      <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Nuovo Ingrediente
    </a>
    <span class="text-muted small">
      @php $total = method_exists($ingredients,'total') ? $ingredients->total() : ($ingredients->count() ?? 0); @endphp
      {{ $total }} {{ $total == 1 ? 'elemento' : 'elementi' }}
    </span>
  </div>
</div>
@endsection

@section('content')
  @if(($ingredients->count() ?? 0) === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4"><i data-lucide="leaf" style="width: 64px; height: 64px; color: #10b981; opacity: .4;"></i></div>
          <h3 class="h5 fw-semibold text-dark mb-3">Nessun ingrediente presente</h3>
          <p class="text-muted small mb-4">Crea il primo ingrediente per iniziare.</p>
          <a class="btn btn-outline-success btn-sm" href="{{ route('admin.ingredients.create') }}" aria-label="Crea il primo ingrediente">
            <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Crea Primo Ingrediente
          </a>
        </div>
      </div>
    </div>
  @else
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <div class="card border" style="border-color: #e5e7eb !important;">
          <div class="card-body p-0">
            @foreach($ingredients as $ingredient)
              <div class="d-flex align-items-center p-3 border-bottom" style="border-color: #f3f4f6 !important;">
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
               class="btn btn-outline-success btn-sm d-flex align-items-center gap-1"
               title="Modifica ingrediente">
              <i data-lucide="pencil" style="width: 14px; height: 14px;"></i> <span>Modifica</span>
            </a>
            <form action="{{ route('admin.ingredients.destroy', $ingredient) }}" method="POST" data-confirm="Sicuro?" class="d-inline">
              @csrf @method('DELETE')
              <button type="submit"
                      class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1"
                      title="Elimina ingrediente">
                <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i> <span>Elimina</span>
              </button>
            </form>
          </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    @if(method_exists($ingredients,'hasPages') && $ingredients->hasPages())
      <div class="d-flex justify-content-center mt-5">
        {{ $ingredients->links() }}
      </div>
    @endif
  @endif
@endsection