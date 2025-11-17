<?php $__env->startSection('title', 'I Tuoi Antipasti'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
  <h1 class="h3 fw-semibold text-dark mb-2">
    <i data-lucide="salad" style="width: 28px; height: 28px; color: #059669; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
    Antipasti
  </h1>
  <p class="text-muted small mb-4">Gestisci gli antipasti del tuo menu</p>

  <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
    <a href="<?php echo e(route('admin.appetizers.create')); ?>"
       class="btn btn-outline-success btn-sm"
       aria-label="Aggiungi un nuovo antipasto">
      <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Nuovo Antipasto
    </a>
    <span class="text-muted small">
      <?php $total = method_exists($appetizers,'total') ? $appetizers->total() : ($appetizers->count() ?? 0); ?>
      <?php echo e($total); ?> <?php echo e($total == 1 ? 'elemento' : 'elementi'); ?>

    </span>
  </div>
  <div class="visually-hidden" aria-live="polite" aria-atomic="true" id="view-change-announce"></div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php $count = ($appetizers->count() ?? 0); ?>

  <?php if($count === 0): ?>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4"><i data-lucide="salad" style="width: 64px; height: 64px; color: #059669; opacity: .4;"></i></div>
          <h3 class="h5 fw-semibold text-dark mb-3">Nessun antipasto presente</h3>
          <p class="text-muted small mb-4">Crea il primo antipasto per iniziare.</p>
          <a class="btn btn-outline-success btn-sm" href="<?php echo e(route('admin.appetizers.create')); ?>" aria-label="Crea il primo antipasto">
            <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Crea Primo Antipasto
          </a>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div id="appetizers-container" class="transition-container list-wrapper">
      <div class="list-container">
        <?php $__currentLoopData = $appetizers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="pizza-card card shadow-sm border-0 mb-3">
            <div class="card-body py-3 px-3">
              <div class="d-flex align-items-center gap-3 flex-wrap flex-md-nowrap">
                <div class="pizza-icon flex-shrink-0 d-flex align-items-center justify-content-center bg-light rounded-circle" style="height:56px;width:56px;">
                  <?php if(!empty($a->image_path)): ?>
                    <img src="<?php echo e(asset('storage/'.$a->image_path)); ?>" alt="Antipasto <?php echo e($a->name); ?>" class="img-fluid rounded-circle" style="height:56px;width:56px;object-fit:cover;">
                  <?php else: ?>
                    <i class="fas fa-seedling text-success fs-3" aria-hidden="true"></i>
                  <?php endif; ?>
                </div>
                <div class="flex-grow-1 min-w-0">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="d-flex flex-column align-items-start min-w-0">
                      <span class="fw-bold fs-5 text-dark text-truncate d-inline-block" style="max-width:220px;"><?php echo e($a->name); ?></span>
                    </div>
                  </div>
                  <?php if(!empty($a->description)): ?>
                    <div class="mb-1"><small class="text-muted text-truncate d-block" style="max-width:320px;"><?php echo e(\Illuminate\Support\Str::limit($a->description, 120)); ?></small></div>
                  <?php endif; ?>
                  <?php if($a->allergens && $a->allergens->count() > 0): ?>
                    <?php $collapseAllergenId = 'allergens-collapse-appetizer-'.$a->id; ?>
                    <button class="btn btn-sm btn-outline-warning mt-2 d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo e($collapseAllergenId); ?>" aria-expanded="false" aria-controls="<?php echo e($collapseAllergenId); ?>">
                      <i class="fas fa-exclamation-triangle"></i> <span>Vedi allergeni</span>
                    </button>
                    <div class="collapse mt-2 w-100" id="<?php echo e($collapseAllergenId); ?>">
                      <ul class="list-unstyled mb-0 ps-2 small">
                        <?php $__currentLoopData = $a->allergens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li class="py-1 d-flex align-items-center gap-2">
                            <i class="fas fa-circle text-warning" style="font-size:0.5em;"></i> <span><?php echo e($allergen->name); ?></span>
                          </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>
                    </div>
                  <?php endif; ?>
                  <?php if($a->ingredients && $a->ingredients->count() > 0): ?>
                    <?php $collapseId = 'ingredients-collapse-appetizer-'.$a->id; $collapseAllergenId = 'allergens-collapse-appetizer-'.$a->id; ?>
                    <div class="d-flex flex-row gap-2 mt-2">
                      <button class="btn btn-sm d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo e($collapseId); ?>" aria-expanded="false" aria-controls="<?php echo e($collapseId); ?>" style="border:1.5px solid #8fd19e;color:#388e3c;background:transparent;">
                        <span style="font-size:1.2em;line-height:1;color:#388e3c;">&#9776;</span> <span>Vedi ingredienti</span>
                      </button>
                      <button class="btn btn-sm d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo e($collapseAllergenId); ?>" aria-expanded="false" aria-controls="<?php echo e($collapseAllergenId); ?>" style="border:1.5px solid #ffe066;color:#bfa100;background:transparent;">
                        <span style="font-size:1.2em;line-height:1;color:#bfa100;">&#9776;</span> <span>Vedi allergeni</span>
                      </button>
                    </div>
                    <div class="collapse mt-2 w-100" id="<?php echo e($collapseId); ?>">
                      <?php if($a->ingredients && $a->ingredients->count() > 0): ?>
                        <ul class="list-unstyled mb-0 ps-2 small">
                          <?php $__currentLoopData = $a->ingredients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="py-1 d-flex align-items-center gap-2">
                              <span><?php echo e($ingredient->name); ?></span>
                            </li>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                      <?php else: ?>
                        <div class="text-muted small ps-2">Nessun ingrediente</div>
                      <?php endif; ?>
                    </div>
                    <div class="collapse mt-2 w-100" id="<?php echo e($collapseAllergenId); ?>">
                      <?php if($a->allergens && $a->allergens->count() > 0): ?>
                        <ul class="list-unstyled mb-0 ps-2 small">
                          <?php $__currentLoopData = $a->allergens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="py-1 d-flex align-items-center gap-2">
                              <span><?php echo e($allergen->name); ?></span>
                            </li>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                      <?php else: ?>
                        <div class="text-muted small ps-2">Nessun allergene</div>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="pizza-actions d-flex flex-column flex-md-row gap-2 ms-md-3 mt-3 mt-md-0">
                  <a href="<?php echo e(route('admin.appetizers.show', $a)); ?>" class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Dettagli" style="border:1.5px solid #1976d2;color:#1976d2;background:transparent;">
                    <i class="fas fa-eye me-1" style="color:#1976d2;"></i><span class="d-none d-md-inline" style="color:#1976d2;">Dettagli</span>
                  </a>
                  <a href="<?php echo e(route('admin.appetizers.edit', $a)); ?>" class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Modifica" style="border:1.5px solid #388e3c;color:#388e3c;background:transparent;">
                    <i class="fas fa-edit me-1" style="color:#388e3c;"></i><span class="d-none d-md-inline" style="color:#388e3c;">Modifica</span>
                  </a>
                  <form method="POST" action="<?php echo e(route('admin.appetizers.destroy', $a)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center w-100" data-bs-toggle="tooltip" title="Elimina" style="border:1.5px solid #d32f2f;color:#d32f2f;background:transparent;">
                      <i class="fas fa-trash me-1" style="color:#d32f2f;"></i><span class="d-none d-md-inline" style="color:#d32f2f;">Elimina</span>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <?php if(method_exists($appetizers,'hasPages') && $appetizers->hasPages()): ?>
        <div class="d-flex justify-content-center mt-5"><?php echo e($appetizers->links()); ?></div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pizza-index.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/pizza-index.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/admin/appetizers/index.blade.php ENDPATH**/ ?>