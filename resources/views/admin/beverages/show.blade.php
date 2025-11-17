@extends('layouts.app-modern')

@section('title', $beverage->name)

@section('header')
<div class="text-center py-4">
    <h3 class="fw-semibold mb-2">
        <i data-lucide="eye" style="width: 24px; height: 24px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
        {{ $beverage->name }}
    </h3>
    <p class="text-muted mb-0">Dettagli della bevanda</p>
</div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
                
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <p class="mb-1"><strong>Prezzo:</strong> € {{ number_format($beverage->price, 2, ',', '.') }}</p>
                        @if($beverage->description)
                          <p class="mb-3">{{ $beverage->description }}</p>
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.beverages.index') }}" class="btn btn-outline-secondary btn-sm">
                        Torna all'elenco
                    </a>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.beverages.edit', $beverage) }}" class="btn btn-outline-info btn-sm">
                            <i data-lucide="pencil" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
                            Modifica
                        </a>
                        <form action="{{ route('admin.beverages.destroy', $beverage) }}" method="POST" data-confirm="Sicuro?" class="d-inline">
                            @csrf
                            @method('DELETE')
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
