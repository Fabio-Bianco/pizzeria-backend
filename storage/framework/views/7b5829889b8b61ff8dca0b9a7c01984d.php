<?php $__env->startSection('title', 'Accedi'); ?>

<?php $__env->startSection('content'); ?>
<div class="card border-0 shadow-sm">
    <div class="card-body p-5">
        <!-- Logo centrato -->
        <div class="text-center mb-4">
            <div class="mb-3">
                <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" style="width: 64px; height: 64px;">
                    <circle cx="32" cy="32" r="30" fill="#fcd34d" stroke="#b45309" stroke-width="2"/>
                    <path d="M32 2 A30 30 0 0 1 62 32 L32 32 Z" fill="#ef4444"/>
                    <circle cx="24" cy="24" r="3" fill="#991b1b"/>
                    <circle cx="40" cy="22" r="3" fill="#991b1b"/>
                    <circle cx="36" cy="36" r="3" fill="#991b1b"/>
                </svg>
            </div>
            <h1 class="h3 fw-bold text-dark mb-1">Benvenuto</h1>
            <p class="text-muted mb-0">Accedi al pannello di gestione</p>
        </div>

        <?php if(session('status')): ?>
            <div class="alert alert-success d-flex align-items-center mb-4">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>" novalidate>
            <?php echo csrf_field(); ?>
            
            <div class="mb-4">
                <label for="email" class="form-label fw-semibold">
                    <i class="fas fa-envelope me-1"></i>
                    Email
                </label>
                <input id="email" type="email" name="email" 
                       class="form-control form-control-lg <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                       value="<?php echo e(old('email')); ?>" 
                       required autofocus autocomplete="username"
                       placeholder="inserisci@email.com">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">
                    <i class="fas fa-lock me-1"></i>
                    Password
                </label>
                <input id="password" type="password" name="password" 
                       class="form-control form-control-lg <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                       required autocomplete="current-password"
                       placeholder="••••••••">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" id="remember" type="checkbox" name="remember" 
                           <?php echo e(old('remember') ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="remember">
                        Ricordami
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100">
                <i class="fas fa-sign-in-alt me-2"></i>
                Accedi
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/auth/login.blade.php ENDPATH**/ ?>