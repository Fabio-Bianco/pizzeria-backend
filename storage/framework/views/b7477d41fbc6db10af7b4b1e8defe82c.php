<?php $__env->startSection('title', 'Modifica: ' . $beverage->name); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <div>
        <div class="d-flex align-items-center mb-2">
            <a href="<?php echo e(route('admin.beverages.index')); ?>" class="btn btn-outline-secondary btn-sm me-3">
                <i class="fas fa-arrow-left me-1"></i>
                Indietro
            </a>
            <h1 class="page-title mb-0">
                <i class="fas fa-edit text-success me-2"></i>
                Modifica: <?php echo e($beverage->name); ?>

            </h1>
        </div>
        <p class="page-subtitle">Aggiorna le informazioni della bevanda</p>
    </div>
    <div>
        <span class="badge bg-light text-dark fs-6 px-3 py-2">
            <i class="fas fa-glass-water me-1"></i>
            Gestione Menu
        </span>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-12">
            <form action="<?php echo e(route('admin.beverages.update', $beverage)); ?>" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="row g-4">
                    
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle text-success me-2"></i>
                                    Informazioni Base
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="name" class="form-label fw-semibold">
                                            <i class="fas fa-glass-water me-1"></i>
                                            Nome Bevanda <span class="text-danger">*</span>
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
                                               value="<?php echo e(old('name', $beverage->name)); ?>" 
                                               placeholder="Es. Coca Cola, Birra Moretti..."
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
                                                   value="<?php echo e(old('price', $beverage->price)); ?>" 
                                                   placeholder="3.50"
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
                                        <label for="category" class="form-label fw-semibold">
                                            <i class="fas fa-tags me-1"></i>
                                            Categoria
                                        </label>
                                        <select id="category" name="category" 
                                                class="form-select <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value="">Seleziona categoria...</option>
                                            <option value="analcoliche" <?php if(old('category', $beverage->category) == 'analcoliche'): echo 'selected'; endif; ?>>Analcoliche</option>
                                            <option value="alcoliche" <?php if(old('category', $beverage->category) == 'alcoliche'): echo 'selected'; endif; ?>>Alcoliche</option>
                                            <option value="birre" <?php if(old('category', $beverage->category) == 'birre'): echo 'selected'; endif; ?>>Birre</option>
                                            <option value="vini" <?php if(old('category', $beverage->category) == 'vini'): echo 'selected'; endif; ?>>Vini</option>
                                            <option value="liquori" <?php if(old('category', $beverage->category) == 'liquori'): echo 'selected'; endif; ?>>Liquori</option>
                                            <option value="caffetteria" <?php if(old('category', $beverage->category) == 'caffetteria'): echo 'selected'; endif; ?>>Caffetteria</option>
                                        </select>
                                        <?php $__errorArgs = ['category'];
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
                                                  placeholder="Descrivi la bevanda..."><?php echo e(old('description', $beverage->description)); ?></textarea>
                                        <?php $__errorArgs = ['description'];
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
                                        <?php if($beverage->image_path): ?>
                                            <div class="mb-2">
                                                <img src="<?php echo e(asset('storage/'.$beverage->image_path)); ?>" 
                                                     alt="<?php echo e($beverage->name); ?>" 
                                                     class="img-thumbnail" 
                                                     style="max-height: 80px;">
                                                <div class="form-text">Immagine attuale</div>
                                            </div>
                                        <?php endif; ?>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-wine-bottle text-warning me-2"></i>
                                    Informazioni Aggiuntive
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="gradazione_alcolica" class="form-label fw-semibold">
                                            <i class="fas fa-percentage me-1"></i>
                                            Gradazione Alcolica
                                        </label>
                                        <div class="input-group">
                                            <input id="gradazione_alcolica" name="gradazione_alcolica" type="number" step="0.1" 
                                                   class="form-control <?php $__errorArgs = ['gradazione_alcolica'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   value="<?php echo e(old('gradazione_alcolica', $beverage->gradazione_alcolica)); ?>" 
                                                   placeholder="5.0">
                                            <span class="input-group-text">% Vol.</span>
                                        </div>
                                        <?php $__errorArgs = ['gradazione_alcolica'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <div class="form-text">Lascia vuoto se analcolica</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="formato" class="form-label fw-semibold">
                                            <i class="fas fa-ruler me-1"></i>
                                            Formato
                                        </label>
                                        <input id="formato" name="formato" type="text" 
                                               class="form-control <?php $__errorArgs = ['formato'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               value="<?php echo e(old('formato', $beverage->formato)); ?>" 
                                               placeholder="Es. 330ml, 0.5L, 75cl...">
                                        <?php $__errorArgs = ['formato'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-12">
                                        <label for="tipologia" class="form-label fw-semibold">
                                            <i class="fas fa-wine-glass me-1"></i>
                                            Tipologia
                                        </label>
                                        <select id="tipologia" name="tipologia" class="form-select <?php $__errorArgs = ['tipologia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value="">Seleziona tipologia...</option>
                                            <option value="analcolica" <?php if(old('tipologia', $beverage->tipologia) == 'analcolica'): echo 'selected'; endif; ?>>Analcolica</option>
                                            <option value="birra" <?php if(old('tipologia', $beverage->tipologia) == 'birra'): echo 'selected'; endif; ?>>Birra</option>
                                            <option value="vino" <?php if(old('tipologia', $beverage->tipologia) == 'vino'): echo 'selected'; endif; ?>>Vino</option>
                                            <option value="liquore" <?php if(old('tipologia', $beverage->tipologia) == 'liquore'): echo 'selected'; endif; ?>>Liquore</option>
                                            <option value="altro" <?php if(old('tipologia', $beverage->tipologia) == 'altro'): echo 'selected'; endif; ?>>Altro</option>
                                        </select>
                                        <?php $__errorArgs = ['tipologia'];
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
                                            Note Aggiuntive
                                        </label>
                                        <textarea id="notes" name="notes" rows="3" 
                                                  class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                  placeholder="Temperature di servizio, abbinamenti..."><?php echo e(old('notes', $beverage->notes)); ?></textarea>
                                        <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-check form-switch mt-3">
                                        <input class="form-check-input" type="checkbox" role="switch" 
                                               id="is_gluten_free" name="is_gluten_free" value="1"
                                               <?php if(old('is_gluten_free', $beverage->is_gluten_free)): echo 'checked'; endif; ?>>
                                        <label class="form-check-label fw-semibold text-dark" for="is_gluten_free">
                                            <i class="fas fa-bread-slice me-1 text-dark"></i>
                                            <span class="text-dark">Senza Glutine</span>
                                        </label>
                                    </div>
                                    <small class="text-muted">Spunta se la bevanda è senza glutine</small>

                                    
                                    <div class="col-12 mt-4">
                                        <div class="p-3 bg-light rounded">
                                            <h6 class="mb-2">
                                                <i class="fas fa-info-circle text-info me-1"></i>
                                                Categoria Attuale
                                            </h6>
                                            <span class="badge bg-info text-white">
                                                <?php echo e($beverage->category ?? 'Non specificata'); ?>

                                            </span>
                                        </div>
                                    </div>
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
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        I campi contrassegnati con <span class="text-danger">*</span> sono obbligatori
                                    </small>
                                    <div class="d-flex gap-3">
                                        <a href="<?php echo e(route('admin.beverages.index')); ?>" class="btn btn-outline-secondary px-4">
                                            <i class="fas fa-times me-2"></i>
                                            Annulla
                                        </a>
                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="fas fa-save me-2"></i>
                                            Aggiorna Bevanda
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

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/admin/beverages/edit.blade.php ENDPATH**/ ?>