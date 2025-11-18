<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
    <h1 class="display-5 fw-bold text-dark">
        <i data-lucide="layout-dashboard" style="width: 40px; height: 40px; display: inline-block; vertical-align: middle; margin-right: 12px;"></i>
        Dashboard
    </h1>
    <p class="lead text-muted">Gestione rapida del menu</p>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    
    <div class="row justify-content-center mb-5">
        <div class="col-12 text-center mb-4">
            <h2 class="h4 fw-semibold text-dark">
                <i data-lucide="plus-circle" style="width: 24px; height: 24px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
                Crea Nuovo Prodotto
            </h2>
            <p class="text-muted small">Seleziona la categoria per aggiungere un nuovo elemento al menu</p>
        </div>
        
        
        <div class="col-lg-10">
            <div class="row g-4">
                <div class="col-md-6">
                    <a href="<?php echo e(route('admin.pizzas.create')); ?>" 
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
                    <a href="<?php echo e(route('admin.appetizers.create')); ?>" 
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
                    <a href="<?php echo e(route('admin.beverages.create')); ?>" 
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
                    <a href="<?php echo e(route('admin.desserts.create')); ?>" 
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

    
    <hr class="my-5 border-3">

    
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
                    <a href="<?php echo e(route('admin.pizzas.index')); ?>" class="card text-decoration-none border h-100 hover-card" style="border-color: #e5e7eb !important; transition: all 0.3s ease;">
                        <div class="card-body text-center py-4">
                            <div class="mb-3">
                                <i data-lucide="pizza" style="width: 40px; height: 40px; stroke-width: 1.8; color: #dc2626;"></i>
                            </div>
                            <h5 class="h6 fw-semibold text-dark mb-2">Pizze</h5>
                            <div class="display-6 fw-bold text-dark mb-1"><?php echo e($countPizzas ?? 0); ?></div>
                            <div class="small text-muted">elementi totali</div>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <a href="<?php echo e(route('admin.appetizers.index')); ?>" class="card text-decoration-none border h-100 hover-card" style="border-color: #e5e7eb !important; transition: all 0.3s ease;">
                        <div class="card-body text-center py-4">
                            <div class="mb-3">
                                <i data-lucide="salad" style="width: 40px; height: 40px; stroke-width: 1.8; color: #059669;"></i>
                            </div>
                            <h5 class="h6 fw-semibold text-dark mb-2">Antipasti</h5>
                            <div class="display-6 fw-bold text-dark mb-1"><?php echo e($countAppetizers ?? 0); ?></div>
                            <div class="small text-muted">elementi totali</div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-3">
                    <a href="<?php echo e(route('admin.beverages.index')); ?>" class="card text-decoration-none border h-100 hover-card" style="border-color: #e5e7eb !important; transition: all 0.3s ease;">
                        <div class="card-body text-center py-4">
                            <div class="mb-3">
                                <i data-lucide="glass-water" style="width: 40px; height: 40px; stroke-width: 1.8; color: #2563eb;"></i>
                            </div>
                            <h5 class="h6 fw-semibold text-dark mb-2">Bevande</h5>
                            <div class="display-6 fw-bold text-dark mb-1"><?php echo e($countBeverages ?? 0); ?></div>
                            <div class="small text-muted">elementi totali</div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-3">
                    <a href="<?php echo e(route('admin.desserts.index')); ?>" class="card text-decoration-none border h-100 hover-card" style="border-color: #e5e7eb !important; transition: all 0.3s ease;">
                        <div class="card-body text-center py-4">
                            <div class="mb-3">
                                <i data-lucide="cake" style="width: 40px; height: 40px; stroke-width: 1.8; color: #d97706;"></i>
                            </div>
                            <h5 class="h6 fw-semibold text-dark mb-2">Dessert</h5>
                            <div class="display-6 fw-bold text-dark mb-1"><?php echo e($countDesserts ?? 0); ?></div>
                            <div class="small text-muted">elementi totali</div>
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

    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <script src="<?php echo e(asset('js/dashboard.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\my_project\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/dashboard.blade.php ENDPATH**/ ?>