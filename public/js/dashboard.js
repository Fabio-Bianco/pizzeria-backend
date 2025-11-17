document.addEventListener('DOMContentLoaded', function() {
    // Inizializza i tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Loading state per navigazione (UX feedback immediato)
    document.querySelectorAll('.hover-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // Mostra feedback visivo immediato
            const btn = this.querySelector('.btn');
            if (btn) {
                const originalText = btn.innerHTML;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Caricamento...';
                btn.classList.add('disabled');
            }
            
            // Aggiungi overlay di caricamento leggero
            this.style.opacity = '0.7';
            this.style.cursor = 'wait';
        });
    });
    
    // Controlla se è il primo accesso dell'utente
    const isFirstTime = !localStorage.getItem('pizzeria_visited');
    
    if (isFirstTime) {
        // Mostra indicatori per prime volte
        showFirstTimeIndicators();
        
        // Avvia tour guidato dopo 2 secondi
        setTimeout(() => {
            startGuidedTour();
        }, 2000);
    }
    
    // Migliora navigazione da tastiera
    document.querySelectorAll('.hover-card').forEach(card => {
        card.addEventListener('focus', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('blur', function() {
            this.style.transform = '';
            this.style.boxShadow = '';
        });
    });
});

// Mostra indicatori per nuovi utenti
function showFirstTimeIndicators() {
    const cards = document.querySelectorAll('.hover-card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('pulse');
            setTimeout(() => card.classList.remove('pulse'), 1000);
        }, index * 200);
    });
}

// Tour guidato per nuovi utenti
function startGuidedTour() {
    // Segna come visitato
    localStorage.setItem('pizzeria_visited', 'true');
    
    // Qui potresti integrare una libreria di tour come Shepherd.js
    // Per ora mostriamo un alert semplice
    const showTour = confirm(
        '👋 Benvenuto nel Backoffice Pizzeria!\n\n' +
        'Vuoi un tour rapido delle funzionalità principali?\n\n' +
        '• Gestione completa menu\n' +
        '• Sistema allergeni automatico\n' +
        '• Ingredienti e categorie\n' +
        '• Statistiche in tempo reale'
    );
    
    if (showTour) {
        highlightFeatures();
    }
}

// Evidenzia caratteristiche principali
function highlightFeatures() {
    const features = [
        { selector: '.hover-card:nth-child(1)', message: '📊 Statistiche del tuo menu' },
        { selector: '.hover-card:nth-child(2)', message: '🍕 Gestisci le tue pizze' },
        { selector: '.hover-card:nth-child(3)', message: '🥗 Gestisci ingredienti e allergeni' }
    ];
    
    let currentIndex = 0;
    
    function showNextFeature() {
        if (currentIndex >= features.length) return;
        
        const feature = features[currentIndex];
        const element = document.querySelector(feature.selector);
        
        if (element) {
            element.scrollIntoView({ behavior: 'smooth', block: 'center' });
            element.style.outline = '3px solid #ff6b35';
            element.style.outlineOffset = '5px';
            
            // Mostra tooltip personalizzato
            const tooltip = document.createElement('div');
            tooltip.className = 'position-absolute bg-primary text-white p-3 rounded shadow-lg';
            tooltip.style.top = '-60px';
            tooltip.style.left = '50%';
            tooltip.style.transform = 'translateX(-50%)';
            tooltip.style.zIndex = '9999';
            tooltip.innerHTML = feature.message;
            
            element.style.position = 'relative';
            element.appendChild(tooltip);
            
            setTimeout(() => {
                element.style.outline = '';
                element.style.outlineOffset = '';
                if (tooltip.parentNode) {
                    tooltip.remove();
                }
                currentIndex++;
                showNextFeature();
            }, 2500);
        }
    }
    
    showNextFeature();
}
