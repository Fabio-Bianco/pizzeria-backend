@extends('layouts.app-modern')

@section('title', 'Categorie')

@section('header')
<div class="text-center py-4">
    <div class="mb-2"><i data-lucide="folder" style="width: 48px; height: 48px; color: #8b5cf6;"></i></div>
    <h1 class="display-6 fw-bold text-dark mb-2">Categorie</h1>
    <p class="lead text-muted mb-4">Gestisci le categorie delle pizze e dei prodotti</p>

    {{-- Bottone Aggiungi centrato --}}
    <div class="d-flex justify-content-center mb-4">
        <a href="{{ route('admin.categories.create') }}"
             class="btn btn-create btn-lg px-4 py-3"
             role="button"
             aria-label="Aggiungi una nuova categoria"
             data-bs-toggle="tooltip" 
             title="Crea una nuova categoria">
            <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuova Categoria
        </a>
    </div>

    @include('partials.flash')
</div>
@endsection

@section('content')
    <x-filter-toolbar
        search
        searchPlaceholder="Cerca per nome o descrizione…"
        :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A']"
        :reset-url="route('admin.categories.index')"
    />

    @if($categories->count() === 0)
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center py-5">
                    <div class="mb-4"><i data-lucide="folder" style="width: 80px; height: 80px; color: #8b5cf6; opacity: .5;"></i></div>
                    <h3 class="fw-bold text-dark mb-3">Nessuna categoria presente</h3>
                    <p class="text-muted mb-4">Crea la tua prima categoria per iniziare.</p>
                    <a class="btn btn-create btn-lg px-4 py-3" href="{{ route('admin.categories.create') }}">
                        <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea la Prima Categoria
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="list-container">
            @foreach($categories as $category)
                <div class="d-flex align-items-center list-item-pizza">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h6 class="mb-0 text-truncate">
                                <a href="{{ route('admin.categories.show', $category) }}" class="text-decoration-none">{{ $category->name }}</a>
                            </h6>
                            <span class="badge badge-info" title="Numero pizze in categoria">{{ $category->pizzas_count }} pizze</span>
                        </div>
                        @if($category->description)
                            <div class="text-muted small mb-1">{{ \Illuminate\Support\Str::limit($category->description, 120) }}</div>
                        @endif
                    </div>
                    <div class="d-flex align-items-center gap-2 ms-3 flex-shrink-0">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                             class="btn btn-success btn-sm d-flex align-items-center gap-1"
                             title="Modifica categoria">
                            <i class="fas fa-edit me-1" aria-hidden="true"></i> <span>Modifica</span>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" data-confirm="Sicuro?" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                            class="btn btn-danger btn-sm d-flex align-items-center gap-1"
                                            title="Elimina categoria">
                                <i class="fas fa-trash me-1" aria-hidden="true"></i> <span>Elimina</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($categories,'hasPages') && $categories->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $categories->links() }}
            </div>
        @endif
    @endif
@endsection
