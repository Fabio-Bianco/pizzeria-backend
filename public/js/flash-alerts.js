document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after specified time
    const alerts = document.querySelectorAll('[data-auto-dismiss]');
    alerts.forEach(alert => {
        const dismissTime = parseInt(alert.getAttribute('data-auto-dismiss'));
        if (dismissTime > 0) {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, dismissTime);
        }
    });
});
