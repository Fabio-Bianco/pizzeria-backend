<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
   <?php $__env->slot('header', null, []); ?> 
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => $pizza->name,'items' => [['label'=>'Pizze','url'=>route('admin.pizzas.index')],['label'=>$pizza->name]],'backUrl' => route('admin.pizzas.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pizza->name),'items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label'=>'Pizze','url'=>route('admin.pizzas.index')],['label'=>$pizza->name]]),'backUrl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.pizzas.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
   <?php $__env->endSlot(); ?>

  <div class="container py-3">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-8">
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

        <div class="d-flex gap-2">
          <a href="<?php echo e(route('admin.pizzas.edit', $pizza)); ?>" class="btn btn-success">Modifica</a>
          <form action="<?php echo e(route('admin.pizzas.destroy', $pizza)); ?>" method="POST" data-confirm="Sicuro?">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button class="btn btn-danger" type="submit">Elimina</button>
          </form>
          <a href="<?php echo e(route('admin.pizzas.index')); ?>" class="btn btn-outline-secondary">Torna all'elenco</a>
        </div>
      </div>
    </div>
  </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/admin/pizzas/show.blade.php ENDPATH**/ ?>