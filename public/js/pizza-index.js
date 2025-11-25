(function () {
    // Inizializza tooltip Bootstrap
    if (window.bootstrap) {
        const triggers = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        triggers.forEach(el => new bootstrap.Tooltip(el));
    }
    
    // Reinizializza le icone Lucide quando la pagina viene caricata
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
})();
