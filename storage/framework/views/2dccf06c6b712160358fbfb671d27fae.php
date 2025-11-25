<?php $__env->startSection('title', 'Le Tue Bevande'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
  <h1 class="h3 fw-semibold text-dark mb-2">
    <i data-lucide="glass-water" style="width: 28px; height: 28px; color: #2563eb; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
    Bevande
  </h1>
  <p class="text-muted small mb-4">Gestisci le bevande del tuo menu</p>

  <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
    <a href="<?php echo e(route('admin.beverages.create')); ?>"
       class="btn btn-outline-info btn-sm"
       aria-label="Aggiungi una nuova bevanda">
      <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Nuova Bevanda
    </a>
    <span class="text-muted small">
      <?php $total = method_exists($beverages,'total') ? $beverages->total() : ($beverages->count() ?? 0); ?>
      <?php echo e($total); ?> <?php echo e($total == 1 ? 'elemento' : 'elementi'); ?>

    </span>
  </div>
  <div class="visually-hidden" aria-live="polite" aria-atomic="true" id="view-change-announce"></div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php $count = ($beverages->count() ?? 0); ?>

  <?php if($count === 0): ?>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4"><i data-lucide="glass-water" style="width: 64px; height: 64px; color: #2563eb; opacity: .4;"></i></div>
          <h3 class="h5 fw-semibold text-dark mb-3">Nessuna bevanda presente</h3>
          <p class="text-muted small mb-4">Crea la prima bevanda per iniziare.</p>
          <a class="btn btn-outline-info btn-sm" href="<?php echo e(route('admin.beverages.create')); ?>" aria-label="Crea la prima bevanda">
            <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Crea Prima Bevanda
          </a>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div id="beverages-container" class="transition-container list-wrapper">
      <div class="list-container">
        <?php $__currentLoopData = $beverages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="pizza-card card shadow-sm border-0 mb-3">
            <div class="card-body py-3 px-3">
              <div class="d-flex align-items-center gap-3 flex-wrap flex-md-nowrap">
                <div class="pizza-icon flex-shrink-0 d-flex align-items-center justify-content-center bg-light rounded-circle" style="height:56px;width:56px;">
                  <?php if(!empty($b->image_path)): ?>
                    <img src="<?php echo e(asset('storage/'.$b->image_path)); ?>" alt="Bevanda <?php echo e($b->name); ?>" class="img-fluid rounded-circle" style="height:56px;width:56px;object-fit:cover;">
                  <?php else: ?>
                    <i class="fas fa-wine-bottle text-info fs-3" aria-hidden="true"></i>
                  <?php endif; ?>
                </div>
                <div class="flex-grow-1 min-w-0">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="fw-bold fs-5 text-dark text-truncate" style="max-width:220px;"><?php echo e($b->name); ?></span>
                  </div>
                  <?php if(!empty($b->description)): ?>
                    <div class="mb-1"><small class="text-muted text-truncate d-block" style="max-width:320px;"><?php echo e(\Illuminate\Support\Str::limit($b->description, 120)); ?></small></div>
                  <?php endif; ?>
                </div>
                <div class="pizza-actions d-flex flex-column flex-md-row gap-2 ms-md-3 mt-3 mt-md-0">
                  <a href="<?php echo e(route('admin.beverages.show', $b)); ?>" class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Dettagli" style="border:1.5px solid #1976d2;color:#1976d2;background:transparent;">
                    <i class="fas fa-eye me-1" style="color:#1976d2;"></i><span class="d-none d-md-inline" style="color:#1976d2;">Dettagli</span>
                  </a>
                  <a href="<?php echo e(route('admin.beverages.edit', $b)); ?>" class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Modifica" style="border:1.5px solid #388e3c;color:#388e3c;background:transparent;">
                    <i class="fas fa-edit me-1" style="color:#388e3c;"></i><span class="d-none d-md-inline" style="color:#388e3c;">Modifica</span>
                  </a>
                  <form method="POST" action="<?php echo e(route('admin.beverages.destroy', $b)); ?>">
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

      <?php if(method_exists($beverages,'hasPages') && $beverages->hasPages()): ?>
        <div class="d-flex justify-content-center mt-5"><?php echo e($beverages->links()); ?></div>
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

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\my_project\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/admin/beverages/index.blade.php ENDPATH**/ ?>