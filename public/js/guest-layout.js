document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
});
document.addEventListener('alpine:initialized', () => {
    setTimeout(() => lucide.createIcons(), 100);
});
