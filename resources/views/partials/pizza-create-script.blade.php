{{-- Script per sistema allergeni intelligente --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inizializza Choices.js
    const ingredientsChoices = new Choices('#ingredients', {
        removeItemButton: true,
        searchEnabled: true,
        searchPlaceholderValue: 'Cerca ingredienti...',
        noResultsText: 'Nessun risultato',
        itemSelectText: 'Clicca per selezionare',
        placeholderValue: 'Seleziona ingredienti'
    });
    
    const categoryChoices = new Choices('#category_id', {
        searchEnabled: false,
        itemSelectText: 'Clicca per selezionare',
        placeholderValue: 'Seleziona categoria'
    });
    
    const ingredientsElement = document.getElementById('ingredients');
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
            
            // Disabilita ingredienti pomodoro in Choices.js
            const choices = ingredientsChoices._currentState.choices;
            choices.forEach(choice => {
                const originalOption = document.querySelector(`#ingredients option[value="${choice.value}"]`);
                if (originalOption && originalOption.dataset.isTomato === '1') {
                    choice.disabled = true;
                    ingredientsChoices.removeActiveItemsByValue(choice.value);
                }
            });
            ingredientsChoices.setChoices(choices, 'value', 'label', true);
        } else {
            whiteHelp.classList.add('d-none');
            
            // Riabilita ingredienti pomodoro
            const choices = ingredientsChoices._currentState.choices;
            choices.forEach(choice => {
                const originalOption = document.querySelector(`#ingredients option[value="${choice.value}"]`);
                if (originalOption && originalOption.dataset.isTomato === '1') {
                    choice.disabled = false;
                }
            });
            ingredientsChoices.setChoices(choices, 'value', 'label', true);
        }
        
        updateAutomaticAllergens();
    });
    
    function updateAutomaticAllergens() {
        const selectedIngredients = ingredientsChoices.getValue(true);
        
        if (selectedIngredients.length === 0) {
            automaticAllergens = [];
            automaticAllergensDiv.innerHTML = '<em class="text-muted small">Seleziona ingredienti per vedere gli allergeni</em>';
            updateFinalPreview();
            return;
        }
        
        // Loading state
        automaticAllergensDiv.innerHTML = '<div class="d-flex align-items-center text-muted"><div class="spinner-border spinner-border-sm me-2"></div>Caricamento...</div>';
        
        // Chiamata AJAX
        fetch('{{ route("admin.ajax.ingredients-allergens") }}?' + new URLSearchParams({
            ingredient_ids: selectedIngredients
        }), {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            automaticAllergens = data.allergens || [];
            
            if (automaticAllergens.length === 0) {
                automaticAllergensDiv.innerHTML = '<div class="text-success small"><i class="fas fa-check-circle me-1"></i>Nessun allergene</div>';
            } else {
                automaticAllergensDiv.innerHTML = automaticAllergens.map(allergen => 
                    `<span class="badge bg-warning text-dark me-1 mb-1">${allergen.name}</span>`
                ).join('');
            }
            
            updateFinalPreview();
        })
        .catch(error => {
            console.error('Errore:', error);
            automaticAllergensDiv.innerHTML = '<div class="text-danger small"><i class="fas fa-times me-1"></i>Errore</div>';
        });
    }
    
    function updateFinalPreview() {
        const manualCheckboxes = manualAllergensContainer.querySelectorAll('input[type="checkbox"]:checked');
        const manualAllergens = Array.from(manualCheckboxes).map(cb => ({
            id: cb.value,
            name: cb.nextElementSibling.textContent.trim()
        }));
        
        // Merge, rimuovi duplicati
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
                `<span class="badge bg-danger me-1">${allergen.name}</span>`
            ).join('');
        }
    }
    
    // Event listeners
    ingredientsElement.addEventListener('change', updateAutomaticAllergens);
    
    manualAllergensContainer.addEventListener('change', function(e) {
        if (e.target.type === 'checkbox') {
            updateFinalPreview();
        }
    });
    
    // Inizializzazione
    updateAutomaticAllergens();
});
</script>
