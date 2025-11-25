<?php $__env->startSection('title', $beverage->name); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
    <h3 class="fw-semibold mb-2">
        <i data-lucide="eye" style="width: 24px; height: 24px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
        <?php echo e($beverage->name); ?>

    </h3>
    <p class="text-muted mb-0">Dettagli della bevanda</p>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
                
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <p class="mb-1"><strong>Prezzo:</strong> € <?php echo e(number_format($beverage->price, 2, ',', '.')); ?></p>
                        <?php if($beverage->description): ?>
                          <p class="mb-3"><?php echo e($beverage->description); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="<?php echo e(route('admin.beverages.index')); ?>" class="btn btn-outline-secondary btn-sm">
                        Torna all'elenco
                    </a>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('admin.beverages.edit', $beverage)); ?>" class="btn btn-outline-info btn-sm">
                            <i data-lucide="pencil" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
                            Modifica
                        </a>
                        <form action="<?php echo e(route('admin.beverages.destroy', $beverage)); ?>" method="POST" data-confirm="Sicuro?" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
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

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\my_project\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/admin/beverages/show.blade.php ENDPATH**/ ?>