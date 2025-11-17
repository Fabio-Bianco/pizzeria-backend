<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'search' => true,
    'searchName' => 'search',
    'searchValue' => request('search'),
    'searchPlaceholder' => 'Cerca…',
    // Array di select: [['name' => 'category', 'placeholder' => 'Tutte le categorie', 'options' => [id=>label]]]
    'selects' => [],
    // Opzioni ordinamento: ['' => 'Più recenti', 'name_asc' => 'Nome A→Z', ...]
    'sortOptions' => [],
    'sortValue' => request('sort'),
    'resetUrl' => url()->current(),
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
    'search' => true,
    'searchName' => 'search',
    'searchValue' => request('search'),
    'searchPlaceholder' => 'Cerca…',
    // Array di select: [['name' => 'category', 'placeholder' => 'Tutte le categorie', 'options' => [id=>label]]]
    'selects' => [],
    // Opzioni ordinamento: ['' => 'Più recenti', 'name_asc' => 'Nome A→Z', ...]
    'sortOptions' => [],
    'sortValue' => request('sort'),
    'resetUrl' => url()->current(),
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<form method="GET" class="card mb-3">
  <div class="card-body">
    <div class="row g-2">
      <?php if($search): ?>
        <div class="col-12 col-md-4">
          <input name="<?php echo e($searchName); ?>" type="search" value="<?php echo e($searchValue); ?>" class="form-control" placeholder="<?php echo e($searchPlaceholder); ?>">
        </div>
      <?php endif; ?>

      <?php $__currentLoopData = $selects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $select): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-6 col-md-3">
          <select name="<?php echo e($select['name']); ?>" class="form-select" data-choices>
            <option value=""><?php echo e($select['placeholder'] ?? 'Tutti'); ?></option>
            <?php $__currentLoopData = ($select['options'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($value); ?>" <?php if((string)$value === (string)request($select['name'])): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      <?php if(!empty($sortOptions)): ?>
        <div class="col-6 col-md-2">
          <select name="sort" class="form-select" data-choices>
            <?php $__currentLoopData = $sortOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($value); ?>" <?php if((string)$value === (string)$sortValue): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
      <?php endif; ?>
    </div>
    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-outline-warning" type="submit">Filtra</button>
      <a class="btn btn-outline-secondary" href="<?php echo e($resetUrl); ?>">Reset</a>
    </div>
  </div>
</form>
<?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/components/filter-toolbar.blade.php ENDPATH**/ ?>