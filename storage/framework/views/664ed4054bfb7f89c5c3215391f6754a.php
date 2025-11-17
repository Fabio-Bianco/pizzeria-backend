<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
    <h1 class="display-5 fw-bold text-dark">
        <i data-lucide="home" style="width: 40px; height: 40px; display: inline-block; vertical-align: middle; margin-right: 12px;"></i>
        Benvenuto nella tua Pizzeria
    </h1>
    <p class="lead text-muted">Cosa vuoi fare oggi?</p>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    
    <div class="row justify-content-center mb-5">
        <div class="col-12 text-center mb-4">
            <h2 class="h3 fw-bold text-dark">
                <i data-lucide="utensils-crossed" style="width: 28px; height: 28px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
                Cosa vuoi aggiungere al menu?
            </h2>
            <p class="text-muted">Clicca su una delle opzioni qui sotto</p>
        </div>
        
        
        <div class="col-lg-10">
            <div class="row g-4">
                <div class="col-md-6">
                    <a href="<?php echo e(route('admin.pizzas.create')); ?>" 
                       class="card h-100 text-decoration-none border-0 shadow-sm hover-card" 
                       style="transition: all 0.3s ease;"
                       data-bs-toggle="tooltip" 
                       data-bs-placement="top" 
                       title="Clicca qui per aggiungere una nuova pizza al menu"
                       tabindex="0">
                        <div class="card-body text-center py-5">
                            <div class="mb-3">
                                <i data-lucide="pizza" style="width: 80px; height: 80px; stroke-width: 1.5; color: #ef4444;"></i>
                            </div>
                            <h3 class="card-title fw-bold text-dark mb-2">Aggiungi Pizza</h3>
                            <p class="text-muted mb-3">Crea una nuova pizza per il tuo menu</p>
                            <span class="btn btn-success btn-lg fw-bold">
                                <i data-lucide="plus-circle" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>Crea Pizza
                            </span>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="<?php echo e(route('admin.appetizers.create')); ?>" class="card h-100 text-decoration-none border-0 shadow-sm hover-card" style="transition: all 0.3s ease;">
                        <div class="card-body text-center py-5">
                            <div class="mb-3">
                                <i data-lucide="salad" style="width: 80px; height: 80px; stroke-width: 1.5; color: #10b981;"></i>
                            </div>
                            <h3 class="card-title fw-bold text-dark mb-2">Aggiungi Antipasto</h3>
                            <p class="text-muted mb-3">Crea un nuovo antipasto per il tuo menu</p>
                            <span class="btn btn-success btn-lg fw-bold">
                                <i data-lucide="plus-circle" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>Crea Antipasto
                            </span>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="<?php echo e(route('admin.beverages.create')); ?>" class="card h-100 text-decoration-none border-0 shadow-sm hover-card" style="transition: all 0.3s ease;">
                        <div class="card-body text-center py-5">
                            <div class="mb-3">
                                <i data-lucide="glass-water" style="width: 80px; height: 80px; stroke-width: 1.5; color: #3b82f6;"></i>
                            </div>
                            <h3 class="card-title fw-bold text-dark mb-2">Aggiungi Bevanda</h3>
                            <p class="text-muted mb-3">Crea una nuova bevanda per il tuo menu</p>
                            <span class="btn btn-success btn-lg fw-bold">
                                <i data-lucide="plus-circle" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>Crea Bevanda
                            </span>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="<?php echo e(route('admin.desserts.create')); ?>" class="card h-100 text-decoration-none border-0 shadow-sm hover-card" style="transition: all 0.3s ease;">
                        <div class="card-body text-center py-5">
                            <div class="mb-3">
                                <i data-lucide="cake" style="width: 80px; height: 80px; stroke-width: 1.5; color: #f59e0b;"></i>
                            </div>
                            <h3 class="card-title fw-bold text-dark mb-2">Aggiungi Dessert</h3>
                            <p class="text-muted mb-3">Crea un nuovo dolce per il tuo menu</p>
                            <span class="btn btn-success btn-lg fw-bold">
                                <i data-lucide="plus-circle" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>Crea Dessert
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    
    <hr class="my-5 border-3">

    
    <div class="row justify-content-center">
        <div class="col-12 text-center mb-4">
            <h2 class="h3 fw-bold text-dark">
                <i data-lucide="eye" style="width: 28px; height: 28px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
                Guarda il tuo menu attuale
            </h2>
            <p class="text-muted">Controlla cosa hai già nel menu</p>
        </div>
        
        <div class="col-lg-10">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <a href="<?php echo e(route('admin.pizzas.index')); ?>" class="card text-decoration-none border-2 h-100 hover-card" style="border-color: #28a745 !important; transition: all 0.3s ease;">
                        <div class="card-body text-center py-4">
                            <div class="mb-2">
                                <i data-lucide="pizza" style="width: 48px; height: 48px; stroke-width: 1.5; color: #ef4444;"></i>
                            </div>
                            <h5 class="card-title text-dark fw-bold">Le Tue Pizze</h5>
                            <div class="badge bg-success fs-6 mb-2"><?php echo e($countPizzas ?? 0); ?> pizze</div>
                            <div class="small text-muted">Clicca per vedere tutte</div>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <a href="<?php echo e(route('admin.appetizers.index')); ?>" class="card text-decoration-none border-2 h-100 hover-card" style="border-color: #28a745 !important; transition: all 0.3s ease;">
                        <div class="card-body text-center py-4">
                            <div class="mb-2">
                                <i data-lucide="salad" style="width: 48px; height: 48px; stroke-width: 1.5; color: #10b981;"></i>
                            </div>
                            <h5 class="card-title text-dark fw-bold">I Tuoi Antipasti</h5>
                            <div class="badge bg-success fs-6 mb-2"><?php echo e($countAppetizers ?? 0); ?> antipasti</div>
                            <div class="small text-muted">Clicca per vedere tutti</div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-3">
                    <a href="<?php echo e(route('admin.beverages.index')); ?>" class="card text-decoration-none border-2 h-100 hover-card" style="border-color: #28a745 !important; transition: all 0.3s ease;">
                        <div class="card-body text-center py-4">
                            <div class="mb-2">
                                <i data-lucide="glass-water" style="width: 48px; height: 48px; stroke-width: 1.5; color: #3b82f6;"></i>
                            </div>
                            <h5 class="card-title text-dark fw-bold">Le Tue Bevande</h5>
                            <div class="badge bg-success fs-6 mb-2"><?php echo e($countBeverages ?? 0); ?> bevande</div>
                            <div class="small text-muted">Clicca per vedere tutte</div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-3">
                    <a href="<?php echo e(route('admin.desserts.index')); ?>" class="card text-decoration-none border-2 h-100 hover-card" style="border-color: #28a745 !important; transition: all 0.3s ease;">
                        <div class="card-body text-center py-4">
                            <div class="mb-2">
                                <i data-lucide="cake" style="width: 48px; height: 48px; stroke-width: 1.5; color: #f59e0b;"></i>
                            </div>
                            <h5 class="card-title text-dark fw-bold">I Tuoi Dessert</h5>
                            <div class="badge bg-success fs-6 mb-2"><?php echo e($countDesserts ?? 0); ?> dolci</div>
                            <div class="small text-muted">Clicca per vedere tutti</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    
    <?php if(($countPizzas ?? 0) + ($countAppetizers ?? 0) + ($countBeverages ?? 0) + ($countDesserts ?? 0) == 0): ?>
    <div class="row justify-content-center mt-5">
        <div class="col-lg-8">
            <div class="alert alert-info border-0 shadow-sm text-center py-4" style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">
                <div class="mb-3">
                    <i data-lucide="lightbulb" style="width: 64px; height: 64px; stroke-width: 1.5; color: #fbbf24;"></i>
                </div>
                <h4 class="fw-bold text-dark">Inizia subito!</h4>
                <p class="mb-3">Il tuo menu è ancora vuoto. Inizia aggiungendo la tua prima pizza!</p>
                <a href="<?php echo e(route('admin.pizzas.create')); ?>" class="btn btn-success btn-lg fw-bold">
                    <i data-lucide="rocket" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>Crea la Prima Pizza
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <style>
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

    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inizializza i tooltips Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/dashboard.blade.php ENDPATH**/ ?>