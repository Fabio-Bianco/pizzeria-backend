<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
  <div class="container">
  <a class="navbar-brand d-inline-flex align-items-center me-2" href="<?php echo e(route('dashboard')); ?>" aria-label="Home Pannello di controllo">
      <span class="brand-logo" aria-hidden="true">
        <!-- Logo pizza (stesso del login) -->
        <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <circle cx="32" cy="32" r="30" fill="#fcd34d" stroke="#b45309" stroke-width="2"/>
            <path d="M32 2 A30 30 0 0 1 62 32 L32 32 Z" fill="#ef4444"/>
            <circle cx="24" cy="24" r="3" fill="#991b1b"/>
            <circle cx="40" cy="22" r="3" fill="#991b1b"/>
            <circle cx="36" cy="36" r="3" fill="#991b1b"/>
        </svg>
      </span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end" id="mainNavbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
        <?php if(auth()->guard()->check()): ?>
          <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('admin.pizzas.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.pizzas.index')); ?>">Pizze</a></li>
          <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('admin.ingredients.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.ingredients.index')); ?>">Ingredienti</a></li>
          <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('admin.allergens.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.allergens.index')); ?>">Allergeni</a></li>
          <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.categories.index')); ?>">Categorie</a></li>
          <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('admin.beverages.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.beverages.index')); ?>">Bevande</a></li>
        <?php endif; ?>

        <?php if(auth()->guard()->check()): ?>
          <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>" href="<?php echo e(route('profile.edit')); ?>">Profilo personale</a></li>
        <?php endif; ?>

        <?php if(auth()->guard()->check()): ?>
          <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">Pannello di controllo</a></li>
        <?php endif; ?>

        <?php if(auth()->guard()->guest()): ?>
          <li class="nav-item"><a class="btn btn-outline-primary ms-lg-2" href="<?php echo e(route('login')); ?>" aria-current="<?php echo e(request()->routeIs('login') ? 'page' : false); ?>">Login</a></li>
        <?php endif; ?>

        <?php if(auth()->guard()->check()): ?>
          <li class="nav-item">
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
              <?php echo csrf_field(); ?>
              <button type="submit" class="btn btn-outline-danger ms-lg-2">Logout</button>
            </form>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>