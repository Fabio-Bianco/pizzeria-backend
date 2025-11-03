<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var overlay = document.getElementById('profile-success-overlay');
        var showOverlay = false;
        // Mostra overlay se hash oppure session status (inserito come attributo data-status)
        if (window.location.hash === '#success-profile' || window.location.hash === '#success-password') {
            showOverlay = true;
        }
        if (overlay && overlay.dataset.status === 'profile-updated') {
            showOverlay = true;
        }
        if (overlay && overlay.dataset.status === 'password-updated') {
            showOverlay = true;
        }
        if (showOverlay && overlay) {
            overlay.classList.remove('d-none');
        }
        document.querySelectorAll('.close-profile-success').forEach(function(btn) {
            btn.addEventListener('click', function() {
                overlay.classList.add('d-none');
                window.location.hash = '';
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('title', 'Profilo personale'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
    <div class="mb-2" style="font-size:3rem;">👤</div>
    <h1 class="display-6 fw-bold text-dark mb-2">Profilo personale</h1>
    <p class="lead text-muted mb-4">Gestisci i dati del tuo profilo, la password e l'account</p>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-center">
    <div class="w-100" style="max-width: 520px;">
        
        <ul class="nav nav-tabs mb-4 justify-content-center" id="profileTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
                    <i class="fas fa-user me-1"></i> Dati profilo
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">
                    <i class="fas fa-key me-1"></i> Password
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="delete-tab" data-bs-toggle="tab" data-bs-target="#delete" type="button" role="tab" aria-controls="delete" aria-selected="false">
                    <i class="fas fa-user-slash me-1"></i> Elimina account
                </button>
            </li>
        </ul>
        <div class="tab-content" id="profileTabContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab" tabindex="0">
                <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <div class="tab-pane fade" id="delete" role="tabpanel" aria-labelledby="delete-tab" tabindex="0">
                <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>
</div>


<div id="profile-success-overlay" class="position-fixed top-0 start-0 w-100 h-100 d-none" style="z-index: 2000; background: rgba(0,0,0,0.35);" data-status="<?php echo e(session('status')); ?>">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="bg-white rounded shadow p-4 text-center" style="min-width:320px;max-width:90vw;">
            <div class="mb-3" style="font-size:2.5rem;">✅</div>
            <?php $status = session('status'); ?>
            <?php if($status === 'profile-updated'): ?>
                <h5 class="mb-3">Dati profilo aggiornati correttamente.</h5>
            <?php elseif($status === 'password-updated'): ?>
                <h5 class="mb-3">Password aggiornata correttamente.</h5>
            <?php else: ?>
                <h5 class="mb-3">Operazione completata con successo.</h5>
            <?php endif; ?>
            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-success px-4">Torna al pannello di gestione</a>
            <button type="button" class="btn btn-link mt-2 close-profile-success">Chiudi</button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/profile/edit.blade.php ENDPATH**/ ?>