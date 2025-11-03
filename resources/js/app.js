import "./bootstrap";
import Alpine from "alpinejs";  
import * as bootstrap from "bootstrap";

window.Alpine = Alpine;
window.bootstrap = bootstrap;
Alpine.start();

// 📱 Gestione sidebar collassabile
document.addEventListener('DOMContentLoaded', function() {
    console.log("🍕 App loaded successfully!");
    
    // Inizializza i collapse di Bootstrap
    const collapseElements = document.querySelectorAll('.collapse');
    collapseElements.forEach(element => {
        new bootstrap.Collapse(element, {
            toggle: false
        });
    });
    
    // Gestisce le icone dei menu collassabili
    const toggles = document.querySelectorAll('.nav-section-header');
    toggles.forEach(toggle => {
        const targetId = toggle.getAttribute('data-bs-target');
        if (targetId) {
            const target = document.querySelector(targetId);
            const icon = toggle.querySelector('.transition-icon');
            
            toggle.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                
                if (target) {
                    if (isExpanded) {
                        bootstrap.Collapse.getInstance(target)?.hide();
                    } else {
                        new bootstrap.Collapse(target, { toggle: true });
                    }
                }
            });
            
            if (target && icon) {
                target.addEventListener('show.bs.collapse', () => {
                    icon.style.transform = 'rotate(180deg)';
                    toggle.setAttribute('aria-expanded', 'true');
                });
                
                target.addEventListener('hide.bs.collapse', () => {
                    icon.style.transform = 'rotate(0deg)';
                    toggle.setAttribute('aria-expanded', 'false');
                });
            }
        }
    });
    
    console.log(`✅ Inizializzati ${toggles.length} menu collassabili`);
});

// 🍕 Funzioni globali per sidebar mobile
window.toggleSidebar = function() {
    const sidebar = document.querySelector('.sidebar-wrapper');
    if (sidebar) {
        sidebar.classList.toggle('show');
    }
};

window.closeSidebar = function() {
    const sidebar = document.querySelector('.sidebar-wrapper');
    if (sidebar) {
        sidebar.classList.remove('show');
    }
};
