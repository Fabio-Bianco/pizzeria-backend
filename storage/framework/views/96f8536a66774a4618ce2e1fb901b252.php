<?php $__env->startSection('title', $pizza->name); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
    <h3 class="fw-semibold mb-2">
        <i data-lucide="eye" style="width: 24px; height: 24px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
        <?php echo e($pizza->name); ?>

    </h3>
    <p class="text-muted mb-0">Dettagli della pizza</p>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8">
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <div class="d-flex gap-3 align-items-start">
              <?php if($pizza->image_path): ?>
                <img src="<?php echo e(asset('storage/'.$pizza->image_path)); ?>" alt="<?php echo e($pizza->name); ?>" class="rounded" style="width:140px;height:140px;object-fit:cover;">
              <?php endif; ?>
              <div>
                <p class="mb-1"><strong>Categoria:</strong> <?php echo e($pizza->category?->name ?? '-'); ?></p>
                <p class="mb-1"><strong>Prezzo:</strong> € <?php echo e(number_format($pizza->price, 2, ',', '.')); ?></p>
                <?php if($pizza->description): ?>
                  <p class="mb-2"><?php echo e($pizza->description); ?></p>
                <?php endif; ?>
                <div class="mt-2">
                  <strong>Ingredienti:</strong>
                  <ul class="mt-2">
                    <?php $__empty_1 = true; $__currentLoopData = $pizza->ingredients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                      <li><?php echo e($ingredient->name); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                      <li class="text-muted">Nessuno</li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
          <a href="<?php echo e(route('admin.pizzas.index')); ?>" class="btn btn-outline-secondary btn-sm">
            Torna all'elenco
          </a>
          <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.pizzas.edit', $pizza)); ?>" class="btn btn-outline-primary btn-sm">
              <i data-lucide="pencil" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
              Modifica
            </a>
            <form action="<?php echo e(route('admin.pizzas.destroy', $pizza)); ?>" method="POST" data-confirm="Sicuro?" class="d-inline">
              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button class="btn btn-outline-danger btn-sm" type="submit">
                <i data-lucide="trash-2" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
                Elimina
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\my_project\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/admin/pizzas/show.blade.php ENDPATH**/ ?>