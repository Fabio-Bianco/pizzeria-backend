<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inizializza Choices.js per il select degli ingredienti
        const ingredientsSelect = new Choices('#ingredients', {
            removeItemButton: true,
            searchEnabled: true,
            searchPlaceholderValue: 'Cerca ingredienti...',
            noResultsText: 'Nessun risultato trovato',
            itemSelectText: 'Clicca per selezionare',
            placeholderValue: 'Seleziona ingredienti',
        });

        const categorySelect = document.getElementById('category_id');
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

        // Rilevamento automatico allergeni
        function updateAllergens() {
            const selectedIngredients = ingredientsSelect.getValue(true);
            
            if (selectedIngredients.length === 0) {
                document.querySelectorAll('.allergen-checkbox').forEach(cb => cb.checked = false);
                document.getElementById('final-allergen-preview').style.display = 'none';
                return;
            }

            fetch('{{ route("admin.ajax.ingredients-allergens") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ingredient_ids: selectedIngredients})
            })
            .then(response => response.json())
            .then(data => {
                document.querySelectorAll('.allergen-checkbox').forEach(cb => {
                    cb.checked = data.allergens.includes(parseInt(cb.value));
                });

                const preview = document.getElementById('final-allergen-preview');
                const listContainer = document.getElementById('final-allergen-list');
                
                if (data.allergen_names.length > 0) {
                    listContainer.innerHTML = data.allergen_names
                        .map(name => `<span class="badge bg-warning text-dark me-1">${name}</span>`)
                        .join('');
                    preview.style.display = 'block';
                } else {
                    preview.style.display = 'none';
                }
            })
            .catch(error => console.error('Errore rilevamento allergeni:', error));
        }

        document.getElementById('ingredients').addEventListener('change', updateAllergens);

        // Gestione modale nuovo ingrediente
        const newIngredientForm = document.getElementById('newIngredientForm');
        if (newIngredientForm) {
            newIngredientForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

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
