<?php $__env->startSection('header'); ?>
    <h3 class="fw-semibold text-center mb-0">
        <i data-lucide="pencil" style="width: 24px; height: 24px; vertical-align: -4px;"></i>
        Modifica Antipasto
    </h3>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <form action="<?php echo e(route('admin.appetizers.update', $appetizer)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Informazioni Base -->
                <div class="card border mb-4" style="border-color: #e5e7eb !important;">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-4">Informazioni Base</h6>

                        <div class="mb-3">
                            <label for="name" class="form-label small text-muted mb-1">Nome Antipasto</label>
                            <input 
                                type="text" 
                                class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="name" 
                                name="name" 
                                value="<?php echo e(old('name', $appetizer->name)); ?>" 
                                required 
                                autofocus
                            >
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label small text-muted mb-1">Prezzo (€)</label>
                            <input 
                                type="number" 
                                step="0.01" 
                                class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="price" 
                                name="price" 
                                value="<?php echo e(old('price', $appetizer->price)); ?>" 
                                required
                            >
                            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label small text-muted mb-1">Descrizione</label>
                            <textarea 
                                class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="description" 
                                name="description" 
                                rows="3"
                            ><?php echo e(old('description', $appetizer->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label small text-muted mb-1">Immagine</label>
                            <?php if($appetizer->image_path): ?>
                                <div class="mb-2">
                                    <img src="<?php echo e(asset('storage/' . $appetizer->image_path)); ?>" alt="<?php echo e($appetizer->name); ?>" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            <?php endif; ?>
                            <input 
                                type="file" 
                                class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="image" 
                                name="image" 
                                accept="image/*"
                            >
                            <small class="text-muted">Lascia vuoto per mantenere l'immagine corrente</small>
                            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="is_vegan" 
                                        name="is_vegan" 
                                        value="1"
                                        <?php echo e(old('is_vegan', $appetizer->is_vegan) ? 'checked' : ''); ?>

                                    >
                                    <label class="form-check-label small" for="is_vegan">
                                        Vegano
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="is_gluten_free" 
                                        name="is_gluten_free" 
                                        value="1"
                                        <?php echo e(old('is_gluten_free', $appetizer->is_gluten_free) ? 'checked' : ''); ?>

                                    >
                                    <label class="form-check-label small" for="is_gluten_free">
                                        Senza Glutine
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ingredienti -->
                <div class="card border mb-4" style="border-color: #e5e7eb !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-semibold mb-0">Ingredienti</h6>
                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#newIngredientModal">
                                <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
                                Nuovo Ingrediente
                            </button>
                        </div>

                        <div class="mb-3">
                            <label for="ingredients" class="form-label small text-muted mb-1">Seleziona ingredienti</label>
                            <select 
                                class="form-select <?php $__errorArgs = ['ingredients'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="ingredients" 
                                name="ingredients[]" 
                                multiple
                            >
                                <?php $__currentLoopData = $ingredients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option 
                                        value="<?php echo e($ingredient->id); ?>"
                                        <?php echo e(in_array($ingredient->id, old('ingredients', $appetizer->ingredients ? $appetizer->ingredients->pluck('id')->toArray() : [])) ? 'selected' : ''); ?>

                                    >
                                        <?php echo e($ingredient->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['ingredients'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Allergeni -->
                <div class="card border mb-4" style="border-color: #e5e7eb !important;">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-3">Gestione Allergeni</h6>
                        
                        <div class="alert alert-info mb-3">
                            <i data-lucide="info" style="width: 16px; height: 16px; vertical-align: -2px;"></i>
                            Gli allergeni vengono rilevati automaticamente dagli ingredienti selezionati
                        </div>

                        <div id="allergen-checkboxes" class="mb-3">
                            <?php $__currentLoopData = $allergens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check">
                                    <input 
                                        class="form-check-input allergen-checkbox" 
                                        type="checkbox" 
                                        name="allergens[]" 
                                        value="<?php echo e($allergen->id); ?>" 
                                        id="allergen_<?php echo e($allergen->id); ?>"
                                        <?php echo e(in_array($allergen->id, old('allergens', $appetizer->allergens ? $appetizer->allergens->pluck('id')->toArray() : [])) ? 'checked' : ''); ?>

                                    >
                                    <label class="form-check-label small" for="allergen_<?php echo e($allergen->id); ?>">
                                        <?php echo e($allergen->name); ?>

                                    </label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div id="final-allergen-preview" class="mt-3 p-3" style="background-color: #f8f9fa; border-radius: 0.375rem; display: none;">
                            <h6 class="fw-semibold small mb-2">Allergeni Finali:</h6>
                            <div id="final-allergen-list" class="d-flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Pulsanti Azione -->
                <div class="d-flex justify-content-between">
                    <a href="<?php echo e(route('admin.appetizers.index')); ?>" class="btn btn-outline-secondary">
                        <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
                        Annulla
                    </a>
                    <button type="submit" class="btn btn-outline-success">
                        <i data-lucide="save" style="width: 16px; height: 16px;"></i>
                        Salva Modifiche
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Modal per Nuovo Ingrediente -->
<div class="modal fade" id="newIngredientModal" tabindex="-1" aria-labelledby="newIngredientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newIngredientModalLabel">Nuovo Ingrediente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="new_ingredient_name" class="form-label small text-muted mb-1">Nome Ingrediente</label>
                    <input type="text" class="form-control" id="new_ingredient_name" required>
                </div>
                <div class="mb-3">
                    <label for="new_ingredient_allergens" class="form-label small text-muted mb-1">Allergeni</label>
                    <select class="form-select" id="new_ingredient_allergens" multiple size="5">
                        <?php $__currentLoopData = $allergens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($allergen->id); ?>"><?php echo e($allergen->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                    <i data-lucide="x" style="width: 16px; height: 16px;"></i>
                    Annulla
                </button>
                <button type="button" class="btn btn-outline-success btn-sm" id="saveNewIngredient">
                    <i data-lucide="check" style="width: 16px; height: 16px;"></i>
                    Salva
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/scripts/choices.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/styles/choices.min.css">

<link rel="stylesheet" href="<?php echo e(asset('css/choices-custom.css')); ?>">

<?php echo $__env->make('partials.appetizer-edit-script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/admin/appetizers/edit.blade.php ENDPATH**/ ?>