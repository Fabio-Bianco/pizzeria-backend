
<?php if((session('status') && !in_array(session('status'), ['profile-updated', 'password-updated'])) || session('success')): ?>
    <div class="alert alert-success d-flex align-items-center slide-up" data-auto-dismiss="10000" role="alert">
        <div class="me-2">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="flex-grow-1">
            <strong>Successo!</strong>
            <?php echo e(session('status') ?? session('success')); ?>

        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(session('error') || session('danger')): ?>
    <div class="alert alert-danger d-flex align-items-center slide-up" data-auto-dismiss="10000" role="alert">
        <div class="me-2">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="flex-grow-1">
            <strong>Errore!</strong>
            <?php echo e(session('error') ?? session('danger')); ?>

        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(session('warning')): ?>
    <div class="alert alert-warning d-flex align-items-center slide-up" data-auto-dismiss="10000" role="alert">
        <div class="me-2">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div class="flex-grow-1">
            <strong>Attenzione!</strong>
            <?php echo e(session('warning')); ?>

        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(session('info')): ?>
    <div class="alert alert-info d-flex align-items-center slide-up" data-auto-dismiss="10000" role="alert">
        <div class="me-2">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="flex-grow-1">
            <strong>Info:</strong>
            <?php echo e(session('info')); ?>

        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>


<?php if($errors->any()): ?>
    <div class="alert alert-danger slide-up" role="alert">
        <div class="d-flex align-items-start">
            <div class="me-2 mt-1">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="flex-grow-1">
                <strong>Correggi i seguenti errori:</strong>
                <ul class="mb-0 mt-2 ps-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<link rel="stylesheet" href="<?php echo e(asset('css/flash-alerts.css')); ?>">
<script src="<?php echo e(asset('js/flash-alerts.js')); ?>"></script><?php /**PATH C:\Users\Utente\Desktop\my_project\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/partials/flash-modern.blade.php ENDPATH**/ ?>