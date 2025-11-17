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
        
        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>

        <!-- Sidebar Styles -->
        <link rel="stylesheet" href="<?php echo e(asset('css/sidebar.css')); ?>">

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body>
        <!-- Skip navigation link per screen reader -->
        <a href="#main-content" class="skip-link">Salta alla navigazione principale</a>

        <!-- Mobile toggle button with proper ARIA -->
        <button 
            class="mobile-toggle" 
            type="button" 
            onclick="toggleSidebar()"
            aria-expanded="false"
            aria-controls="sidebar"
            aria-label="Apri/chiudi menu di navigazione"
        >
            <i data-lucide="menu" aria-hidden="true"></i>
            <span class="sr-only">Menu</span>
        </button>

        <!-- 🌙 Dark Mode Toggle (Optional - 3 states: Auto/Light/Dark) -->
        <div x-data="darkMode" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
            <button 
                @click="toggle()" 
                class="btn btn-sm btn-outline-secondary rounded-circle" 
                style="width: 50px; height: 50px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"
                :aria-label="'Tema: ' + label"
                :title="'Tema: ' + label"
            >
                <i data-lucide="sun" x-show="theme === 'light'" style="width: 20px; height: 20px;"></i>
                <i data-lucide="moon" x-show="theme === 'dark'" style="width: 20px; height: 20px;"></i>
                <i data-lucide="monitor" x-show="theme === 'auto'" style="width: 20px; height: 20px;"></i>
            </button>
        </div>
        
        <script src="<?php echo e(asset('js/app-modern.js')); ?>"></script>

        <!-- Sidebar with proper navigation role -->
        <nav id="sidebar" role="navigation" aria-label="Menu principale">
            <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </nav>

        <!-- Main content with proper landmark -->
        <main class="main-content" id="main-content" role="main" aria-label="Contenuto principale">
            <div class="content-wrapper">
                <!-- Page Header with proper heading structure -->
                <?php if (! empty(trim($__env->yieldContent('header')))): ?>
                    <header class="page-header fade-in" role="banner">
                        <?php echo $__env->yieldContent('header'); ?>
                    </header>
                <?php elseif(isset($header)): ?>
                    <header class="page-header fade-in" role="banner">
                        <?php echo e($header); ?>

                    </header>
                <?php endif; ?>

                <!-- Flash Messages with proper ARIA live region -->
                <div aria-live="polite" aria-atomic="true">
                    <?php echo $__env->make('partials.flash-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!-- Page Content -->
                <section class="slide-up" aria-label="Contenuto della pagina">
                    <?php if(isset($slot)): ?>
                        <?php echo e($slot); ?>

                    <?php else: ?>
                        <?php echo $__env->yieldContent('content'); ?>
                    <?php endif; ?>
                </section>
            </div>
        </main>

        <!-- Sidebar JavaScript -->
        <script src="<?php echo e(asset('js/sidebar.js')); ?>"></script>
    </body>
</html><?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/layouts/app-modern.blade.php ENDPATH**/ ?>