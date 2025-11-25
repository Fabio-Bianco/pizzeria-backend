{{-- Sidebar moderna per backoffice --}}
<div class="sidebar-wrapper">
  <!-- Mobile overlay -->
  <div class="mobile-overlay" onclick="closeSidebar()"></div>
  
  <div class="sidebar bg-white shadow-sm border-end d-flex flex-column">
    {{-- Navigazione principale in alto --}}
    <nav class="sidebar-nav p-2 flex-grow-1">
      {{-- Dashboard Link --}}
      <div class="nav-section mb-2">
        <a href="{{ route('dashboard') }}" 
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
           style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 8px; margin: 0 8px;">
          <span class="nav-icon"><i data-lucide="layout-dashboard" style="width: 20px; height: 20px;"></i></span>
          <span class="nav-text fw-semibold">DASHBOARD</span>
          <i data-lucide="chevron-right" style="width: 18px; height: 18px;" class="ms-auto"></i>
        </a>
      </div>

      {{-- Sezione Gestione Menu (Collapsible) --}}
      <div class="nav-section">
        <div class="nav-section-header" data-bs-target="#menuSection" aria-expanded="{{ request()->routeIs('admin.pizzas.*', 'admin.appetizers.*', 'admin.beverages.*', 'admin.desserts.*') ? 'true' : 'false' }}">
          <div class="nav-section-title px-3 py-2 small text-muted fw-semibold text-uppercase d-flex justify-content-between align-items-center">
            <span><i data-lucide="utensils" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Menu</span>
            <i data-lucide="chevron-down" class="transition-icon" style="width: 14px; height: 14px;"></i>
          </div>
        </div>
        
        <div id="menuSection" class="collapse nav-section-content {{ request()->routeIs('admin.pizzas.*', 'admin.appetizers.*', 'admin.beverages.*', 'admin.desserts.*') ? 'show' : '' }}">
          <a href="{{ route('admin.pizzas.index') }}" 
             class="nav-link {{ request()->routeIs('admin.pizzas.*') ? 'active' : '' }}"
             title="{{ $countPizzas ?? 0 }} pizze nel menu">
            <span class="nav-icon"><i data-lucide="pizza" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Pizze</span>
            @if(isset($countPizzas))
              <span class="nav-badge nav-badge-neutral {{ ($countPizzas ?? 0) > 0 ? 'nav-badge-new' : '' }}">{{ $countPizzas }}</span>
            @endif
          </a>

          <a href="{{ route('admin.appetizers.index') }}" 
             class="nav-link {{ request()->routeIs('admin.appetizers.*') ? 'active' : '' }}"
             title="{{ $countAppetizers ?? 0 }} antipasti disponibili">
            <span class="nav-icon"><i data-lucide="salad" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Antipasti</span>
            @if(isset($countAppetizers))
              <span class="nav-badge nav-badge-neutral {{ ($countAppetizers ?? 0) > 0 ? 'nav-badge-new' : '' }}">{{ $countAppetizers }}</span>
            @endif
          </a>

          <a href="{{ route('admin.beverages.index') }}" 
             class="nav-link {{ request()->routeIs('admin.beverages.*') ? 'active' : '' }}"
             title="{{ $countBeverages ?? 0 }} bevande in carta">
            <span class="nav-icon"><i data-lucide="glass-water" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Bevande</span>
            @if(isset($countBeverages))
              <span class="nav-badge nav-badge-neutral {{ ($countBeverages ?? 0) > 0 ? 'nav-badge-new' : '' }}">{{ $countBeverages }}</span>
            @endif
          </a>

          <a href="{{ route('admin.desserts.index') }}" 
             class="nav-link {{ request()->routeIs('admin.desserts.*') ? 'active' : '' }}"
             title="{{ $countDesserts ?? 0 }} dessert disponibili">
            <span class="nav-icon"><i data-lucide="cake" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Dessert</span>
            @if(isset($countDesserts))
              <span class="nav-badge nav-badge-neutral {{ ($countDesserts ?? 0) > 0 ? 'nav-badge-new' : '' }}">{{ $countDesserts }}</span>
            @endif
          </a>
        </div>
      </div>

      {{-- Sezione Configurazione (Collapsible) --}}
      <div class="nav-section">
        <div class="nav-section-header" data-bs-target="#configSection" aria-expanded="{{ request()->routeIs('admin.ingredients.*', 'admin.allergens.*', 'admin.categories.*') ? 'true' : 'false' }}">
          <div class="nav-section-title px-3 py-2 small text-muted fw-semibold text-uppercase d-flex justify-content-between align-items-center">
            <span><i data-lucide="settings" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Configurazione</span>
            <i data-lucide="chevron-down" class="transition-icon" style="width: 14px; height: 14px;"></i>
          </div>
        </div>
        
        <div id="configSection" class="collapse nav-section-content {{ request()->routeIs('admin.ingredients.*', 'admin.allergens.*', 'admin.categories.*') ? 'show' : '' }}">
          <a href="{{ route('admin.ingredients.index') }}" 
             class="nav-link {{ request()->routeIs('admin.ingredients.*') ? 'active' : '' }}"
             title="{{ $countIngredients ?? 0 }} ingredienti catalogati">
            <span class="nav-icon"><i data-lucide="leaf" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Ingredienti</span>
            @if(isset($countIngredients))
              <span class="nav-badge nav-badge-warning {{ ($countIngredients ?? 0) > 0 ? 'nav-badge-new' : '' }}">{{ $countIngredients }}</span>
            @endif
          </a>

          <a href="{{ route('admin.allergens.index') }}" 
             class="nav-link {{ request()->routeIs('admin.allergens.*') ? 'active' : '' }}"
             title="{{ $countAllergens ?? 0 }} allergeni configurati - Sistema attivo">
            <span class="nav-icon"><i data-lucide="shield-alert" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Allergeni</span>
            <div class="nav-stats">
              @if(isset($countAllergens))
                <span class="nav-badge nav-badge-danger nav-badge-new">{{ $countAllergens }}</span>
              @endif
              <div class="nav-status nav-status-active"></div>
            </div>
          </a>

          <a href="{{ route('admin.categories.index') }}" 
             class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
             title="{{ $countCategories ?? 0 }} categorie per organizzare il menu">
            <span class="nav-icon"><i data-lucide="folder" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Categorie</span>
            @if(isset($countCategories))
              <span class="nav-badge nav-badge-secondary {{ ($countCategories ?? 0) > 0 ? 'nav-badge-new' : '' }}">{{ $countCategories }}</span>
            @endif
          </a>
        </div>
      </div>

      {{-- Sezione Azioni Rapide (Collapsible) --}}
      <div class="nav-section">
        <div class="nav-section-header" data-bs-target="#actionsSection" aria-expanded="false">
          <div class="nav-section-title px-3 py-2 small text-muted fw-semibold text-uppercase d-flex justify-content-between align-items-center">
            <span><i data-lucide="zap" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>Azioni Rapide</span>
            <i data-lucide="chevron-down" class="transition-icon" style="width: 14px; height: 14px;"></i>
          </div>
        </div>
        
        <div id="actionsSection" class="collapse nav-section-content">
          <a href="{{ route('admin.pizzas.create') }}" class="nav-link nav-link-action">
            <span class="nav-icon"><i data-lucide="plus-circle" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Nuova Pizza</span>
          </a>

          <a href="{{ route('admin.appetizers.create') }}" class="nav-link nav-link-action">
            <span class="nav-icon"><i data-lucide="plus-circle" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Nuovo Antipasto</span>
          </a>

          <a href="{{ route('admin.beverages.create') }}" class="nav-link nav-link-action">
            <span class="nav-icon"><i data-lucide="plus-circle" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Nuova Bevanda</span>
          </a>

          <a href="{{ route('admin.desserts.create') }}" class="nav-link nav-link-action">
            <span class="nav-icon"><i data-lucide="plus-circle" style="width: 18px; height: 18px;"></i></span>
            <span class="nav-text">Nuovo Dessert</span>
          </a>
        </div>
      </div>
    </nav>
    {{-- Area profilo/logout in basso --}}
    <div class="sidebar-profile-area border-top p-3 d-flex flex-column align-items-center">
      <div class="sidebar-profile-avatar mb-2">
        @if(auth()->user()->avatar)
          <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="rounded-circle" style="width: 44px; height: 44px; object-fit: cover; border: 2px solid #e5e7eb;">
        @else
          <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 1.3rem;">
            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
          </div>
        @endif
      </div>
      <div class="sidebar-profile-info text-center mb-2">
        <div class="fw-semibold text-dark small">{{ auth()->user()->name ?? 'Utente' }}</div>
        <div class="tiny text-muted">{{ auth()->user()->email ?? 'admin@pizzeria.com' }}</div>
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
        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-secondary px-3" title="Profilo">
          <i data-lucide="user-cog" style="width: 16px; height: 16px;"></i>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
          @csrf
          <button type="submit" class="btn btn-sm btn-outline-danger px-3" title="Logout">
            <i data-lucide="log-out" style="width: 16px; height: 16px;"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>