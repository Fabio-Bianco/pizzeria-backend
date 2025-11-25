

<?php $__env->startSection('title', 'Nuovo Antipasto'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex align-items-center gap-3 py-3">
    <a href="<?php echo e(route('admin.appetizers.index')); ?>" 
       class="btn btn-outline-secondary btn-sm"
       aria-label="Torna agli antipasti">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
    </a>
    <div>
        <h1 class="h4 fw-semibold text-dark mb-1">
            <i data-lucide="salad" style="width: 24px; height: 24px; color: #059669; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
            Nuovo Antipasto
        </h1>
        <p class="text-muted small mb-0">Compila i campi per aggiungere un antipasto</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <form action="<?php echo e(route('admin.appetizers.store')); ?>" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                <?php echo csrf_field(); ?>
                
                
                <div class="card border mb-3" style="border-color: #e5e7eb !important;">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark mb-3">
                            <i data-lucide="file-text" style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-right: 6px; color: #6b7280;"></i>
                            Informazioni Base
                        </h6>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="name" class="form-label fw-semibold">
                                            <i class="fas fa-salad me-1"></i>
                                            Nome Antipasto <span class="text-danger">*</span>
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
                                               placeholder="Es. Bruschette, Antipasto misto, Tagliere..."
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

                                    <div class="col-12">
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
                                                   placeholder="8.50"
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
                                                  placeholder="Descrivi l'antipasto..."><?php echo e(old('description')); ?></textarea>
                                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-12">
                                        <label for="notes" class="form-label fw-semibold">
                                            <i class="fas fa-sticky-note me-1"></i>
                                            Note
                                        </label>
                                        <textarea id="notes" name="notes" rows="2" 
                                                  class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                  placeholder="Note aggiuntive..."><?php echo e(old('notes')); ?></textarea>
                                        <?php $__errorArgs = ['notes'];
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
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-seedling text-success me-2"></i>
                                    Ingredienti e Opzioni
                                </h5>
                            </div>
                            <div class="card-body">
                                
                                <div class="mb-4">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="is_vegan" name="is_vegan" value="1" 
                                               <?php if(old('is_vegan', false)): echo 'checked'; endif; ?>>
                                        <label class="form-check-label fw-semibold" for="is_vegan">
                                            <i class="fas fa-leaf text-success me-1"></i>
                                            Vegano
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_gluten_free" name="is_gluten_free" value="1" 
                                               <?php if(old('is_gluten_free', false)): echo 'checked'; endif; ?>>
                                        <label class="form-check-label fw-semibold text-dark" for="is_gluten_free">
                                            <i class="fas fa-bread-slice me-1 text-dark"></i>
                                            <span class="text-dark">Senza Glutine</span>
                                        </label>
                                    </div>
                                    <small class="text-muted">Contrassegna se l'antipasto è adatto ai vegani o a chi è intollerante al glutine</small>
                                </div>

                                
                                <?php if(isset($ingredients) && $ingredients->isNotEmpty()): ?>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="ingredients" class="form-label fw-semibold mb-0">
                                            <i class="fas fa-list me-1"></i>
                                            Ingredienti Principali
                                        </label>
                                        <button type="button" class="btn btn-sm btn-outline-success px-2 py-1 ms-2 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#newIngredientModal">
                                            <i class="fas fa-plus me-1"></i> Aggiungi ingrediente
                                        </button>
                                    </div>
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
                                            data-store-url="<?php echo e(route('admin.ingredients.store')); ?>"
                                            placeholder="Cerca e seleziona ingredienti...">
                                        <?php $__currentLoopData = $ingredients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($ingredient->id); ?>" 
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
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Aiuta a calcolare automaticamente gli allergeni
                                    </div>
                                </div>
                                <!-- Modal nuovo ingrediente (riuso markup pizze) -->
                                <div class="modal fade" id="newIngredientModal" tabindex="-1" aria-labelledby="newIngredientModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="newIngredientModalLabel">
                                                    <i class="fas fa-plus me-2 text-success"></i>Nuovo Ingrediente
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label for="ni_name" class="form-label fw-semibold">Nome Ingrediente</label>
                                                <input type="text" id="ni_name" class="form-control mb-3" placeholder="Es. Prosciutto cotto, Olive nere...">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annulla</button>
                                                <button type="button" class="btn btn-success" id="ni_save">Crea Ingrediente</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                
                                <div class="mt-4 p-3 bg-light rounded">
                                    <h6 class="mb-2">
                                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                        Allergeni
                                    </h6>
                                    <small class="text-muted">
                                        Gli allergeni verranno calcolati automaticamente in base agli ingredienti selezionati
                                    </small>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-hand-paper me-1 text-warning"></i>
                                        Allergeni Aggiuntivi
                                    </label>
                                    <div class="row g-1" id="manual-allergens-container">
                                        <?php $__currentLoopData = ($allergens ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

                
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">I campi con <span class="text-danger">*</span> sono obbligatori</small>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('admin.appetizers.index')); ?>" class="btn btn-outline-secondary btn-sm" aria-label="Annulla">
                            <i data-lucide="x" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>Annulla
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm" aria-label="Salva antipasto">
                            <i data-lucide="check" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>Salva Antipasto
                        </button>
                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\my_project\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/admin/appetizers/create.blade.php ENDPATH**/ ?>