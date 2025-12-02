{{-- 
    Script per gestione intelligente allergeni nella creazione pizza
    Gestisce: rilevamento automatico allergeni, validazione pizza bianca, preview finale
--}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // 1. INIZIALIZZAZIONE CHOICES.JS
    // ========================================
    
    // Multi-select per ingredienti
    const ingredientsChoices = new Choices('#ingredients', {
        removeItemButton: true,
        searchEnabled: true,
        searchPlaceholderValue: 'Cerca ingredienti...',
        noResultsText: 'Nessun risultato',
        itemSelectText: 'Clicca per selezionare',
        placeholderValue: 'Seleziona ingredienti'
    });
    
    // Select singola per categoria
    const categoryChoices = new Choices('#category_id', {
        searchEnabled: false,
        itemSelectText: 'Clicca per selezionare',
        placeholderValue: 'Seleziona categoria'
    });
    
    // ========================================
    // 2. RIFERIMENTI ELEMENTI DOM
    // ========================================
    const ingredientsElement = document.getElementById('ingredients');
    const categorySelect = document.getElementById('category_id');
    const automaticAllergensDiv = document.getElementById('automatic-allergens');
    const manualAllergensContainer = document.getElementById('manual-allergens-container');
    const finalAllergensPreview = document.getElementById('final-allergens-preview');
    const whiteHelp = document.getElementById('whiteHelp');
    
    // Array per memorizzare allergeni rilevati automaticamente
    let automaticAllergens = [];
    
    // ========================================
    // 3. GESTIONE PIZZA BIANCA
    // ========================================
    // Le pizze bianche non possono contenere ingredienti a base di pomodoro
    categorySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const isWhite = selectedOption?.dataset?.isWhite === '1';
        
        if (isWhite) {
            // Mostra messaggio di avviso
            whiteHelp.classList.remove('d-none');
            
            // Disabilita e rimuove ingredienti con pomodoro
            const choices = ingredientsChoices._currentState.choices;
            choices.forEach(choice => {
                const originalOption = document.querySelector(`#ingredients option[value="${choice.value}"]`);
                if (originalOption && originalOption.dataset.isTomato === '1') {
                    choice.disabled = true;
                    // Rimuove l'ingrediente se era già selezionato
                    ingredientsChoices.removeActiveItemsByValue(choice.value);
                }
            });
            ingredientsChoices.setChoices(choices, 'value', 'label', true);
        } else {
            // Nascondi messaggio
            whiteHelp.classList.add('d-none');
            
            // Riabilita tutti gli ingredienti con pomodoro
            const choices = ingredientsChoices._currentState.choices;
            choices.forEach(choice => {
                const originalOption = document.querySelector(`#ingredients option[value="${choice.value}"]`);
                if (originalOption && originalOption.dataset.isTomato === '1') {
                    choice.disabled = false;
                }
            });
            ingredientsChoices.setChoices(choices, 'value', 'label', true);
        }
        
        // Aggiorna allergeni dopo cambio categoria
        updateAutomaticAllergens();
    });
    
    // ========================================
    // 4. RILEVAMENTO AUTOMATICO ALLERGENI
    // ========================================
    /**
     * Effettua chiamata AJAX per ottenere allergeni dagli ingredienti selezionati
     * Aggiorna la preview degli allergeni automatici
     */
    function updateAutomaticAllergens() {
        const selectedIngredients = ingredientsChoices.getValue(true);
        
        // Caso: nessun ingrediente selezionato
        if (selectedIngredients.length === 0) {
            automaticAllergens = [];
            automaticAllergensDiv.innerHTML = '<em class="text-muted small">Seleziona ingredienti per vedere gli allergeni</em>';
            updateFinalPreview();
            return;
        }
        
        // Mostra spinner durante il caricamento
        automaticAllergensDiv.innerHTML = '<div class="d-flex align-items-center text-muted"><div class="spinner-border spinner-border-sm me-2"></div>Caricamento...</div>';
        
        // Chiamata AJAX al backend
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
            
            // Mostra risultato
            if (automaticAllergens.length === 0) {
                automaticAllergensDiv.innerHTML = '<div class="text-success small"><i class="fas fa-check-circle me-1"></i>Nessun allergene</div>';
            } else {
                automaticAllergensDiv.innerHTML = automaticAllergens.map(allergen => 
                    `<span class="badge bg-warning text-dark me-1 mb-1">${allergen.name}</span>`
                ).join('');
            }
            
            // Aggiorna preview finale
            updateFinalPreview();
        })
        .catch(error => {
            console.error('Errore nel caricamento allergeni:', error);
            automaticAllergensDiv.innerHTML = '<div class="text-danger small"><i class="fas fa-times me-1"></i>Errore nel caricamento</div>';
        });
    }
    
    // ========================================
    // 5. PREVIEW FINALE ALLERGENI
    // ========================================
    /**
     * Combina allergeni automatici (da ingredienti) + allergeni manuali (checkbox)
     * Rimuove duplicati e aggiorna la preview finale
     */
    function updateFinalPreview() {
        // Legge checkbox manuali selezionate
        const manualCheckboxes = manualAllergensContainer.querySelectorAll('input[type="checkbox"]:checked');
        const manualAllergens = Array.from(manualCheckboxes).map(cb => ({
            id: cb.value,
            name: cb.nextElementSibling.textContent.trim()
        }));
        
        // Combina gli array rimuovendo duplicati
        const allAllergens = [...automaticAllergens];
        manualAllergens.forEach(manual => {
            if (!allAllergens.find(auto => auto.id == manual.id)) {
                allAllergens.push(manual);
            }
        });
        
        // Renderizza preview
        if (allAllergens.length === 0) {
            finalAllergensPreview.innerHTML = '<em class="text-muted">Nessun allergene</em>';
        } else {
            finalAllergensPreview.innerHTML = allAllergens.map(allergen => 
                `<span class="badge bg-danger me-1">${allergen.name}</span>`
            ).join('');
        }
    }
    
    // ========================================
    // 6. EVENT LISTENERS
    // ========================================
    
    // Trigger aggiornamento allergeni quando cambiano gli ingredienti
    ingredientsElement.addEventListener('change', updateAutomaticAllergens);
    
    // Trigger preview finale quando cambiano le checkbox manuali
    manualAllergensContainer.addEventListener('change', function(e) {
        if (e.target.type === 'checkbox') {
            updateFinalPreview();
        }
    });
    
    // ========================================
    // 7. INIZIALIZZAZIONE
    // ========================================
    updateAutomaticAllergens();
});
</script>
