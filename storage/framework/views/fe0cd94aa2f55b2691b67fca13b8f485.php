

<?php $__env->startSection('title', 'Nuova Bevanda'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex align-items-center gap-3 py-3">
    <a href="<?php echo e(route('admin.beverages.index')); ?>" 
       class="btn btn-outline-secondary btn-sm"
       aria-label="Torna alle bevande">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
    </a>
    <div>
        <h1 class="h4 fw-semibold text-dark mb-1">
            <i data-lucide="glass-water" style="width: 24px; height: 24px; color: #2563eb; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
            Nuova Bevanda
        </h1>
        <p class="text-muted small mb-0">Compila i campi per aggiungere una bevanda</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <form action="<?php echo e(route('admin.beverages.store')); ?>" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                <?php echo csrf_field(); ?>
                
                
                <div class="card border mb-3" style="border-color: #e5e7eb !important;">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark mb-3">
                            <i data-lucide="file-text" style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-right: 6px; color: #6b7280;"></i>
                            Informazioni Base
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="name" class="form-label small fw-semibold text-dark">Nome <span class="text-danger">*</span></label>
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
                                       placeholder="Es. Coca Cola, Birra Moretti"
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

                            <div class="col-md-6">
                                <label for="category" class="form-label small fw-semibold text-dark">Categoria</label>
                                <select id="category" name="category" class="form-select <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="">Seleziona...</option>
                                    <option value="analcoliche" <?php if(old('category') == 'analcoliche'): echo 'selected'; endif; ?>>Analcoliche</option>
                                    <option value="alcoliche" <?php if(old('category') == 'alcoliche'): echo 'selected'; endif; ?>>Alcoliche</option>
                                    <option value="birre" <?php if(old('category') == 'birre'): echo 'selected'; endif; ?>>Birre</option>
                                    <option value="vini" <?php if(old('category') == 'vini'): echo 'selected'; endif; ?>>Vini</option>
                                    <option value="liquori" <?php if(old('category') == 'liquori'): echo 'selected'; endif; ?>>Liquori</option>
                                    <option value="caffetteria" <?php if(old('category') == 'caffetteria'): echo 'selected'; endif; ?>>Caffetteria</option>
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

                            <div class="col-md-6">
                                <label for="formato" class="form-label small fw-semibold text-dark">Formato</label>
                                <input id="formato" name="formato" type="text" 
                                       class="form-control <?php $__errorArgs = ['formato'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('formato')); ?>" 
                                       placeholder="330ml, 0.5L, 75cl">
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
                                          placeholder="Breve descrizione della bevanda"><?php echo e(old('description')); ?></textarea>
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
                        <h6 class="fw-semibold text-dark mb-3">
                            <i data-lucide="sliders" style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-right: 6px; color: #6b7280;"></i>
                            Dettagli Opzionali
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="gradazione_alcolica" class="form-label small fw-semibold text-dark">Gradazione Alcolica</label>
                                <div class="input-group input-group-sm">
                                    <input id="gradazione_alcolica" name="gradazione_alcolica" type="number" step="0.1" 
                                           class="form-control <?php $__errorArgs = ['gradazione_alcolica'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('gradazione_alcolica')); ?>" 
                                           placeholder="5.0">
                                    <span class="input-group-text">%</span>
                                </div>
                                <?php $__errorArgs = ['gradazione_alcolica'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-4">
                                <label for="tipologia" class="form-label small fw-semibold text-dark">Tipologia</label>
                                <select id="tipologia" name="tipologia" class="form-select form-select-sm <?php $__errorArgs = ['tipologia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="">Seleziona...</option>
                                    <option value="analcolica" <?php if(old('tipologia') == 'analcolica'): echo 'selected'; endif; ?>>Analcolica</option>
                                    <option value="birra" <?php if(old('tipologia') == 'birra'): echo 'selected'; endif; ?>>Birra</option>
                                    <option value="vino" <?php if(old('tipologia') == 'vino'): echo 'selected'; endif; ?>>Vino</option>
                                    <option value="liquore" <?php if(old('tipologia') == 'liquore'): echo 'selected'; endif; ?>>Liquore</option>
                                    <option value="altro" <?php if(old('tipologia') == 'altro'): echo 'selected'; endif; ?>>Altro</option>
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

                            <div class="col-md-4">
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
                                <label for="notes" class="form-label small fw-semibold text-dark">Note</label>
                                <textarea id="notes" name="notes" rows="2" 
                                          class="form-control form-control-sm <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          placeholder="Temperature, abbinamenti, note di servizio"><?php echo e(old('notes')); ?></textarea>
                                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           id="is_gluten_free" name="is_gluten_free" value="1"
                                           <?php if(old('is_gluten_free')): echo 'checked'; endif; ?>>
                                    <label class="form-check-label small text-dark" for="is_gluten_free">
                                        Senza Glutine
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="d-flex justify-content-between align-items-center gap-3 py-3">
                    <small class="text-muted">
                        I campi con <span class="text-danger">*</span> sono obbligatori
                    </small>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('admin.beverages.index')); ?>" 
                           class="btn btn-outline-secondary btn-sm"
                           aria-label="Annulla creazione">
                            <i data-lucide="x" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>Annulla
                        </a>
                        <button type="submit" 
                                class="btn btn-primary btn-sm"
                                aria-label="Salva bevanda">
                            <i data-lucide="check" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>Salva Bevanda
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\my_project\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/admin/beverages/create.blade.php ENDPATH**/ ?>