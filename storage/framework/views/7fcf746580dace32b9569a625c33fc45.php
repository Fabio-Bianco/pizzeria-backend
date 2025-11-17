
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
              <span class="nav-badge nav-badge-neutral"><?php echo e($countPizzas); ?></span>
            <?php endif; ?>
          </a>

          <a href="<?php echo e(route('admin.appetizers.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.appetizers.*') ? 'active' : ''); ?>"
             title="<?php echo e($countAppetizers ?? 0); ?> antipasti disponibili">
            <span class="nav-icon"><i data-lucide="salad" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Antipasti</span>
            <?php if(isset($countAppetizers)): ?>
              <span class="nav-badge nav-badge-neutral"><?php echo e($countAppetizers); ?></span>
            <?php endif; ?>
          </a>

          <a href="<?php echo e(route('admin.beverages.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.beverages.*') ? 'active' : ''); ?>"
             title="<?php echo e($countBeverages ?? 0); ?> bevande in carta">
            <span class="nav-icon"><i data-lucide="glass-water" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Bevande</span>
            <?php if(isset($countBeverages)): ?>
              <span class="nav-badge nav-badge-neutral"><?php echo e($countBeverages); ?></span>
            <?php endif; ?>
          </a>

          <a href="<?php echo e(route('admin.desserts.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.desserts.*') ? 'active' : ''); ?>"
             title="<?php echo e($countDesserts ?? 0); ?> dessert disponibili">
            <span class="nav-icon"><i data-lucide="cake" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Dessert</span>
            <?php if(isset($countDesserts)): ?>
              <span class="nav-badge nav-badge-neutral"><?php echo e($countDesserts); ?></span>
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
              <span class="nav-badge nav-badge-warning"><?php echo e($countIngredients); ?></span>
            <?php endif; ?>
          </a>

          <a href="<?php echo e(route('admin.allergens.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.allergens.*') ? 'active' : ''); ?>"
             title="<?php echo e($countAllergens ?? 0); ?> allergeni configurati - Sistema attivo">
            <span class="nav-icon"><i data-lucide="shield-alert" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Allergeni</span>
            <div class="nav-stats">
              <?php if(isset($countAllergens)): ?>
                <span class="nav-badge nav-badge-danger"><?php echo e($countAllergens); ?></span>
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
              <span class="nav-badge nav-badge-secondary"><?php echo e($countCategories); ?></span>
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
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 1.3rem;">
          <?php echo e(strtoupper(substr(auth()->user()->name ?? 'U', 0, 1))); ?>

        </div>
      </div>
      <div class="sidebar-profile-info text-center mb-2">
        <div class="fw-semibold text-dark small"><?php echo e(auth()->user()->name ?? 'Utente'); ?></div>
        <div class="tiny text-muted"><?php echo e(auth()->user()->email ?? 'admin@pizzeria.com'); ?></div>
      </div>
      <div class="sidebar-profile-actions d-flex gap-2">
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
</div>


<style>
.sidebar-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 280px;
  z-index: 1000;
}

.mobile-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 999;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.sidebar {
  height: 100%;
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  position: relative;
  z-index: 1001;
}

.sidebar-nav {
  flex: 1;
}

.nav-section {
  margin-bottom: 1rem;
}

.nav-section:last-child {
  margin-bottom: 0;
}

.nav-link {
  display: flex;
  align-items: center;
  padding: 0.75rem 1rem;
  margin: 0.125rem 0;
  border-radius: 0.5rem;
  text-decoration: none;
  color: #6B7280;
  transition: all 0.2s ease;
  position: relative;
}

.nav-link:hover {
  background-color: #F3F4F6;
  color: #374151;
  text-decoration: none;
}

.nav-link.active {
  background-color: #28a745;
  color: white;
  font-weight: 500;
}

.nav-link-action {
  background-color: #F0FDF4;
  color: #059669;
  border: 1px solid #D1FAE5;
}

.nav-link-action:hover {
  background-color: #DCFCE7;
  color: #047857;
}

.nav-icon {
  font-size: 1.1rem;
  margin-right: 0.75rem;
  min-width: 20px;
}

.nav-text {
  flex: 1;
}

.nav-badge {
  background-color: #E5E7EB;
  color: #6B7280;
  font-size: 0.75rem;
  padding: 0.125rem 0.5rem;
  border-radius: 1rem;
  min-width: 1.5rem;
  text-align: center;
  font-weight: 500;
}

/* Badge colors */
.nav-badge-neutral {
  background-color: #f7fafc;
  color: #2d3748;
  border: 1px solid #e2e8f0;
  font-weight: 600;
}

.nav-link.active .nav-badge {
  background-color: rgba(255, 255, 255, 0.2);
  color: white;
}

/* Advanced nav stats */
.nav-stats {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 0.125rem;
}

.nav-latest {
  font-size: 0.6875rem;
  color: #9CA3AF;
  font-weight: 400;
  max-width: 80px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.nav-link.active .nav-latest {
  color: rgba(255, 255, 255, 0.7);
}

.nav-detail {
  font-size: 0.6875rem;
  color: #9CA3AF;
  font-weight: 400;
}

.nav-link.active .nav-detail {
  color: rgba(255, 255, 255, 0.7);
}

/* Status indicators */
.nav-status {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background-color: #9CA3AF;
}

.nav-status-active {
  background-color: #10B981;
  box-shadow: 0 0 6px rgba(16, 185, 129, 0.5);
}

/* Info-only nav links */
.nav-link-info {
  cursor: default;
  background-color: #F9FAFB;
  border: 1px solid #E5E7EB;
  margin: 0.25rem 0;
}

.nav-link-info:hover {
  background-color: #F3F4F6;
}

/* Transition effects */
.nav-link {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.nav-badge, .nav-status {
  transition: all 0.2s ease;
}

.nav-link:hover .nav-badge {
  transform: scale(1.05);
}

.nav-link:hover .nav-status-active {
  box-shadow: 0 0 10px rgba(16, 185, 129, 0.7);
}

.tiny {
  font-size: 0.6875rem;
}

/* Improved mobile responsiveness */
@media (max-width: 768px) {
  .sidebar-wrapper {
    transform: translateX(-100%);
    transition: transform 0.3s ease;
    width: 72px;
  }
  .sidebar {
    width: 72px;
    min-width: 72px;
    padding: 0;
    align-items: center;
  }
  .sidebar-nav, .sidebar-profile-info, .sidebar-profile-actions {
    display: none !important;
  }
  .sidebar-profile-area {
    border-top: none;
    padding: 0.5rem 0;
    width: 100%;
    justify-content: center;
  }
  .sidebar-profile-avatar {
    margin-bottom: 0;
  }
  .sidebar-profile-avatar > div {
    width: 44px;
    height: 44px;
    font-size: 1.3rem;
  }
  .sidebar-wrapper.show {
    transform: translateX(0);
    width: 280px;
  }
  .sidebar-wrapper.show .sidebar {
    width: 280px;
    min-width: 280px;
  }
  .sidebar-wrapper.show .sidebar-nav,
  .sidebar-wrapper.show .sidebar-profile-info,
  .sidebar-wrapper.show .sidebar-profile-actions {
    display: block !important;
  }
  .sidebar-wrapper.show .mobile-overlay {
    display: block;
    opacity: 1;
  }
  .mobile-overlay {
    display: block;
  }
}

/* Smooth scrolling for sidebar nav */
.sidebar-nav {
  scrollbar-width: thin;
  scrollbar-color: #D1D5DB #F9FAFB;
}

.sidebar-nav::-webkit-scrollbar {
  width: 6px;
}

.sidebar-nav::-webkit-scrollbar-track {
  background: #F9FAFB;
}

.sidebar-nav::-webkit-scrollbar-thumb {
  background-color: #D1D5DB;
  border-radius: 3px;
}

.sidebar-nav::-webkit-scrollbar-thumb:hover {
  background-color: #9CA3AF;
}

/* Navigation section styling */
.nav-section-header {
  cursor: pointer;
  transition: background-color 0.2s ease;
  border-radius: 0.5rem;
  margin: 0.125rem 0;
}

.nav-section-header:hover {
  background-color: #F3F4F6;
}

.transition-icon {
  transition: transform 0.3s ease;
  font-size: 0.75rem;
}

.nav-section-header[aria-expanded="true"] .transition-icon {
  transform: rotate(180deg);
}

/* Collapse animations personalizzate */
.collapse {
  overflow: hidden;
  transition: all 0.3s ease;
}

.collapse:not(.show) {
  max-height: 0;
  opacity: 0;
  padding: 0;
}

.collapse.show {
  max-height: 500px;
  opacity: 1;
  padding: 0.5rem 0;
}

.nav-section-content {
  border-left: 2px solid #E5E7EB;
  margin-left: 1rem;
}

.nav-section-content .nav-link {
  padding-left: 1.5rem;
  font-size: 0.9rem;
/* Dark mode button stile sidebar */
.btn-outline-darkmode {
  background: transparent;
  border: 1.5px solid #e2e8f0;
  color: #6B7280;
  transition: all 0.2s;
}
.btn-outline-darkmode:hover, .btn-outline-darkmode:focus {
  background: #222;
  color: #fff;
  border-color: #222;
}
.btn-outline-darkmode[aria-pressed="true"] {
  background: #222;
  color: #fff;
  border-color: #222;
}
</style>

<script>
  // Inizializza Lucide Icons nella sidebar
  document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
  });
  
  // Reinizializza dopo operazioni dinamiche
  document.addEventListener('shown.bs.collapse', () => {
    setTimeout(() => lucide.createIcons(), 50);
  });
</script><?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>