@extends('layouts.app-modern')

@section('title', 'Dashboard')

@section('header')
<div class="text-center py-4">
    <h1 class="display-5 fw-bold text-dark">
        <i data-lucide="layout-dashboard" style="width: 40px; height: 40px; display: inline-block; vertical-align: middle; margin-right: 12px;"></i>
        Dashboard
    </h1>
    <p class="lead text-muted">Gestione rapida del menu</p>
</div>
@endsection

@section('content')

    {{-- Azioni Principali Semplificate --}}
    <div class="row justify-content-center mb-5">
        <div class="col-12 text-center mb-4">
            <h2 class="h4 fw-semibold text-dark">
                <i data-lucide="plus-circle" style="width: 24px; height: 24px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
                Crea Nuovo Prodotto
            </h2>
            <p class="text-muted small">Seleziona la categoria per aggiungere un nuovo elemento al menu</p>
        </div>
        
        {{-- 4 Azioni Principali con icone grandi --}}
        <div class="col-lg-10">
            <div class="row g-4">
                <div class="col-md-6">
                    <a href="{{ route('admin.pizzas.create') }}" 
                       class="card h-100 text-decoration-none border hover-card" 
                       style="border-color: #e5e7eb !important; transition: all 0.3s ease;"
                       aria-label="Crea una nuova pizza"
                       tabindex="0">
                        <div class="card-body text-center py-5">
                            <div class="mb-3 d-flex justify-content-center align-items-center" style="height: 80px;">
                                <i data-lucide="pizza" style="width: 64px; height: 64px; stroke-width: 1.8; color: #dc2626;"></i>
                            </div>
                            <h3 class="h5 fw-semibold text-dark mb-2">Pizza</h3>
                            <p class="text-muted small mb-4">Aggiungi una nuova pizza al menu</p>
                            <span class="btn btn-outline-primary btn-sm">
                                <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Nuova Pizza
                            </span>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="{{ route('admin.appetizers.create') }}" 
                       class="card h-100 text-decoration-none border hover-card" 
                       style="border-color: #e5e7eb !important; transition: all 0.3s ease;"
                       aria-label="Crea un nuovo antipasto">
                        <div class="card-body text-center py-5">
                            <div class="mb-3 d-flex justify-content-center align-items-center" style="height: 80px;">
                                <i data-lucide="salad" style="width: 64px; height: 64px; stroke-width: 1.8; color: #059669;"></i>
                            </div>
                            <h3 class="h5 fw-semibold text-dark mb-2">Antipasto</h3>
                            <p class="text-muted small mb-4">Aggiungi un nuovo antipasto al menu</p>
                            <span class="btn btn-outline-success btn-sm">
                                <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Nuovo Antipasto
                            </span>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="{{ route('admin.beverages.create') }}" 
                       class="card h-100 text-decoration-none border hover-card" 
                       style="border-color: #e5e7eb !important; transition: all 0.3s ease;"
                       aria-label="Crea una nuova bevanda">
                        <div class="card-body text-center py-5">
                            <div class="mb-3 d-flex justify-content-center align-items-center" style="height: 80px;">
                                <i data-lucide="glass-water" style="width: 64px; height: 64px; stroke-width: 1.8; color: #2563eb;"></i>
                            </div>
                            <h3 class="h5 fw-semibold text-dark mb-2">Bevanda</h3>
                            <p class="text-muted small mb-4">Aggiungi una nuova bevanda al menu</p>
                            <span class="btn btn-outline-info btn-sm">
                                <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Nuova Bevanda
                            </span>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="{{ route('admin.desserts.create') }}" 
                       class="card h-100 text-decoration-none border hover-card" 
                       style="border-color: #e5e7eb !important; transition: all 0.3s ease;"
                       aria-label="Crea un nuovo dessert">
                        <div class="card-body text-center py-5">
                            <div class="mb-3 d-flex justify-content-center align-items-center" style="height: 80px;">
                                <i data-lucide="cake" style="width: 64px; height: 64px; stroke-width: 1.8; color: #d97706;"></i>
                            </div>
                            <h3 class="h5 fw-semibold text-dark mb-2">Dessert</h3>
                            <p class="text-muted small mb-4">Aggiungi un nuovo dolce al menu</p>
                            <span class="btn btn-outline-warning btn-sm">
                                <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Nuovo Dessert
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Divisore Visivo --}}
    <hr class="my-5 border-3">

    {{-- Visualizza Menu Esistente --}}
    <div class="row justify-content-center">
        <div class="col-12 text-center mb-4">
            <h2 class="h4 fw-semibold text-dark">
                <i data-lucide="list" style="width: 24px; height: 24px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
                Menu Attuale
            </h2>
            <p class="text-muted small">Panoramica degli elementi presenti nel menu</p>
        </div>
        
        <div class="col-lg-10">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('admin.pizzas.index') }}" class="card text-decoration-none border h-100 hover-card" style="border-color: #e5e7eb !important; transition: all 0.3s ease;">
                        <div class="card-body text-center py-4">
                            <div class="mb-3">
                                <i data-lucide="pizza" style="width: 40px; height: 40px; stroke-width: 1.8; color: #dc2626;"></i>
                            </div>
                            <h5 class="h6 fw-semibold text-dark mb-2">Pizze</h5>
                            <div class="display-6 fw-bold text-dark mb-1">{{ $countPizzas ?? 0 }}</div>
                            <div class="small text-muted">elementi totali</div>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('admin.appetizers.index') }}" class="card text-decoration-none border h-100 hover-card" style="border-color: #e5e7eb !important; transition: all 0.3s ease;">
                        <div class="card-body text-center py-4">
                            <div class="mb-3">
                                <i data-lucide="salad" style="width: 40px; height: 40px; stroke-width: 1.8; color: #059669;"></i>
                            </div>
                            <h5 class="h6 fw-semibold text-dark mb-2">Antipasti</h5>
                            <div class="display-6 fw-bold text-dark mb-1">{{ $countAppetizers ?? 0 }}</div>
                            <div class="small text-muted">elementi totali</div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('admin.beverages.index') }}" class="card text-decoration-none border h-100 hover-card" style="border-color: #e5e7eb !important; transition: all 0.3s ease;">
                        <div class="card-body text-center py-4">
                            <div class="mb-3">
                                <i data-lucide="glass-water" style="width: 40px; height: 40px; stroke-width: 1.8; color: #2563eb;"></i>
                            </div>
                            <h5 class="h6 fw-semibold text-dark mb-2">Bevande</h5>
                            <div class="display-6 fw-bold text-dark mb-1">{{ $countBeverages ?? 0 }}</div>
                            <div class="small text-muted">elementi totali</div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('admin.desserts.index') }}" class="card text-decoration-none border h-100 hover-card" style="border-color: #e5e7eb !important; transition: all 0.3s ease;">
                        <div class="card-body text-center py-4">
                            <div class="mb-3">
                                <i data-lucide="cake" style="width: 40px; height: 40px; stroke-width: 1.8; color: #d97706;"></i>
                            </div>
                            <h5 class="h6 fw-semibold text-dark mb-2">Dessert</h5>
                            <div class="display-6 fw-bold text-dark mb-1">{{ $countDesserts ?? 0 }}</div>
                            <div class="small text-muted">elementi totali</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Sezione Aiuto in basso --}}
    @if(($countPizzas ?? 0) + ($countAppetizers ?? 0) + ($countBeverages ?? 0) + ($countDesserts ?? 0) == 0)
    <div class="row justify-content-center mt-5">
        <div class="col-lg-8">
            <div class="alert alert-info border-0 shadow-sm text-center py-4" style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">
                <div class="mb-3">
                    <i data-lucide="lightbulb" style="width: 64px; height: 64px; stroke-width: 1.5; color: #fbbf24;"></i>
                </div>
                <h4 class="fw-bold text-dark">Inizia subito!</h4>
                <p class="mb-3">Il tuo menu è ancora vuoto. Inizia aggiungendo la tua prima pizza!</p>
                <a href="{{ route('admin.pizzas.create') }}" class="btn btn-success btn-lg fw-bold">
                    <i data-lucide="rocket" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>Crea la Prima Pizza
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- CSS per effetti hover --}}
    <style>
    /* Focus accessibile per navigazione da tastiera (WCAG 2.2) */
    .hover-card:focus-visible {
        outline: 3px solid #3b82f6;
        outline-offset: 2px;
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3) !important;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
    
    .hover-card:hover .btn {
        transform: scale(1.05);
    }
    
    .hover-card .btn {
        transition: transform 0.2s ease;
    }
    
    /* Rispetto prefers-reduced-motion per accessibilità */
    @media (prefers-reduced-motion: reduce) {
        .hover-card,
        .hover-card .btn,
        .first-time-indicator {
            transition: none !important;
            animation: none !important;
        }
        
        .hover-card:hover {
            transform: none !important;
        }
    }
    
    /* Skeleton loading per numeri (UX moderna) */
    .skeleton-number {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s ease-in-out infinite;
        border-radius: 4px;
        display: inline-block;
        width: 60px;
        height: 48px;
    }
    
    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    
    /* Tour guidato per nuovi utenti */
    .tour-highlight {
        position: relative;
        z-index: 1000;
    }
    
    .tour-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.7);
        z-index: 999;
        display: none;
    }
    
    .tour-tooltip {
        position: absolute;
        background: #fff;
        border: 2px solid #28a745;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        max-width: 250px;
        z-index: 1001;
        display: none;
    }
    
    .tour-tooltip::before {
        content: '';
        position: absolute;
        top: -10px;
        left: 20px;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        border-bottom: 10px solid #28a745;
    }
    
    /* Indicazioni visive per primo utilizzo */
    .first-time-indicator {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    </style>

    {{-- JavaScript per accessibilità e tour guidato --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inizializza i tooltips Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Loading state per navigazione (UX feedback immediato)
        document.querySelectorAll('.hover-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Mostra feedback visivo immediato
                const btn = this.querySelector('.btn');
                if (btn) {
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<span class=\"spinner-border spinner-border-sm me-2\" role=\"status\" aria-hidden=\"true\"></span>Caricamento...';
                    btn.classList.add('disabled');
                }
                
                // Aggiungi overlay di caricamento leggero
                this.style.opacity = '0.7';
                this.style.cursor = 'wait';
            });
        });
        
        // Controlla se è il primo accesso dell'utente
        const isFirstTime = !localStorage.getItem('pizzeria_visited');
        
        if (isFirstTime) {
            // Mostra indicatori per prime volte
            showFirstTimeIndicators();
            
            // Avvia tour guidato dopo 2 secondi
            setTimeout(() => {
                startGuidedTour();
            }, 2000);
        }
        
        // Migliora navigazione da tastiera
        document.querySelectorAll('.hover-card').forEach(card => {
            card.addEventListener('focus', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
            });
            
            card.addEventListener('blur', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
            });
        });
    });
    
    function showFirstTimeIndicators() {
        // Aggiungi indicatori pulsanti sui elementi principali
        const mainActions = document.querySelectorAll('.col-md-6 .card');
        mainActions.forEach(card => {
            const indicator = document.createElement('div');
            indicator.className = 'first-time-indicator';
            indicator.textContent = '!';
            card.style.position = 'relative';
            card.appendChild(indicator);
        });
    }
    
    function startGuidedTour() {
        const steps = [
            {
                element: '.col-md-6:first-child .card',
                message: 'Benvenuto! Questo è il modo più semplice per aggiungere una pizza. Clicca qui per iniziare!'
            },
            {
                element: '.col-lg-10:last-child',
                message: 'Qui puoi vedere tutto quello che hai già creato nel tuo menu'
            }
        ];
        
        showTourStep(0, steps);
    }
    
    function showTourStep(stepIndex, steps) {
        if (stepIndex >= steps.length) {
            endTour();
            return;
        }
        
        const step = steps[stepIndex];
        const element = document.querySelector(step.element);
        
        if (!element) {
            showTourStep(stepIndex + 1, steps);
            return;
        }
        
        // Mostra overlay
        const overlay = document.createElement('div');
        overlay.className = 'tour-overlay';
        overlay.style.display = 'block';
        document.body.appendChild(overlay);
        
        // Evidenzia elemento
        element.classList.add('tour-highlight');
        element.style.position = 'relative';
        element.style.zIndex = '1000';
        
        // Mostra tooltip
        const tooltip = document.createElement('div');
        tooltip.className = 'tour-tooltip';
        tooltip.innerHTML = `
            <div class="fw-bold mb-2">${step.message}</div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-sm btn-outline-secondary" onclick="endTour()">Salta</button>
                <button class="btn btn-sm btn-success" onclick="nextTourStep(${stepIndex + 1}, ${JSON.stringify(steps).replace(/"/g, '&quot;')})">
                    ${stepIndex === steps.length - 1 ? 'Fine' : 'Avanti'}
                </button>
            </div>
        `;
        
        // Posiziona tooltip
        const rect = element.getBoundingClientRect();
        tooltip.style.display = 'block';
        tooltip.style.top = (rect.bottom + 15) + 'px';
        tooltip.style.left = Math.max(10, rect.left) + 'px';
        
        document.body.appendChild(tooltip);
        
        // Memorizza elementi per cleanup
        window.currentTourOverlay = overlay;
        window.currentTourTooltip = tooltip;
        window.currentTourElement = element;
    }
    
    function nextTourStep(nextIndex, steps) {
        // Pulisci step corrente
        if (window.currentTourOverlay) {
            window.currentTourOverlay.remove();
        }
        if (window.currentTourTooltip) {
            window.currentTourTooltip.remove();
        }
        if (window.currentTourElement) {
            window.currentTourElement.classList.remove('tour-highlight');
            window.currentTourElement.style.position = '';
            window.currentTourElement.style.zIndex = '';
        }
        
        // Mostra prossimo step
        showTourStep(nextIndex, steps);
    }
    
    function endTour() {
        // Pulisci tutto
        if (window.currentTourOverlay) {
            window.currentTourOverlay.remove();
        }
        if (window.currentTourTooltip) {
            window.currentTourTooltip.remove();
        }
        if (window.currentTourElement) {
            window.currentTourElement.classList.remove('tour-highlight');
            window.currentTourElement.style.position = '';
            window.currentTourElement.style.zIndex = '';
        }
        
        // Rimuovi indicatori
        document.querySelectorAll('.first-time-indicator').forEach(indicator => {
            indicator.remove();
        });
        
        // Segna come visitato
        localStorage.setItem('pizzeria_visited', 'true');
    }
    </script>

@endsection
