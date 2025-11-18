<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => null,
    'items' => [], // es: [['label' => 'Pizze', 'url' => route('admin.pizzas.index')], ['label' => $pizza->name]]
    'backUrl' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => null,
    'items' => [], // es: [['label' => 'Pizze', 'url' => route('admin.pizzas.index')], ['label' => $pizza->name]]
    'backUrl' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <?php if($title): ?>
                <h1 class="h4 mb-1"><?php echo e($title); ?></h1>
            <?php endif; ?>
            <?php if(!empty($items)): ?>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $crumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php ($isLast = $index === count($items) - 1); ?>
                            <?php if(!$isLast && !empty($crumb['url'])): ?>
                                <li class="breadcrumb-item"><a href="<?php echo e($crumb['url']); ?>"><?php echo e($crumb['label']); ?></a></li>
                            <?php else: ?>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo e($crumb['label']); ?></li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ol>
                </nav>
            <?php endif; ?>
        </div>

        <div class="d-flex align-items-center gap-2 ms-auto">
            <?php echo e($actions ?? ''); ?>

            <?php if($backUrl): ?>
                <a href="<?php echo e($backUrl); ?>" class="btn btn-outline-secondary">Indietro</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Utente\Desktop\my_project\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/components/page-header.blade.php ENDPATH**/ ?>