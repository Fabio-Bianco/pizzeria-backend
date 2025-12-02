<?php $__env->startSection('title', 'Modifica Ingrediente'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
    <h3 class="fw-semibold mb-2">
        <i data-lucide="pencil" style="width: 24px; height: 24px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
        Modifica: <?php echo e($ingredient->name); ?>

    </h3>
    <p class="text-muted mb-0">Aggiorna le informazioni dell'ingrediente</p>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <form action="<?php echo e(route('admin.ingredients.update', $ingredient)); ?>" method="POST" novalidate>
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                
                <div class="card border mb-3" style="border-color: #e5e7eb !important;">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Informazioni Base</h6>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label small text-muted mb-1">
                                Nome Ingrediente <span class="text-danger">*</span>
                            </label>
                            <input id="name" 
                                   name="name" 
                                   type="text" 
                                   class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('name', $ingredient->name)); ?>" 
                                   placeholder="Es. Mozzarella, Pomodoro, Basilico..."
                                   required
                                   autofocus>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   value="1" 
                                   id="is_tomato" 
                                   name="is_tomato" 
                                   <?php if(old('is_tomato', $ingredient->is_tomato)): echo 'checked'; endif; ?>>
                            <label class="form-check-label small" for="is_tomato">
                                È un tipo di pomodoro
                            </label>
                        </div>
                        <small class="text-muted d-block mt-1">Contrassegna se questo ingrediente è un derivato del pomodoro</small>
                    </div>
                </div>

                
                <div class="card border mb-3" style="border-color: #e5e7eb !important;">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Allergeni Associati</h6>
                        
                        <div class="mb-3">
                            <label for="allergens" class="form-label small text-muted mb-1">
                                Seleziona allergeni
                            </label>
                            <select id="allergens" 
                                    name="allergens[]" 
                                    multiple 
                                    class="form-select <?php $__errorArgs = ['allergens'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    data-choices 
                                    placeholder="Cerca e seleziona allergeni...">
                                <?php $__currentLoopData = $allergens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($allergen->id); ?>" 
                                            <?php if($ingredient->allergens->pluck('id')->contains($allergen->id)): echo 'selected'; endif; ?>>
                                        <?php echo e($allergen->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['allergens'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="text-muted d-block mt-1">
                                Seleziona tutti gli allergeni presenti in questo ingrediente
                            </small>
                        </div>

                        <?php if($ingredient->allergens->isNotEmpty()): ?>
                        <div class="p-3 bg-light rounded">
                            <div class="small text-muted mb-2">Allergeni Attuali</div>
                            <div class="d-flex flex-wrap gap-2">
                                <?php $__currentLoopData = $ingredient->allergens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge bg-warning text-dark"><?php echo e($allergen->name); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        I campi con <span class="text-danger">*</span> sono obbligatori
                    </small>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('admin.ingredients.index')); ?>" 
                           class="btn btn-outline-secondary btn-sm">
                            Annulla
                        </a>
                        <button type="submit" class="btn btn-outline-success btn-sm">
                            <i data-lucide="save" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
                            Salva Modifiche
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\my_project\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/admin/ingredients/edit.blade.php ENDPATH**/ ?>