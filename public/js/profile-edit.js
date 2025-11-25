document.addEventListener('DOMContentLoaded', function() {
    var overlay = document.getElementById('profile-success-overlay');
    
    if (!overlay) return;
    
    // Blocca lo scroll del body
    document.body.style.overflow = 'hidden';
    
    var autoCloseTimer;
    
    function closeOverlay() {
        if (overlay) {
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        }
        if (autoCloseTimer) {
            clearTimeout(autoCloseTimer);
        }
    }
    
    // Auto-chiudi dopo 5 secondi
    autoCloseTimer = setTimeout(closeOverlay, 5000);
    
    // Chiudi cliccando sullo sfondo
    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) {
            closeOverlay();
        }
    });
});
