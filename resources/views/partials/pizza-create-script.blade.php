{{-- Script per sistema allergeni intelligente --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ingredientsSelect = document.getElementById('ingredients');
    const categorySelect = document.getElementById('category_id');
    const automaticAllergensDiv = document.getElementById('automatic-allergens');
    const manualAllergensContainer = document.getElementById('manual-allergens-container');
    const finalAllergensPreview = document.getElementById('final-allergens-preview');
    const whiteHelp = document.getElementById('whiteHelp');
    
    let automaticAllergens = [];
    
    // Gestione categoria bianca
    categorySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const isWhite = selectedOption?.dataset?.isWhite === '1';
        
        if (isWhite) {
            whiteHelp.classList.remove('d-none');
            
            // Disabilita opzioni pomodoro
            Array.from(ingredientsSelect.options).forEach(option => {
                if (option.dataset.isTomato === '1') {
                    option.disabled = true;
                    option.selected = false;
                }
            });
        } else {
            whiteHelp.classList.add('d-none');
            
            // Riabilita opzioni pomodoro
            Array.from(ingredientsSelect.options).forEach(option => {
                if (option.dataset.isTomato === '1') {
                    option.disabled = false;
                }
            });
        }
        
        updateAutomaticAllergens();
    });
    
    function updateAutomaticAllergens() {
        const selectedIngredients = Array.from(ingredientsSelect.selectedOptions).map(option => option.value);
        
        if (selectedIngredients.length === 0) {
            automaticAllergens = [];
            automaticAllergensDiv.innerHTML = '<em class="text-muted"><i class="fas fa-arrow-up me-1"></i>Seleziona ingredienti sopra per vedere gli allergeni automatici</em>';
            updateFinalPreview();
            return;
        }
        
        // Loading state
        automaticAllergensDiv.innerHTML = '<div class="d-flex align-items-center text-muted"><div class="spinner-border spinner-border-sm me-2"></div>Caricamento allergeni...</div>';
        
        // Chiamata AJAX per ottenere allergeni
        fetch('{{ route("admin.ajax.ingredients-allergens") }}?' + new URLSearchParams({
            ingredient_ids: selectedIngredients
        }), {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            automaticAllergens = data.allergens || [];
            
            if (automaticAllergens.length === 0) {
                automaticAllergensDiv.innerHTML = '<div class="text-success"><i class="fas fa-check-circle me-1"></i>Nessun allergene automatico</div>';
            } else {
                automaticAllergensDiv.innerHTML = automaticAllergens.map(allergen => 
                    `<span class="badge bg-warning text-dark me-1 mb-1">${allergen.name}</span>`
                ).join('');
            }
            
            updateFinalPreview();
        })
        .catch(error => {
            console.error('Errore nel caricamento allergeni:', error);
            automaticAllergensDiv.innerHTML = '<div class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>Errore nel caricamento</div>';
        });
    }
    
    function updateFinalPreview() {
        const manualCheckboxes = manualAllergensContainer.querySelectorAll('input[type="checkbox"]:checked');
        const manualAllergens = Array.from(manualCheckboxes).map(cb => ({
            id: cb.value,
            name: cb.nextElementSibling.textContent.trim()
        }));
        
        // Merge automatic + manual, rimuovi duplicati
        const allAllergens = [...automaticAllergens];
        manualAllergens.forEach(manual => {
            if (!allAllergens.find(auto => auto.id == manual.id)) {
                allAllergens.push(manual);
            }
        });
        
        if (allAllergens.length === 0) {
            finalAllergensPreview.innerHTML = '<em class="text-muted">Nessun allergene</em>';
        } else {
            finalAllergensPreview.innerHTML = allAllergens.map(allergen => 
                `<span class="badge bg-danger text-white me-1 mb-1">${allergen.name}</span>`
            ).join('');
        }
    }
    
    // Event listeners
    ingredientsSelect.addEventListener('change', updateAutomaticAllergens);
    
    manualAllergensContainer.addEventListener('change', function(e) {
        if (e.target.type === 'checkbox') {
            updateFinalPreview();
        }
    });
    
    // Inizializzazione
    updateAutomaticAllergens();
});
</script>
