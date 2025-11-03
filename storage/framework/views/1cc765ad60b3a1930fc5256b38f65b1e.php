<?php $__env->startSection('title', 'Nuova Pizza'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <div>
        <div class="d-flex align-items-center mb-2">
            <a href="<?php echo e(route('admin.pizzas.index')); ?>" class="btn btn-outline-secondary btn-sm me-3">
                <i class="fas fa-arrow-left me-1"></i>
                Indietro
            </a>
            <h1 class="page-title mb-0">
                <i class="fas fa-plus-circle text-success me-2"></i>
                Nuova Pizza
            </h1>
        </div>
        <p class="page-subtitle">Aggiungi una nuova pizza al tuo menu</p>
    </div>
    <div>
        <span class="badge bg-light text-dark fs-6 px-3 py-2">
            <i class="fas fa-list me-1"></i>
            Gestione Menu
        </span>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row justify-content-center">
        <div class="col-12">
            <form action="<?php echo e(route('admin.pizzas.store')); ?>" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                <?php echo csrf_field(); ?>
                
                
                <div class="row g-4 mb-4">
                    
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    Informazioni Base
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="name" class="form-label fw-semibold">
                                            <i class="fas fa-pizza-slice me-1"></i>
                                            Nome Pizza <span class="text-danger">*</span>
                                        </label>
                                        <input id="name" name="name" type="text" 
                                               class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               value="<?php echo e(old('name')); ?>" 
                                               placeholder="Es. Margherita, Marinara..."
                                               required>
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-6">
                                        <label for="price" class="form-label fw-semibold">
                                            <i class="fas fa-euro-sign me-1"></i>
                                            Prezzo <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">€</span>
                                            <input id="price" name="price" type="number" step="0.01" 
                                                   class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   value="<?php echo e(old('price')); ?>" 
                                                   placeholder="12.50"
                                                   required>
                                        </div>
                                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-6">
                                        <label for="category_id" class="form-label fw-semibold">
                                            <i class="fas fa-tags me-1"></i>
                                            Categoria
                                        </label>
                                        <select id="category_id" name="category_id" 
                                                class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                data-choices>
                                            <option value="">Seleziona...</option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>" 
                                                        data-is-white="<?php echo e($category->is_white ? '1' : '0'); ?>" 
                                                        <?php if(old('category_id') == $category->id): echo 'selected'; endif; ?>>
                                                    <?php echo e($category->name); ?>

                                                    <?php if($category->is_white): ?> (Bianca) <?php endif; ?>
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-12">
                                        <label for="image" class="form-label fw-semibold">
                                            <i class="fas fa-image me-1"></i>
                                            Immagine
                                        </label>
                                        <input id="image" name="image" type="file" 
                                               class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               accept=".jpg,.jpeg,.png,.webp">
                                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <div class="form-text">JPG, PNG, WebP. Max: 2MB</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="description" class="form-label fw-semibold">
                                            <i class="fas fa-align-left me-1"></i>
                                            Descrizione
                                        </label>
                                        <textarea id="description" name="description" rows="3"
                                                  class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                  placeholder="Descrizione della pizza..."><?php echo e(old('description')); ?></textarea>
                                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-seedling text-success me-2"></i>
                                        Ingredienti
                                    </h5>
                                    <button type="button" class="btn btn-outline-success btn-sm" 
                                            data-bs-toggle="modal" data-bs-target="#newIngredientModal">
                                        <i class="fas fa-plus me-1"></i>
                                        Nuovo
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="ingredients" class="form-label fw-semibold">
                                        Seleziona ingredienti
                                    </label>
                                    <select id="ingredients" name="ingredients[]" multiple 
                                            class="form-select <?php $__errorArgs = ['ingredients'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            data-choices 
                                            placeholder="Cerca ingredienti..." 
                                            data-store-url="<?php echo e(route('admin.ingredients.store')); ?>">
                                        <?php $__currentLoopData = $ingredients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($ingredient->id); ?>" 
                                                    data-is-tomato="<?php echo e($ingredient->is_tomato ? '1' : '0'); ?>" 
                                                    <?php if(collect(old('ingredients',[]))->contains($ingredient->id)): echo 'selected'; endif; ?>>
                                                <?php echo e($ingredient->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['ingredients'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div id="whiteHelp" class="alert alert-warning mt-2 d-none">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <strong>Pizza Bianca:</strong> Il pomodoro non può essere utilizzato.
                                    </div>
                                </div>

                                
                                <div class="mb-3">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" role="switch" 
                                               id="is_vegan" name="is_vegan" value="1"
                                               <?php if(old('is_vegan')): echo 'checked'; endif; ?>>
                                        <label class="form-check-label fw-semibold" for="is_vegan">
                                            <i class="fas fa-leaf text-success me-1"></i>
                                            <span class="text-success">Vegano</span>
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" 
                                               id="is_gluten_free" name="is_gluten_free" value="1"
                                               <?php if(old('is_gluten_free')): echo 'checked'; endif; ?>>
                                        <label class="form-check-label fw-semibold text-dark" for="is_gluten_free">
                                            <i class="fas fa-bread-slice me-1 text-dark"></i>
                                            <span class="text-dark">Senza Glutine</span>
                                        </label>
                                    </div>
                                    <small class="text-muted">Spunta se la pizza è senza glutine</small>
                                </div>

                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Allergeni Rilevati
                                    </label>
                                    <div id="automatic-allergens" class="p-2 bg-light border rounded">
                                        <em class="text-muted small">
                                            Seleziona ingredienti per vedere gli allergeni
                                        </em>
                                    </div>
                                </div>

                                
                                <div>
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-hand-paper me-1 text-warning"></i>
                                        Allergeni Aggiuntivi
                                    </label>
                                    <div class="row g-1" id="manual-allergens-container">
                                        <?php $__currentLoopData = (collect($allergens ?? []))->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="manual_allergens[]" 
                                                           value="<?php echo e($allergen->id); ?>" 
                                                           id="allergen_<?php echo e($allergen->id); ?>" 
                                                           <?php if(collect(old('manual_allergens',[]))->contains($allergen->id)): echo 'checked'; endif; ?>>
                                                    <label class="form-check-label small" for="allergen_<?php echo e($allergen->id); ?>">
                                                        <?php echo e($allergen->name); ?>

                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php $__errorArgs = ['manual_allergens'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger mt-1 small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-eye me-2 text-info"></i>
                            <strong class="me-3">Anteprima allergeni per i clienti:</strong>
                            <div id="final-allergens-preview">
                                <em class="text-muted">Nessun allergene</em>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                I campi con <span class="text-danger">*</span> sono obbligatori
                            </small>
                            <div class="d-flex gap-2">
                                <a href="<?php echo e(route('admin.pizzas.index')); ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>
                                    Annulla
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    Salva Pizza
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div class="modal fade" id="newIngredientModal" tabindex="-1" aria-labelledby="newIngredientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newIngredientModalLabel">
                        <i class="fas fa-plus-circle text-success me-2"></i>
                        Nuovo Ingrediente
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ni_name" class="form-label fw-semibold">Nome Ingrediente</label>
                        <input type="text" id="ni_name" class="form-control" placeholder="Es. Mozzarella, Basilico, Prosciutto..." />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Annulla
                    </button>
                    <button type="button" id="ni_save" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i>
                        Crea Ingrediente
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ingredientsSelect = document.getElementById('ingredients');
        const categorySelect = document.getElementById('category_id');
        const automaticAllergensDiv = document.getElementById('automatic-allergens');
        const manualAllergensContainer = document.getElementById('manual-allergens-container');
        const finalAllergensPreview = document.getElementById('final-allergens-preview');
        const whiteHelp = document.getElementById('whiteHelp');
        
        let automaticAllergens = [];
        
        // Gestione categoria bianca
        categorySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const isWhite = selectedOption?.dataset?.isWhite === '1';
            
            if (isWhite) {
                whiteHelp.classList.remove('d-none');
                
                // Disabilita opzioni pomodoro
                Array.from(ingredientsSelect.options).forEach(option => {
                    if (option.dataset.isTomato === '1') {
                        option.disabled = true;
                        option.selected = false;
                    }
                });
            } else {
                whiteHelp.classList.add('d-none');
                
                // Riabilita opzioni pomodoro
                Array.from(ingredientsSelect.options).forEach(option => {
                    if (option.dataset.isTomato === '1') {
                        option.disabled = false;
                    }
                });
            }
            
            updateAutomaticAllergens();
        });
        
        function updateAutomaticAllergens() {
            const selectedIngredients = Array.from(ingredientsSelect.selectedOptions).map(option => option.value);
            
            if (selectedIngredients.length === 0) {
                automaticAllergens = [];
                automaticAllergensDiv.innerHTML = '<em class="text-muted"><i class="fas fa-arrow-up me-1"></i>Seleziona ingredienti sopra per vedere gli allergeni automatici</em>';
                updateFinalPreview();
                return;
            }
            
            // Loading state
            automaticAllergensDiv.innerHTML = '<div class="d-flex align-items-center text-muted"><div class="spinner-border spinner-border-sm me-2"></div>Caricamento allergeni...</div>';
            
            // Chiamata AJAX per ottenere allergeni
            fetch('<?php echo e(route("admin.ajax.ingredients-allergens")); ?>?' + new URLSearchParams({
                ingredient_ids: selectedIngredients
            }), {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                automaticAllergens = data.allergens || [];
                
                if (automaticAllergens.length === 0) {
                    automaticAllergensDiv.innerHTML = '<div class="text-success"><i class="fas fa-check-circle me-1"></i>Nessun allergene automatico</div>';
                } else {
                    automaticAllergensDiv.innerHTML = automaticAllergens.map(allergen => 
                        `<span class="badge bg-warning text-dark me-1 mb-1">${allergen.name}</span>`
                    ).join('');
                }
                
                updateFinalPreview();
            })
            .catch(error => {
                console.error('Errore nel caricamento allergeni:', error);
                automaticAllergensDiv.innerHTML = '<div class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>Errore nel caricamento</div>';
            });
        }
        
        function updateFinalPreview() {
            const manualCheckboxes = manualAllergensContainer.querySelectorAll('input[type="checkbox"]:checked');
            const manualAllergens = Array.from(manualCheckboxes).map(cb => ({
                id: cb.value,
                name: cb.nextElementSibling.textContent.trim()
            }));
            
            // Merge automatic + manual, rimuovi duplicati
            const allAllergens = [...automaticAllergens];
            manualAllergens.forEach(manual => {
                if (!allAllergens.find(auto => auto.id == manual.id)) {
                    allAllergens.push(manual);
                }
            });
            
            if (allAllergens.length === 0) {
                finalAllergensPreview.innerHTML = '<em class="text-muted">Nessun allergene</em>';
            } else {
                finalAllergensPreview.innerHTML = allAllergens.map(allergen => 
                    `<span class="badge bg-danger text-white me-1 mb-1">${allergen.name}</span>`
                ).join('');
            }
        }
        
        // Event listeners
        ingredientsSelect.addEventListener('change', updateAutomaticAllergens);
        
        manualAllergensContainer.addEventListener('change', function(e) {
            if (e.target.type === 'checkbox') {
                updateFinalPreview();
            }
        });
        
        // Inizializzazione
        updateAutomaticAllergens();
    });
    </script>

    <style>
    .form-check-card {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .form-check-card:hover {
        background-color: var(--gray-50);
        border-color: var(--primary-color) !important;
    }
    
    .form-check-card:has(.form-check-input:checked) {
        background-color: rgba(255, 107, 53, 0.1);
        border-color: var(--primary-color) !important;
    }
    
    .needs-validation .form-control:invalid {
        border-color: var(--danger-color);
    }
    
    .needs-validation .form-control:valid {
        border-color: var(--success-color);
    }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/admin/pizzas/create.blade.php ENDPATH**/ ?>