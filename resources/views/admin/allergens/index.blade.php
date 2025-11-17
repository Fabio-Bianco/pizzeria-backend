@extends('layouts.app-modern')

@section('title', 'Allergeni')

@section('header')
<div class="text-center py-4">
    <h1 class="h3 fw-semibold text-dark mb-2">
        <i data-lucide="shield-alert" style="width: 28px; height: 28px; color: #dc2626; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
        Allergeni
    </h1>
    <p class="text-muted small mb-4">Gestisci gli allergeni del menu</p>

    <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
        <a href="{{ route('admin.allergens.create') }}"
             class="btn btn-outline-danger btn-sm"
             aria-label="Aggiungi un nuovo allergene">
            <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Nuovo Allergene
        </a>
        <span class="text-muted small">
            @php $total = method_exists($allergens,'total') ? $allergens->total() : ($allergens->count() ?? 0); @endphp
            {{ $total }} {{ $total == 1 ? 'elemento' : 'elementi' }}
        </span>
    </div>
</div>
@endsection

@section('content')
    @if($allergens->count() === 0)
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center py-5">
                    <div class="mb-4"><i data-lucide="shield-alert" style="width: 64px; height: 64px; color: #dc2626; opacity: .4;"></i></div>
                    <h3 class="h5 fw-semibold text-dark mb-3">Nessun allergene presente</h3>
                    <p class="text-muted small mb-4">Crea il primo allergene per iniziare.</p>
                    <a class="btn btn-outline-danger btn-sm" href="{{ route('admin.allergens.create') }}" aria-label="Crea il primo allergene">
                        <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Crea Primo Allergene
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card border" style="border-color: #e5e7eb !important;">
                    <div class="card-body p-0">
                        @foreach($allergens as $allergen)
                            <div class="d-flex align-items-center p-3 border-bottom" style="border-color: #f3f4f6 !important;">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-semibold text-dark">{{ $allergen->name }}</h6>
                                </div>
                                <div class="d-flex align-items-center gap-2 ms-3 flex-shrink-0">
                                    <a href="{{ route('admin.allergens.edit', $allergen) }}"
                                         class="btn btn-outline-success btn-sm d-flex align-items-center gap-1"
                                         title="Modifica allergene">
                                        <i data-lucide="pencil" style="width: 14px; height: 14px;"></i> <span>Modifica</span>
                                    </a>
                                    <form action="{{ route('admin.allergens.destroy', $allergen) }}" method="POST" data-confirm="Sicuro?" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                        class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1"
                                                        title="Elimina allergene">
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

        @if(method_exists($allergens,'hasPages') && $allergens->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $allergens->links() }}
            </div>
        @endif
    @endif
@endsection
