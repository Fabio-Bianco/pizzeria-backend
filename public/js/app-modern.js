// Inizializza Lucide Icons (una sola volta)
if (typeof lucide !== 'undefined') {
    // Aspetta che DOM e Lucide siano pronti
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initIcons);
    } else {
        initIcons();
    }
    
    // Reinizializza quando si torna indietro con il browser (fix placeholder)
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || performance.getEntriesByType("navigation")[0]?.type === 'back_forward') {
            initIcons();
        }
    });
}

function initIcons() {
    lucide.createIcons();
    
    // Reinizializza dopo Alpine (dark mode toggle)
    document.addEventListener('alpine:initialized', () => {
        setTimeout(() => lucide.createIcons(), 50);
    }, { once: true });
}

// Funzione sidebar (spostata da sidebar.js)
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mobileToggle = document.querySelector('.mobile-toggle');
    sidebar.classList.toggle('active');
    const isExpanded = sidebar.classList.contains('active');
    mobileToggle?.setAttribute('aria-expanded', isExpanded);
}
