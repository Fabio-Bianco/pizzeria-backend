<?php $__env->startSection('title', 'Nuova Pizza'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex align-items-center gap-3 py-3">
    <a href="<?php echo e(route('admin.pizzas.index')); ?>" 
       class="btn btn-outline-secondary btn-sm"
       aria-label="Torna alle pizze">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
    </a>
    <div>
        <h1 class="h4 fw-semibold text-dark mb-1">
            <i data-lucide="pizza" style="width: 24px; height: 24px; color: #dc2626; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
            Nuova Pizza
        </h1>
        <p class="text-muted small mb-0">Compila i campi per aggiungere una pizza</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <form action="<?php echo e(route('admin.pizzas.store')); ?>" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                <?php echo csrf_field(); ?>
                
                
                <div class="card border mb-3" style="border-color: #e5e7eb !important;">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark mb-3">
                            <i data-lucide="file-text" style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-right: 6px; color: #6b7280;"></i>
                            Informazioni Base
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="name" class="form-label small fw-semibold text-dark">Nome Pizza <span class="text-danger">*</span></label>
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
                                       placeholder="Es. Margherita, Marinara"
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

                            <div class="col-md-4">
                                <label for="price" class="form-label small fw-semibold text-dark">Prezzo <span class="text-danger">*</span></label>
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

                            <div class="col-md-6">
                                <label for="category_id" class="form-label small fw-semibold text-dark">Categoria</label>
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

                            <div class="col-md-6">
                                <label for="image" class="form-label small fw-semibold text-dark">Immagine</label>
                                <input id="image" name="image" type="file" 
                                       class="form-control form-control-sm <?php $__errorArgs = ['image'];
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
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label small fw-semibold text-dark">Descrizione</label>
                                <textarea id="description" name="description" rows="2"
                                          class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          placeholder="Breve descrizione della pizza"><?php echo e(old('description')); ?></textarea>
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

                
                <div class="card border mb-3" style="border-color: #e5e7eb !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold text-dark mb-0">
                                <i data-lucide="wheat" style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-right: 6px; color: #6b7280;"></i>
                                Ingredienti
                            </h6>
                            <button type="button" class="btn btn-outline-success btn-sm" 
                                    data-bs-toggle="modal" data-bs-target="#newIngredientModal">
                                <i data-lucide="plus" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>Nuovo
                            </button>
                        </div>
                        <div class="mb-3">
                            <label for="ingredients" class="form-label small fw-semibold text-dark">Seleziona ingredienti</label>
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
                                <a href="<?php echo e(route('admin.pizzas.index')); ?>" class="btn btn-outline-secondary btn-sm" aria-label="Annulla">
                                    <i data-lucide="x" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>Annulla
                                </a>
                                <button type="submit" class="btn btn-primary btn-sm" aria-label="Salva pizza">
                                    <i data-lucide="check" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>Salva Pizza
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
                        <i data-lucide="plus" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; margin-right: 8px; color: #059669;"></i>
                        Nuovo Ingrediente
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_ingredient_name" class="form-label small fw-semibold text-dark">Nome Ingrediente</label>
                        <input type="text" class="form-control" id="new_ingredient_name" placeholder="Es. Mozzarella, Basilico">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                        <i data-lucide="x" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>Annulla
                    </button>
            </div>
        </div>
    </div>

    <?php echo $__env->make('partials.pizza-create-script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <link rel="stylesheet" href="<?php echo e(asset('css/pizza-create.css')); ?>">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\my_project\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/admin/pizzas/create.blade.php ENDPATH**/ ?>