@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var overlay = document.getElementById('profile-success-overlay');
        var showOverlay = false;
        // Mostra overlay se hash oppure session status (inserito come attributo data-status)
        if (window.location.hash === '#success-profile' || window.location.hash === '#success-password') {
            showOverlay = true;
        }
        if (overlay && overlay.dataset.status === 'profile-updated') {
            showOverlay = true;
        }
        if (overlay && overlay.dataset.status === 'password-updated') {
            showOverlay = true;
        }
        if (showOverlay && overlay) {
            overlay.classList.remove('d-none');
        }
        document.querySelectorAll('.close-profile-success').forEach(function(btn) {
            btn.addEventListener('click', function() {
                overlay.classList.add('d-none');
                window.location.hash = '';
            });
        });
    });
</script>
@endpush
@extends('layouts.app-modern')

@section('title', 'Profilo personale')

@section('header')
<div class="text-center py-4">
    <div class="mb-2"><i data-lucide="user-cog" style="width: 48px; height: 48px; color: #6366f1;"></i></div>
    <h1 class="display-6 fw-bold text-dark mb-2">Profilo personale</h1>
    <p class="lead text-muted mb-4">Gestisci i dati del tuo profilo, la password e l'account</p>
</div>
@endsection

@section('content')
<div class="d-flex justify-content-center">
    <div class="w-100" style="max-width: 520px;">
        {{-- Tabs --}}
        <ul class="nav nav-tabs mb-4 justify-content-center" id="profileTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
                    <i class="fas fa-user me-1"></i> Dati profilo
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">
                    <i class="fas fa-key me-1"></i> Password
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="delete-tab" data-bs-toggle="tab" data-bs-target="#delete" type="button" role="tab" aria-controls="delete" aria-selected="false">
                    <i class="fas fa-user-slash me-1"></i> Elimina account
                </button>
            </li>
        </ul>
        <div class="tab-content" id="profileTabContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                @include('profile.partials.update-profile-information-form')
            </div>
            <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab" tabindex="0">
                @include('profile.partials.update-password-form')
            </div>
            <div class="tab-pane fade" id="delete" role="tabpanel" aria-labelledby="delete-tab" tabindex="0">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>

{{-- Overlay di conferma salvataggio --}}
<div id="profile-success-overlay" class="position-fixed top-0 start-0 w-100 h-100 d-none" style="z-index: 2000; background: rgba(0,0,0,0.35);" data-status="{{ session('status') }}">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="bg-white rounded shadow p-4 text-center" style="min-width:320px;max-width:90vw;">
            <div class="mb-3"><i data-lucide="check-circle" style="width: 40px; height: 40px; color: #10b981;"></i></div>
            @php $status = session('status'); @endphp
            @if($status === 'profile-updated')
                <h5 class="mb-3">Dati profilo aggiornati correttamente.</h5>
            @elseif($status === 'password-updated')
                <h5 class="mb-3">Password aggiornata correttamente.</h5>
            @else
                <h5 class="mb-3">Operazione completata con successo.</h5>
            @endif
            <a href="{{ route('dashboard') }}" class="btn btn-success px-4">Torna al pannello di gestione</a>
            <button type="button" class="btn btn-link mt-2 close-profile-success">Chiudi</button>
        </div>
    </div>
</div>
@endsection
