@extends('layouts.guest')

@section('title', 'Accedi')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-5">
        <!-- Logo centrato -->
        <div class="text-center mb-4">
            <div class="mb-3">
                <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" style="width: 64px; height: 64px;">
                    <circle cx="32" cy="32" r="30" fill="#fcd34d" stroke="#b45309" stroke-width="2"/>
                    <path d="M32 2 A30 30 0 0 1 62 32 L32 32 Z" fill="#ef4444"/>
                    <circle cx="24" cy="24" r="3" fill="#991b1b"/>
                    <circle cx="40" cy="22" r="3" fill="#991b1b"/>
                    <circle cx="36" cy="36" r="3" fill="#991b1b"/>
                </svg>
            </div>
            <h1 class="h3 fw-bold text-dark mb-1">Benvenuto</h1>
            <p class="text-muted mb-0">Accedi al pannello di gestione</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success d-flex align-items-center mb-4">
                <i data-lucide="check-circle" style="width: 20px; height: 20px; margin-right: 8px;"></i>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf
            
            <div class="mb-4">
                <label for="email" class="form-label fw-semibold">
                    <i data-lucide="mail" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
                    Email
                </label>
                <input id="email" type="email" name="email" 
                       class="form-control form-control-lg @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" 
                       required autofocus autocomplete="username"
                       placeholder="inserisci@email.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">
                    <i data-lucide="lock" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
                    Password
                </label>
                <input id="password" type="password" name="password" 
                       class="form-control form-control-lg @error('password') is-invalid @enderror" 
                       required autocomplete="current-password"
                       placeholder="••••••••">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" id="remember" type="checkbox" name="remember" 
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Ricordami
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100">
                <i data-lucide="log-in" style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
                Accedi
            </button>
        </form>
    </div>
</div>
@endsection
