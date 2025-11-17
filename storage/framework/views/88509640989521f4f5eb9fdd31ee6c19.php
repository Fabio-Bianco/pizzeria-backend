<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inizializza Choices.js
        const ingredientsSelect = new Choices('#ingredients', {
            removeItemButton: true,
            searchEnabled: true,
            searchPlaceholderValue: 'Cerca ingredienti...',
            noResultsText: 'Nessun risultato trovato',
            itemSelectText: 'Clicca per selezionare',
            placeholderValue: 'Seleziona ingredienti',
        });

        // Rilevamento automatico allergeni
        function updateAllergens() {
            const selectedIngredients = ingredientsSelect.getValue(true);
            
            if (selectedIngredients.length === 0) {
                document.querySelectorAll('.allergen-checkbox').forEach(cb => cb.checked = false);
                document.getElementById('final-allergen-preview').style.display = 'none';
                return;
            }

            fetch('<?php echo e(route('admin.ajax.ingredients-allergens')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ ingredients: selectedIngredients })
            })
            .then(response => response.json())
            .then(data => {
                document.querySelectorAll('.allergen-checkbox').forEach(checkbox => {
                    if (data.allergens.includes(parseInt(checkbox.value))) {
                        checkbox.checked = true;
                    }
                });
                updateFinalAllergenPreview();
            })
            .catch(error => console.error('Errore:', error));
        }

        // Aggiorna preview allergeni finali
        function updateFinalAllergenPreview() {
            const checkedAllergens = Array.from(document.querySelectorAll('.allergen-checkbox:checked'));
            const previewDiv = document.getElementById('final-allergen-preview');
            const listDiv = document.getElementById('final-allergen-list');

            if (checkedAllergens.length === 0) {
                previewDiv.style.display = 'none';
                return;
            }

            listDiv.innerHTML = checkedAllergens.map(cb => {
                const label = document.querySelector(`label[for="${cb.id}"]`).textContent.trim();
                return `<span class="badge bg-danger">${label}</span>`;
            }).join('');

            previewDiv.style.display = 'block';
        }

        document.getElementById('ingredients').addEventListener('change', updateAllergens);
        document.querySelectorAll('.allergen-checkbox').forEach(cb => {
            cb.addEventListener('change', updateFinalAllergenPreview);
        });

        // Inizializza stato
        updateAllergens();

        // Gestione creazione nuovo ingrediente
        document.getElementById('saveNewIngredient').addEventListener('click', function() {
            const name = document.getElementById('new_ingredient_name').value.trim();
            const allergenSelect = document.getElementById('new_ingredient_allergens');
            const selectedAllergens = Array.from(allergenSelect.selectedOptions).map(opt => opt.value);

            if (!name) {
                alert('Inserisci il nome dell\'ingrediente');
                return;
            }

            fetch('<?php echo e(route('admin.ingredients.store')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    name: name,
                    allergens: selectedAllergens
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    ingredientsSelect.setChoices([{
                        value: data.ingredient.id,
                        label: data.ingredient.name,
                        selected: true
                    }], 'value', 'label', false);

                    const modal = bootstrap.Modal.getInstance(document.getElementById('newIngredientModal'));
                    modal.hide();

                    document.getElementById('new_ingredient_name').value = '';
                    allergenSelect.selectedIndex = -1;

                    updateAllergens();
                } else {
                    alert('Errore durante la creazione dell\'ingrediente');
                }
            })
            .catch(error => {
                console.error('Errore:', error);
                alert('Errore durante la creazione dell\'ingrediente');
            });
        });
    });
</script>
<?php /**PATH C:\Users\Utente\Desktop\Backoffice-vetrrina-pizzeria-laravel\pizzeria-backend\resources\views/partials/appetizer-edit-script.blade.php ENDPATH**/ ?>