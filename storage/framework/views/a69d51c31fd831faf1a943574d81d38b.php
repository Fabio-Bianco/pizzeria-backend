<?php $__env->startSection('title', 'Ingredienti'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
  <h1 class="h3 fw-semibold text-dark mb-2">
    <i data-lucide="leaf" style="width: 28px; height: 28px; color: #10b981; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
    Ingredienti
  </h1>
  <p class="text-muted small mb-4">Gestisci gli ingredienti del menu</p>

  <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
    <a href="<?php echo e(route('admin.ingredients.create')); ?>"
       class="btn btn-outline-success btn-sm"
       aria-label="Aggiungi un nuovo ingrediente">
      <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Nuovo Ingrediente
    </a>
    <span class="text-muted small">
      <?php $total = method_exists($ingredients,'total') ? $ingredients->total() : ($ingredients->count() ?? 0); ?>
      <?php echo e($total); ?> <?php echo e($total == 1 ? 'elemento' : 'elementi'); ?>

    </span>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if(($ingredients->count() ?? 0) === 0): ?>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4"><i data-lucide="leaf" style="width: 64px; height: 64px; color: #10b981; opacity: .4;"></i></div>
          <h3 class="h5 fw-semibold text-dark mb-3">Nessun ingrediente presente</h3>
          <p class="text-muted small mb-4">Crea il primo ingrediente per iniziare.</p>
          <a class="btn btn-outline-success btn-sm" href="<?php echo e(route('admin.ingredients.create')); ?>" aria-label="Crea il primo ingrediente">
            <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Crea Primo Ingrediente
          </a>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <div class="card border" style="border-color: #e5e7eb !important;">
          <div class="card-body p-0">
            <?php $__currentLoopData = $ingredients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="d-flex align-items-center p-3 border-bottom" style="border-color: #f3f4f6 !important;">
          <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-2 mb-1">
              <h6 class="mb-0 text-truncate"><?php echo e($ingredient->name); ?></h6>
            </div>
            <?php if(!empty($ingredient->description)): ?>
              <div class="text-muted small mb-1"><?php echo e(\Illuminate\Support\Str::limit($ingredient->description, 100)); ?></div>
            <?php endif; ?>
            <?php if($ingredient->allergens && $ingredient->allergens->count() > 0): ?>
              <div class="mb-1">
                <span class="badge badge-neutral small">Allergeni: <?php echo e($ingredient->allergens->pluck('name')->implode(', ')); ?></span>
              </div>
            <?php endif; ?>
          </div>
          <div class="d-flex align-items-center gap-2 ms-3 flex-shrink-0">
            <a href="<?php echo e(route('admin.ingredients.edit', $ingredient)); ?>"
               class="btn btn-outline-success btn-sm d-flex align-items-center gap-1"
               title="Modifica ingrediente">
              <i data-lucide="pencil" style="width: 14px; height: 14px;"></i> <span>Modifica</span>
            </a>
            <form action="<?php echo e(route('admin.ingredients.destroy', $ingredient)); ?>" method="POST" data-confirm="Sicuro?" class="d-inline">
              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button type="submit"
                      class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1"
                      title="Elimina ingrediente">
                <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i> <span>Elimina</span>
              </button>
            </form>
          </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
      </div>
    </div>

    <?php if(method_exists($ingredients,'hasPages') && $ingredients->hasPages()): ?>
      <div class="d-flex justify-content-center mt-5">
        <?php echo e($ingredients->links()); ?>

      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\my_project\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/admin/ingredients/index.blade.php ENDPATH**/ ?>