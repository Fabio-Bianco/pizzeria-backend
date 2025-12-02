<?php $__env->startSection('title', 'Categorie'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
    <h1 class="h3 fw-semibold text-dark mb-2">
        <i data-lucide="folder" style="width: 28px; height: 28px; color: #8b5cf6; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
        Categorie
    </h1>
    <p class="text-muted small mb-4">Gestisci le categorie del menu</p>

    <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
        <a href="<?php echo e(route('admin.categories.create')); ?>"
             class="btn btn-outline-secondary btn-sm"
             aria-label="Aggiungi una nuova categoria">
            <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Nuova Categoria
        </a>
        <span class="text-muted small">
            <?php $total = method_exists($categories,'total') ? $categories->total() : ($categories->count() ?? 0); ?>
            <?php echo e($total); ?> <?php echo e($total == 1 ? 'elemento' : 'elementi'); ?>

        </span>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if($categories->count() === 0): ?>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center py-5">
                    <div class="mb-4"><i data-lucide="folder" style="width: 64px; height: 64px; color: #8b5cf6; opacity: .4;"></i></div>
                    <h3 class="h5 fw-semibold text-dark mb-3">Nessuna categoria presente</h3>
                    <p class="text-muted small mb-4">Crea la prima categoria per iniziare.</p>
                    <a class="btn btn-outline-secondary btn-sm" href="<?php echo e(route('admin.categories.create')); ?>" aria-label="Crea la prima categoria">
                        <i data-lucide="plus" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Crea Prima Categoria
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card border" style="border-color: #e5e7eb !important;">
                    <div class="card-body p-0">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex align-items-center p-3 border-bottom" style="border-color: #f3f4f6 !important;">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h6 class="mb-0 fw-semibold">
                                            <a href="<?php echo e(route('admin.categories.show', $category)); ?>" class="text-dark text-decoration-none"><?php echo e($category->name); ?></a>
                                        </h6>
                                        <span class="badge bg-light text-dark border small" style="border-color: #e5e7eb !important;"><?php echo e($category->pizzas_count); ?> pizze</span>
                                    </div>
                                    <?php if($category->description): ?>
                                        <div class="text-muted small"><?php echo e(\Illuminate\Support\Str::limit($category->description, 120)); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex align-items-center gap-2 ms-3 flex-shrink-0">
                        <a href="<?php echo e(route('admin.categories.edit', $category)); ?>"
                             class="btn btn-outline-success btn-sm d-flex align-items-center gap-1"
                             title="Modifica categoria">
                            <i data-lucide="pencil" style="width: 14px; height: 14px;"></i> <span>Modifica</span>
                        </a>
                        <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" data-confirm="Sicuro?" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                            class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1"
                                            title="Elimina categoria">
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

        <?php if(method_exists($categories,'hasPages') && $categories->hasPages()): ?>
            <div class="d-flex justify-content-center mt-5">
                <?php echo e($categories->links()); ?>

            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\my_project\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>