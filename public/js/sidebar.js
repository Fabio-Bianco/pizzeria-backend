// Inizializza Lucide Icons nella sidebar
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
});

// Reinizializza dopo operazioni dinamiche
document.addEventListener('shown.bs.collapse', () => {
    setTimeout(() => lucide.createIcons(), 50);
});
