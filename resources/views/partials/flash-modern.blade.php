{{-- Flash messages moderni con toast-style --}}
@if ((session('status') && !in_array(session('status'), ['profile-updated', 'password-updated'])) || session('success'))
    <div class="alert alert-success d-flex align-items-center slide-up" data-auto-dismiss="10000" role="alert">
        <div class="me-2">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="flex-grow-1">
            <strong>Successo!</strong>
            {{ session('status') ?? session('success') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error') || session('danger'))
    <div class="alert alert-danger d-flex align-items-center slide-up" data-auto-dismiss="10000" role="alert">
        <div class="me-2">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="flex-grow-1">
            <strong>Errore!</strong>
            {{ session('error') ?? session('danger') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning d-flex align-items-center slide-up" data-auto-dismiss="10000" role="alert">
        <div class="me-2">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div class="flex-grow-1">
            <strong>Attenzione!</strong>
            {{ session('warning') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info d-flex align-items-center slide-up" data-auto-dismiss="10000" role="alert">
        <div class="me-2">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="flex-grow-1">
            <strong>Info:</strong>
            {{ session('info') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Validation errors summary --}}
@if ($errors->any())
    <div class="alert alert-danger slide-up" role="alert">
        <div class="d-flex align-items-start">
            <div class="me-2 mt-1">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="flex-grow-1">
                <strong>Correggi i seguenti errori:</strong>
                <ul class="mb-0 mt-2 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

<link rel="stylesheet" href="{{ asset('css/flash-alerts.css') }}">
<script src="{{ asset('js/flash-alerts.js') }}"></script>