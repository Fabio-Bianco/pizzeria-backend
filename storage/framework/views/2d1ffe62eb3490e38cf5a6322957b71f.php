<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo $__env->yieldContent('title', config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body>
        <div class="min-vh-100 d-flex align-items-center py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                        <?php echo $__env->yieldContent('content'); ?>
                        <?php echo e($slot ?? ''); ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- 🌙 Dark Mode Toggle (Optional - 3 states: Auto/Light/Dark) -->
        <div x-data="darkMode" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
            <button 
                @click="toggle()" 
                class="btn btn-sm btn-outline-secondary rounded-circle" 
                style="width: 50px; height: 50px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"
                :aria-label="'Tema: ' + label"
                :title="'Tema: ' + label"
            >
                <i class="fas" :class="icon" style="font-size: 1.2rem;"></i>
            </button>
        </div>
    </body>
</html>
<?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/layouts/guest.blade.php ENDPATH**/ ?>