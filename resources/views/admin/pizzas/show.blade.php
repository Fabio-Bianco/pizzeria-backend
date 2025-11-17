@extends('layouts.app-modern')

@section('title', $pizza->name)

@section('header')
<div class="text-center py-4">
    <h3 class="fw-semibold mb-2">
        <i data-lucide="eye" style="width: 24px; height: 24px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
        {{ $pizza->name }}
    </h3>
    <p class="text-muted mb-0">Dettagli della pizza</p>
</div>
@endsection

@section('content')
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8">
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <div class="d-flex gap-3 align-items-start">
              @if($pizza->image_path)
                <img src="{{ asset('storage/'.$pizza->image_path) }}" alt="{{ $pizza->name }}" class="rounded" style="width:140px;height:140px;object-fit:cover;">
              @endif
              <div>
                <p class="mb-1"><strong>Categoria:</strong> {{ $pizza->category?->name ?? '-' }}</p>
                <p class="mb-1"><strong>Prezzo:</strong> € {{ number_format($pizza->price, 2, ',', '.') }}</p>
                @if($pizza->description)
                  <p class="mb-2">{{ $pizza->description }}</p>
                @endif
                <div class="mt-2">
                  <strong>Ingredienti:</strong>
                  <ul class="mt-2">
                    @forelse ($pizza->ingredients as $ingredient)
                      <li>{{ $ingredient->name }}</li>
                    @empty
                      <li class="text-muted">Nessuno</li>
                    @endforelse
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
          <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-secondary btn-sm">
            Torna all'elenco
          </a>
          <div class="d-flex gap-2">
            <a href="{{ route('admin.pizzas.edit', $pizza) }}" class="btn btn-outline-primary btn-sm">
              <i data-lucide="pencil" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
              Modifica
            </a>
            <form action="{{ route('admin.pizzas.destroy', $pizza) }}" method="POST" data-confirm="Sicuro?" class="d-inline">
              @csrf @method('DELETE')
              <button class="btn btn-outline-danger btn-sm" type="submit">
                <i data-lucide="trash-2" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
                Elimina
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection
