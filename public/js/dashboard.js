document.addEventListener('DOMContentLoaded', function() {
    // Reinizializza le icone Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Inizializza i tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Ripristina stato normale di tutte le card (fix per back button)
    document.querySelectorAll('.hover-card').forEach(card => {
        card.style.opacity = '1';
        const btn = card.querySelector('.btn-outline-primary, .btn-outline-success, .btn-outline-info, .btn-outline-warning');
        if (btn) {
            btn.classList.remove('disabled');
            btn.style.minWidth = '';
        }
    });
    
    // Loading state migliorato - solo sul bottone cliccato
    document.querySelectorAll('.hover-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // Previeni click multipli
            if (this.classList.contains('loading')) return;
            
            // Trova il bottone nella card
            const btn = this.querySelector('.btn-outline-primary, .btn-outline-success, .btn-outline-info, .btn-outline-warning');
            
            if (btn && !btn.classList.contains('disabled')) {
                // Segna la card come in loading
                this.classList.add('loading');
                
                // Salva il testo originale del bottone come attributo data
                btn.dataset.originalText = btn.innerHTML;
                
                // Mostra spinner (senza testo)
                btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                btn.classList.add('disabled');
                btn.style.minWidth = btn.offsetWidth + 'px';
                
                // Feedback visivo leggero
                this.style.opacity = '0.8';
                this.style.transition = 'opacity 0.2s';
            }
        });
    });
});

// Ripristina stato quando si torna indietro con il browser
window.addEventListener('pageshow', function(event) {
    document.querySelectorAll('.hover-card').forEach(card => {
        card.classList.remove('loading');
        card.style.opacity = '1';
        const btn = card.querySelector('.btn-outline-primary, .btn-outline-success, .btn-outline-info, .btn-outline-warning');
        if (btn) {
            // Ripristina il testo originale se era stato salvato
            if (btn.dataset.originalText) {
                btn.innerHTML = btn.dataset.originalText;
                delete btn.dataset.originalText;
            }
            btn.classList.remove('disabled');
            btn.style.minWidth = '';
        }
    });
    
    // Reinizializza icone Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
