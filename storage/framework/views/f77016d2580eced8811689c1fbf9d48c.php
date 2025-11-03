
<?php if(session('status') || session('success')): ?>
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

<style>
.alert {
    border-radius: 12px;
    border: none;
    margin-bottom: 1.5rem;
    padding: 1.25rem 1.5rem;
    position: relative;
    overflow: hidden;
    font-weight: 500;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.alert::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: currentColor;
    opacity: 0.7;
}

/* Light Mode Alerts */
.alert-success {
    background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%);
    color: #047857;
    border-left: 4px solid #10B981;
}

.alert-danger {
    background: linear-gradient(135deg, #FEF2F2 0%, #FEE2E2 100%);
    color: #DC2626;
    border-left: 4px solid #EF4444;
}

.alert-warning {
    background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
    color: #D97706;
    border-left: 4px solid #F59E0B;
}

.alert-info {
    background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%);
    color: #1D4ED8;
    border-left: 4px solid #3B82F6;
}

/* Dark Mode Alerts - Contrasti Ottimizzati */
[data-theme="dark"] .alert-success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
    color: #34D399;
    border-left: 4px solid #10B981;
    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.2);
}

[data-theme="dark"] .alert-danger {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.05) 100%);
    color: #F87171;
    border-left: 4px solid #EF4444;
    box-shadow: 0 4px 20px rgba(239, 68, 68, 0.2);
}

[data-theme="dark"] .alert-warning {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.05) 100%);
    color: #FBBF24;
    border-left: 4px solid #F59E0B;
    box-shadow: 0 4px 20px rgba(245, 158, 11, 0.2);
}

[data-theme="dark"] .alert-info {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.05) 100%);
    color: #60A5FA;
    border-left: 4px solid #3B82F6;
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.2);
}

.btn-close {
    --bs-btn-close-bg: none;
    background: transparent;
    border: none;
    font-size: 1.1rem;
    opacity: 0.6;
    transition: opacity 0.2s ease;
    color: currentColor;
}

.btn-close:hover {
    opacity: 1;
}

[data-theme="dark"] .btn-close {
    filter: invert(1);
    opacity: 0.7;
}

[data-theme="dark"] .btn-close:hover {
    opacity: 1;
}

@media (max-width: 768px) {
    .alert {
        margin-left: 0;
        margin-right: 0;
        border-radius: 8px;
        padding: 1rem 1.25rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after specified time
    const alerts = document.querySelectorAll('[data-auto-dismiss]');
    alerts.forEach(alert => {
        const dismissTime = parseInt(alert.getAttribute('data-auto-dismiss'));
        if (dismissTime > 0) {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, dismissTime);
        }
    });
});
</script><?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/partials/flash-modern.blade.php ENDPATH**/ ?>