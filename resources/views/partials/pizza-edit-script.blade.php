<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ========================================
        // 1. INIZIALIZZAZIONE ELEMENTI DOM
        // ========================================
        const ingredientsElement = document.getElementById('ingredients');
        const categorySelect = document.getElementById('category_id');
        
        // ========================================
        // 2. PREVENZIONE DUPLICATI CHOICES.JS
        // ========================================
        // Salva gli ingredienti già selezionati dal database
        const preSelectedIngredients = Array.from(ingredientsElement.selectedOptions).map(opt => opt.value);
        
        // Pulisce il DOM rimuovendo gli attributi 'selected'
        // Questo è necessario perché Choices.js legge lo stato del DOM all'inizializzazione
        // e duplicherebbe gli elementi se non puliamo prima
        Array.from(ingredientsElement.options).forEach(opt => opt.removeAttribute('selected'));
        
        // ========================================
        // 3. CONFIGURAZIONE CHOICES.JS
        // ========================================
        const ingredientsSelect = new Choices('#ingredients', {
            removeItemButton: true,              // Mostra bottone X per rimuovere
            searchEnabled: true,                 // Abilita ricerca nel dropdown
            searchPlaceholderValue: 'Cerca ingredienti...',
            noResultsText: 'Nessun risultato trovato',
            itemSelectText: 'Clicca per selezionare',
            placeholderValue: 'Seleziona ingredienti',
            duplicateItemsAllowed: false,        // Previene selezioni duplicate
            shouldSort: false,                   // Mantiene ordine originale delle option
            removeItems: true,
            position: 'top'                      // Dropdown si apre verso l'alto
        });
        
        // Ripristina le selezioni dopo che Choices.js è pronto
        if (preSelectedIngredients.length > 0) {
            setTimeout(() => {
                ingredientsSelect.setChoiceByValue(preSelectedIngredients);
            }, 100);
        }

        // ========================================
        // 4. GESTIONE PIZZA BIANCA
        // ========================================
        // Le pizze bianche non possono avere ingredienti con pomodoro
        let currentCategoryIsWhite = false;

        function checkCategory() {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            currentCategoryIsWhite = selectedOption && selectedOption.dataset.isWhite === '1';
            updateTomatoIngredients();
        }

        function updateTomatoIngredients() {
            const allChoices = ingredientsSelect._currentState.choices;
            
            allChoices.forEach(choice => {
                const option = document.querySelector(`#ingredients option[value="${choice.value}"]`);
                
                // Se l'ingrediente contiene pomodoro (data-is-tomato="1")
                if (option && option.dataset.isTomato === '1') {
                    if (currentCategoryIsWhite) {
                        // Rimuove l'ingrediente se selezionato e disabilita la scelta
                        ingredientsSelect.removeActiveItemsByValue(choice.value);
                        choice.disabled = true;
                    } else {
                        choice.disabled = false;
                    }
                }
            });
            
            // Aggiorna il dropdown con le nuove scelte
            ingredientsSelect.setChoices(allChoices, 'value', 'label', true);
        }

        categorySelect.addEventListener('change', checkCategory);
        checkCategory();

        // ========================================
        // 5. SISTEMA RILEVAMENTO ALLERGENI
        // ========================================
        // Salva gli allergeni manuali già selezionati nel database
        // Questi devono essere mantenuti anche quando cambiano gli ingredienti
        const initialManualAllergens = Array.from(
            document.querySelectorAll('.allergen-checkbox:checked')
        ).map(cb => parseInt(cb.value));
        
        /**
         * Aggiorna la lista degli allergeni basandosi sugli ingredienti selezionati
         * Combina allergeni automatici (da ingredienti) + allergeni manuali (da DB)
         */
        function updateAllergens() {
            const selectedIngredients = ingredientsSelect.getValue(true);
            
            // Se non ci sono ingredienti, mostra solo gli allergeni manuali
            if (selectedIngredients.length === 0) {
                document.querySelectorAll('.allergen-checkbox').forEach(cb => {
                    cb.checked = initialManualAllergens.includes(parseInt(cb.value));
                });
                const preview = document.getElementById('final-allergen-preview');
                if (preview) preview.style.display = 'none';
                return;
            }

            // Costruisce URL per chiamata AJAX
            const url = '{{ route("admin.ajax.ingredients-allergens") }}?' + new URLSearchParams({
                ingredient_ids: selectedIngredients
            });

            // Chiamata AJAX per ottenere allergeni degli ingredienti selezionati
            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                const automaticAllergens = data.allergens || [];
                const automaticIds = automaticAllergens.map(a => parseInt(a.id));
                
                // Combina allergeni automatici + manuali (rimuove duplicati con Set)
                const allIds = [...new Set([...automaticIds, ...initialManualAllergens])];
                
                // Aggiorna stato delle checkbox
                document.querySelectorAll('.allergen-checkbox').forEach(cb => {
                    const id = parseInt(cb.value);
                    cb.checked = allIds.includes(id);
                });

                // Aggiorna preview visuale degli allergeni automatici
                const preview = document.getElementById('final-allergen-preview');
                const listContainer = document.getElementById('final-allergen-list');
                
                if (preview && listContainer && automaticAllergens.length > 0) {
                    listContainer.innerHTML = automaticAllergens
                        .map(a => `<span class="badge bg-warning text-dark me-1">${a.name}</span>`)
                        .join('');
                    preview.style.display = 'block';
                } else if (preview) {
                    preview.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Errore nel caricamento degli allergeni:', error);
                const preview = document.getElementById('final-allergen-preview');
                if (preview) preview.style.display = 'none';
            });
        }

        // ========================================
        // 6. EVENT LISTENERS
        // ========================================
        
        // Trigger aggiornamento allergeni quando cambiano gli ingredienti
        ingredientsElement.addEventListener('change', updateAllergens);
        
        // Gestione sezioni collapsabili Bootstrap
        const ingredientsCard = document.querySelector('#ingredients')?.closest('.card');
        if (ingredientsCard) {
            const collapseElement = ingredientsCard.closest('.collapse');
            if (collapseElement) {
                // Aggiorna allergeni quando la sezione si espande
                collapseElement.addEventListener('shown.bs.collapse', updateAllergens);
                
                // Chiude il dropdown quando la sezione si chiude
                collapseElement.addEventListener('hide.bs.collapse', function() {
                    ingredientsSelect.hideDropdown();
                });
            }
        }
        
        // Chiude dropdown durante lo scroll per evitare sovrapposizioni
        window.addEventListener('scroll', function() {
            if (ingredientsSelect.dropdown.isActive) {
                ingredientsSelect.hideDropdown();
            }
        }, { passive: true });
        
        // Chiude dropdown quando si clicca fuori dal componente
        document.addEventListener('click', function(e) {
            const choicesContainer = document.querySelector('.choices');
            if (choicesContainer && !choicesContainer.contains(e.target)) {
                ingredientsSelect.hideDropdown();
            }
        });
        
        // Caricamento iniziale degli allergeni (con delay per attendere il render completo)
        setTimeout(updateAllergens, 500);

        // ========================================
        // 7. CREAZIONE NUOVO INGREDIENTE (MODALE)
        // ========================================
        const newIngredientForm = document.getElementById('newIngredientForm');
        if (newIngredientForm) {
            newIngredientForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                // Invia richiesta POST per creare nuovo ingrediente
                fetch('{{ route("admin.ingredients.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Aggiunge il nuovo ingrediente al dropdown e lo seleziona
                        ingredientsSelect.setChoices([{
                            value: data.ingredient.id,
                            label: data.ingredient.name,
                            selected: true
                        }], 'value', 'label', false);

                        // Chiude modale e resetta form
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addIngredientModal'));
                        modal.hide();
                        newIngredientForm.reset();

                        // Aggiorna allergeni con il nuovo ingrediente
                        updateAllergens();
                    } else {
                        alert('Errore nella creazione dell\'ingrediente');
                    }
                })
                .catch(error => {
                    console.error('Errore nella creazione ingrediente:', error);
                    alert('Errore nella richiesta');
                });
            });
        }
    });
</script>
