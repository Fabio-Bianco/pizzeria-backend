// Preview immagine avatar quando selezionata
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Trova l'immagine o il placeholder
                    const container = avatarInput.closest('.mb-4').querySelector('.mb-3');
                    const existingImg = container.querySelector('img');
                    const placeholder = container.querySelector('.rounded-circle.bg-secondary');
                    
                    if (existingImg) {
                        // Aggiorna immagine esistente
                        existingImg.src = e.target.result;
                    } else if (placeholder) {
                        // Sostituisci placeholder con immagine
                        placeholder.outerHTML = `<img src="${e.target.result}" alt="Avatar" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #e5e7eb;">`;
                    }
                };
                
                reader.readAsDataURL(file);
            }
        });
    }
});
