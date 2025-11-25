
<div class="sidebar-wrapper">
  <!-- Mobile overlay -->
  <div class="mobile-overlay" onclick="closeSidebar()"></div>
  
  <div class="sidebar bg-white shadow-sm border-end d-flex flex-column">
    
    <nav class="sidebar-nav p-2 flex-grow-1">
      
      <div class="nav-section mb-2">
        <a href="<?php echo e(route('dashboard')); ?>" 
           class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>"
           style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 8px; margin: 0 8px;">
          <span class="nav-icon"><i data-lucide="layout-dashboard" style="width: 20px; height: 20px;"></i></span>
          <span class="nav-text fw-semibold">DASHBOARD</span>
          <i data-lucide="chevron-right" style="width: 18px; height: 18px;" class="ms-auto"></i>
        </a>
      </div>

      
      <div class="nav-section">
        <div class="nav-section-header" data-bs-target="#menuSection" aria-expanded="<?php echo e(request()->routeIs('admin.pizzas.*', 'admin.appetizers.*', 'admin.beverages.*', 'admin.desserts.*') ? 'true' : 'false'); ?>">
          <div class="nav-section-title px-3 py-2 small text-muted fw-semibold text-uppercase d-flex justify-content-between align-items-center">
            <span><i data-lucide="utensils" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Menu</span>
            <i data-lucide="chevron-down" class="transition-icon" style="width: 14px; height: 14px;"></i>
          </div>
        </div>
        
        <div id="menuSection" class="collapse nav-section-content <?php echo e(request()->routeIs('admin.pizzas.*', 'admin.appetizers.*', 'admin.beverages.*', 'admin.desserts.*') ? 'show' : ''); ?>">
          <a href="<?php echo e(route('admin.pizzas.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.pizzas.*') ? 'active' : ''); ?>"
             title="<?php echo e($countPizzas ?? 0); ?> pizze nel menu">
            <span class="nav-icon"><i data-lucide="pizza" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Pizze</span>
            <?php if(isset($countPizzas)): ?>
              <span class="nav-badge nav-badge-neutral <?php echo e(($countPizzas ?? 0) > 0 ? 'nav-badge-new' : ''); ?>"><?php echo e($countPizzas); ?></span>
            <?php endif; ?>
          </a>

          <a href="<?php echo e(route('admin.appetizers.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.appetizers.*') ? 'active' : ''); ?>"
             title="<?php echo e($countAppetizers ?? 0); ?> antipasti disponibili">
            <span class="nav-icon"><i data-lucide="salad" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Antipasti</span>
            <?php if(isset($countAppetizers)): ?>
              <span class="nav-badge nav-badge-neutral <?php echo e(($countAppetizers ?? 0) > 0 ? 'nav-badge-new' : ''); ?>"><?php echo e($countAppetizers); ?></span>
            <?php endif; ?>
          </a>

          <a href="<?php echo e(route('admin.beverages.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.beverages.*') ? 'active' : ''); ?>"
             title="<?php echo e($countBeverages ?? 0); ?> bevande in carta">
            <span class="nav-icon"><i data-lucide="glass-water" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Bevande</span>
            <?php if(isset($countBeverages)): ?>
              <span class="nav-badge nav-badge-neutral <?php echo e(($countBeverages ?? 0) > 0 ? 'nav-badge-new' : ''); ?>"><?php echo e($countBeverages); ?></span>
            <?php endif; ?>
          </a>

          <a href="<?php echo e(route('admin.desserts.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.desserts.*') ? 'active' : ''); ?>"
             title="<?php echo e($countDesserts ?? 0); ?> dessert disponibili">
            <span class="nav-icon"><i data-lucide="cake" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Dessert</span>
            <?php if(isset($countDesserts)): ?>
              <span class="nav-badge nav-badge-neutral <?php echo e(($countDesserts ?? 0) > 0 ? 'nav-badge-new' : ''); ?>"><?php echo e($countDesserts); ?></span>
            <?php endif; ?>
          </a>
        </div>
      </div>

      
      <div class="nav-section">
        <div class="nav-section-header" data-bs-target="#configSection" aria-expanded="<?php echo e(request()->routeIs('admin.ingredients.*', 'admin.allergens.*', 'admin.categories.*') ? 'true' : 'false'); ?>">
          <div class="nav-section-title px-3 py-2 small text-muted fw-semibold text-uppercase d-flex justify-content-between align-items-center">
            <span><i data-lucide="settings" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Configurazione</span>
            <i data-lucide="chevron-down" class="transition-icon" style="width: 14px; height: 14px;"></i>
          </div>
        </div>
        
        <div id="configSection" class="collapse nav-section-content <?php echo e(request()->routeIs('admin.ingredients.*', 'admin.allergens.*', 'admin.categories.*') ? 'show' : ''); ?>">
          <a href="<?php echo e(route('admin.ingredients.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.ingredients.*') ? 'active' : ''); ?>"
             title="<?php echo e($countIngredients ?? 0); ?> ingredienti catalogati">
            <span class="nav-icon"><i data-lucide="leaf" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Ingredienti</span>
            <?php if(isset($countIngredients)): ?>
              <span class="nav-badge nav-badge-warning <?php echo e(($countIngredients ?? 0) > 0 ? 'nav-badge-new' : ''); ?>"><?php echo e($countIngredients); ?></span>
            <?php endif; ?>
          </a>

          <a href="<?php echo e(route('admin.allergens.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.allergens.*') ? 'active' : ''); ?>"
             title="<?php echo e($countAllergens ?? 0); ?> allergeni configurati - Sistema attivo">
            <span class="nav-icon"><i data-lucide="shield-alert" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Allergeni</span>
            <div class="nav-stats">
              <?php if(isset($countAllergens)): ?>
                <span class="nav-badge nav-badge-danger nav-badge-new"><?php echo e($countAllergens); ?></span>
              <?php endif; ?>
              <div class="nav-status nav-status-active"></div>
            </div>
          </a>

          <a href="<?php echo e(route('admin.categories.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>"
             title="<?php echo e($countCategories ?? 0); ?> categorie per organizzare il menu">
            <span class="nav-icon"><i data-lucide="folder" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Categorie</span>
            <?php if(isset($countCategories)): ?>
              <span class="nav-badge nav-badge-secondary <?php echo e(($countCategories ?? 0) > 0 ? 'nav-badge-new' : ''); ?>"><?php echo e($countCategories); ?></span>
            <?php endif; ?>
          </a>
        </div>
      </div>

      
      <div class="nav-section">
        <div class="nav-section-header" data-bs-target="#actionsSection" aria-expanded="false">
          <div class="nav-section-title px-3 py-2 small text-muted fw-semibold text-uppercase d-flex justify-content-between align-items-center">
            <span><i data-lucide="zap" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Azioni Rapide</span>
            <i data-lucide="chevron-down" class="transition-icon" style="width: 14px; height: 14px;"></i>
          </div>
        </div>
        
        <div id="actionsSection" class="collapse nav-section-content">
          <a href="<?php echo e(route('admin.pizzas.create')); ?>" class="nav-link nav-link-action">
            <span class="nav-icon"><i data-lucide="plus-circle" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Nuova Pizza</span>
          </a>

          <a href="<?php echo e(route('admin.appetizers.create')); ?>" class="nav-link nav-link-action">
            <span class="nav-icon"><i data-lucide="plus-circle" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Nuovo Antipasto</span>
          </a>

          <a href="<?php echo e(route('admin.beverages.create')); ?>" class="nav-link nav-link-action">
            <span class="nav-icon"><i data-lucide="plus-circle" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Nuova Bevanda</span>
          </a>

          <a href="<?php echo e(route('admin.desserts.create')); ?>" class="nav-link nav-link-action">
            <span class="nav-icon"><i data-lucide="plus-circle" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Nuovo Dessert</span>
          </a>
        </div>
      </div>
    </nav>
    
    <div class="sidebar-profile-area border-top p-3 d-flex flex-column align-items-center">
      <div class="sidebar-profile-avatar mb-2">
        <?php if(auth()->user()->avatar): ?>
          <img src="<?php echo e(asset('storage/' . auth()->user()->avatar)); ?>" alt="<?php echo e(auth()->user()->name); ?>" class="rounded-circle" style="width: 44px; height: 44px; object-fit: cover; border: 2px solid #e5e7eb;">
        <?php else: ?>
          <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 1.3rem;">
            <?php echo e(strtoupper(substr(auth()->user()->name ?? 'U', 0, 1))); ?>

          </div>
        <?php endif; ?>
      </div>
      <div class="sidebar-profile-info text-center mb-2">
        <div class="fw-semibold text-dark small"><?php echo e(auth()->user()->name ?? 'Utente'); ?></div>
        <div class="tiny text-muted"><?php echo e(auth()->user()->email ?? 'admin@pizzeria.com'); ?></div>
      </div>
      <div class="sidebar-profile-actions d-flex gap-2" x-data="darkMode">
        <button 
          @click="toggle()" 
          class="btn btn-sm btn-outline-secondary px-3" 
          :title="'Tema: ' + label"
          :aria-label="'Tema: ' + label"
        >
          <i data-lucide="sun" x-show="theme === 'light'" style="width: 16px; height: 16px;"></i>
          <i data-lucide="moon" x-show="theme === 'dark'" style="width: 16px; height: 16px;"></i>
          <i data-lucide="monitor" x-show="theme === 'auto'" style="width: 16px; height: 16px;"></i>
        </button>
        <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-sm btn-outline-secondary px-3" title="Profilo">
          <i data-lucide="user-cog" style="width: 16px; height: 16px;"></i>
        </a>
        <form method="POST" action="<?php echo e(route('logout')); ?>" class="m-0">
          <?php echo csrf_field(); ?>
          <button type="submit" class="btn btn-sm btn-outline-danger px-3" title="Logout">
            <i data-lucide="log-out" style="width: 16px; height: 16px;"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</div><?php /**PATH C:\Users\Utente\Desktop\my_project\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>