<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ingredientsElement = document.getElementById('ingredients');
        const categorySelect = document.getElementById('category_id');
        
        // SALVA ingredienti selezionati PRIMA di toccare il DOM
        const preSelectedIngredients = Array.from(ingredientsElement.selectedOptions).map(opt => opt.value);
        
        // RIMUOVI attributo selected da tutte le option (previene duplicati)
        Array.from(ingredientsElement.options).forEach(opt => opt.removeAttribute('selected'));
        
        // Inizializza Choices.js su select PULITO
        const ingredientsSelect = new Choices('#ingredients', {
            removeItemButton: true,
            searchEnabled: true,
            searchPlaceholderValue: 'Cerca ingredienti...',
            noResultsText: 'Nessun risultato trovato',
            itemSelectText: 'Clicca per selezionare',
            placeholderValue: 'Seleziona ingredienti',
            duplicateItemsAllowed: false,
            shouldSort: false,
            removeItems: true,
            position: 'top'  // Apre il dropdown verso l'alto
        });
        
        // ADESSO imposta le selezioni programmaticamente (senza duplicati)
        if (preSelectedIngredients.length > 0) {
            setTimeout(() => {
                ingredientsSelect.setChoiceByValue(preSelectedIngredients);
            }, 100);
        }

        let currentCategoryIsWhite = false;

        // Controlla categoria iniziale
        function checkCategory() {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            currentCategoryIsWhite = selectedOption && selectedOption.dataset.isWhite === '1';
            updateTomatoIngredients();
        }

        // Disabilita ingredienti con pomodoro per pizze bianche
        function updateTomatoIngredients() {
            const allChoices = ingredientsSelect._currentState.choices;
            allChoices.forEach(choice => {
                const option = document.querySelector(`#ingredients option[value="${choice.value}"]`);
                if (option && option.dataset.isTomato === '1') {
                    if (currentCategoryIsWhite) {
                        ingredientsSelect.removeActiveItemsByValue(choice.value);
                        choice.disabled = true;
                    } else {
                        choice.disabled = false;
                    }
                }
            });
            ingredientsSelect.setChoices(allChoices, 'value', 'label', true);
        }

        categorySelect.addEventListener('change', checkCategory);
        checkCategory();

        // Salva manual_allergens iniziali (dal DB)
        const initialManualAllergens = Array.from(document.querySelectorAll('.allergen-checkbox:checked')).map(cb => parseInt(cb.value));
        
        console.log('Manual allergens iniziali:', initialManualAllergens);
        
        // Rilevamento automatico allergeni
        function updateAllergens() {
            const selectedIngredients = ingredientsSelect.getValue(true);
            
            console.log('Ingredienti selezionati:', selectedIngredients);
            
            if (selectedIngredients.length === 0) {
                console.log('Nessun ingrediente, mostro solo manual');
                document.querySelectorAll('.allergen-checkbox').forEach(cb => {
                    cb.checked = initialManualAllergens.includes(parseInt(cb.value));
                });
                const preview = document.getElementById('final-allergen-preview');
                if (preview) preview.style.display = 'none';
                return;
            }

            // AJAX
            const url = '<?php echo e(route("admin.ajax.ingredients-allergens")); ?>?' + new URLSearchParams({
                ingredient_ids: selectedIngredients
            });
            
            console.log('Chiamata AJAX a:', url);

            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            })
            .then(response => {
                console.log('Risposta ricevuta:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Dati allergeni:', data);
                
                const automaticAllergens = data.allergens || [];
                const automaticIds = automaticAllergens.map(a => parseInt(a.id));
                
                console.log('IDs allergeni automatici:', automaticIds);
                console.log('IDs allergeni manuali:', initialManualAllergens);
                
                // Combina automatici + manuali
                const allIds = [...new Set([...automaticIds, ...initialManualAllergens])];
                
                console.log('Tutti gli IDs da checkare:', allIds);
                
                // Aggiorna checkbox
                document.querySelectorAll('.allergen-checkbox').forEach(cb => {
                    const id = parseInt(cb.value);
                    const shouldCheck = allIds.includes(id);
                    cb.checked = shouldCheck;
                    console.log(`Checkbox ${id}: ${shouldCheck ? 'checked' : 'unchecked'}`);
                });

                // Aggiorna preview
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
                console.error('ERRORE AJAX:', error);
                const preview = document.getElementById('final-allergen-preview');
                if (preview) preview.style.display = 'none';
            });
        }

        // Evento change ingredienti
        ingredientsElement.addEventListener('change', function() {
            console.log('Ingredienti cambiati!');
            updateAllergens();
        });
        
        // Fix per menu collassabili: ri-trigghera quando la sezione ingredienti si espande
        const ingredientsCard = document.querySelector('#ingredients')?.closest('.card');
        if (ingredientsCard) {
            const collapseElement = ingredientsCard.closest('.collapse');
            if (collapseElement) {
                collapseElement.addEventListener('shown.bs.collapse', function() {
                    console.log('Sezione ingredienti espansa, re-init...');
                    updateAllergens();
                });
                
                // Chiudi dropdown quando la sezione si chiude
                collapseElement.addEventListener('hide.bs.collapse', function() {
                    ingredientsSelect.hideDropdown();
                });
            }
        }
        
        // Fix: chiudi dropdown quando scrolli (previene overlap)
        let scrollTimer;
        window.addEventListener('scroll', function() {
            if (ingredientsSelect.dropdown.isActive) {
                ingredientsSelect.hideDropdown();
            }
        }, { passive: true });
        
        // Fix: chiudi dropdown quando clicchi fuori dalla sezione ingredienti
        document.addEventListener('click', function(e) {
            const choicesContainer = document.querySelector('.choices');
            if (choicesContainer && !choicesContainer.contains(e.target)) {
                ingredientsSelect.hideDropdown();
            }
        });
        
        // Carica all'avvio
        setTimeout(function() {
            console.log('Caricamento iniziale allergeni...');
            updateAllergens();
        }, 500);

        // Gestione modale nuovo ingrediente
        const newIngredientForm = document.getElementById('newIngredientForm');
        if (newIngredientForm) {
            newIngredientForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch('<?php echo e(route("admin.ingredients.store")); ?>', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        ingredientsSelect.setChoices([{
                            value: data.ingredient.id,
                            label: data.ingredient.name,
                            selected: true
                        }], 'value', 'label', false);

                        const modal = bootstrap.Modal.getInstance(document.getElementById('addIngredientModal'));
                        modal.hide();
                        newIngredientForm.reset();

                        updateAllergens();
                    } else {
                        alert('Errore nella creazione dell\'ingrediente');
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                    alert('Errore nella richiesta');
                });
            });
        }
    });
</script>
<?php /**PATH C:\Users\Utente\Desktop\my_project\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/partials/pizza-edit-script.blade.php ENDPATH**/ ?>