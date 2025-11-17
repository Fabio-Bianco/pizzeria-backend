// Inizializza Lucide Icons (guest layout)
if (typeof lucide !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
    } else {
        lucide.createIcons();
    }
}
