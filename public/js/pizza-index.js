(function () {
    if (window.bootstrap) {
        const triggers = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        triggers.forEach(el => new bootstrap.Tooltip(el));
    }
})();
