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
@if(session('status') === 'profile-updated' || session('status') === 'password-updated')
<div id="profile-success-overlay" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 9999; background: rgba(0,0,0,0.6); display: flex; justify-content: center; align-items: center; overflow: hidden;">
    <div class="bg-white rounded-3 shadow-lg p-4 text-center" style="width: 420px; max-width: 90vw; position: relative;">
        <div class="mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        </div>
        @if(session('status') === 'profile-updated')
            <h5 class="mb-2 fw-semibold">Dati profilo aggiornati</h5>
            <p class="text-muted small mb-4">Le tue informazioni sono state salvate correttamente</p>
        @elseif(session('status') === 'password-updated')
            <h5 class="mb-2 fw-semibold">Password aggiornata</h5>
            <p class="text-muted small mb-4">La tua password è stata modificata correttamente</p>
        @endif
        <div class="d-flex gap-2 justify-content-center">
            <button type="button" class="btn btn-success btn-sm px-4" onclick="document.getElementById('profile-success-overlay').style.display='none'">OK</button>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm px-3">Dashboard</a>
        </div>
    </div>
</div>

<style>
    body:has(#profile-success-overlay) {
        overflow: hidden;
    }
</style>
@endif

<script src="{{ asset('js/profile-edit.js') }}"></script>
<script src="{{ asset('js/avatar-preview.js') }}"></script>
@endsection
