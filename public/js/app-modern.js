// Inizializza Lucide Icons
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
});

// Reinizializza icone dopo toggle Alpine
document.addEventListener('alpine:initialized', () => {
    setTimeout(() => lucide.createIcons(), 100);
});
