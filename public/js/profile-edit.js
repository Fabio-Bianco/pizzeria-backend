document.addEventListener('DOMContentLoaded', function() {
    var overlay = document.getElementById('profile-success-overlay');
    var showOverlay = false;
    // Mostra overlay se hash oppure session status (inserito come attributo data-status)
    if (window.location.hash === '#success-profile' || window.location.hash === '#success-password') {
        showOverlay = true;
    }
    if (overlay && overlay.dataset.status === 'profile-updated') {
        showOverlay = true;
    }
    if (overlay && overlay.dataset.status === 'password-updated') {
        showOverlay = true;
    }
    if (showOverlay && overlay) {
        overlay.classList.remove('d-none');
    }
    document.querySelectorAll('.close-profile-success').forEach(function(btn) {
        btn.addEventListener('click', function() {
            overlay.classList.add('d-none');
            window.location.hash = '';
        });
    });
});
