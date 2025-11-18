# 🤖 Sistema Automatico di Rilevamento Allergeni

## 🎯 Problema Risolto

**Scenario**: Il proprietario della pizzeria dimentica di associare allergeni quando crea nuovi ingredienti.

**Soluzione**: Sistema automatico multi-livello che rileva e assegna allergeni in 3 modi diversi.

---

## 🔧 Come Funziona

### 1️⃣ **Auto-rilevamento in Tempo Reale (Automatico)**

Quando il proprietario crea un nuovo ingrediente, il sistema **rileva automaticamente** gli allergeni:

```php
// Esempio: creo "Grana Padano"
$ingredient = Ingredient::create(['name' => 'Grana Padano']);

// ✅ L'Observer rileva automaticamente "Lattosio" e lo associa!
```

**Come**: Usa `IngredientObserver` che si attiva su ogni `create` e `update`.

---

### 2️⃣ **Database Locale di Ingredienti (Offline)**

Il sistema ha un **database interno** con 50+ ingredienti comuni italiani:

- **Formaggi**: Mozzarella, Gorgonzola, Parmigiano → Lattosio
- **Pesce**: Tonno, Salmone, Acciughe → Pesce
- **Frutti di mare**: Vongole, Cozze → Molluschi
- **Verdure**: Pomodoro, Funghi → Nichel
- **Frutta a guscio**: Noci, Nocciole → Noci
- **Altro**: Uova, Farina, Sesamo, Senape, Sedano, Soia

**Vantaggi**:
- ✅ Funziona offline
- ✅ Personalizzato per pizzeria italiana
- ✅ Zero dipendenze esterne

---

### 3️⃣ **API Esterna OpenFoodFacts (Online)**

Se l'ingrediente non è nel database locale, interroga **OpenFoodFacts** (database mondiale gratuito):

- 🌍 2.8+ milioni di prodotti
- 🆓 API gratuita
- 🇮🇹 Supporta lingua italiana

**Come funziona**:
```
Ingrediente: "Taleggio"
→ Cerca nel DB locale: ❌ Non trovato
→ Interroga OpenFoodFacts: ✅ Trovato! "en:milk"
→ Mappa a "Lattosio" e associa
```

---

## 📝 Utilizzo

### **Metodo 1: Automatico (Consigliato)**

Non fare nulla! Il sistema funziona automaticamente quando:
- ✅ Crei un nuovo ingrediente
- ✅ Modifichi il nome di un ingrediente esistente

### **Metodo 2: Comando Manuale**

Esegui periodicamente per trovare ingredienti "dimenticati":

```bash
php artisan allergens:detect-missing
```

**Output**:
```
🔍 Cerco ingredienti senza allergeni associati...

📊 RISULTATI:
+-----------------------------+--------+
| Ingredienti senza allergeni | 25     |
| Ingredienti processati      | 25     |
| Allergeni assegnati         | 12     |
| Ingredienti senza match     | 13     |
+-----------------------------+--------+

✅ Allergeni assegnati automaticamente a 12 ingredienti!
```

### **Metodo 3: Interfaccia Web (AJAX)**

**Suggerimenti in tempo reale** nel form di creazione ingrediente:

1. **Endpoint**: `POST /admin/ajax/suggest-allergens`
   ```json
   {
     "ingredient_name": "Ricotta"
   }
   ```
   
   **Risposta**:
   ```json
   {
     "success": true,
     "ingredient": "Ricotta",
     "suggested_allergens": [
       {"id": 2, "name": "Lattosio"}
     ],
     "count": 1
   }
   ```

2. **Rilevamento forzato per un ingrediente**:
   ```bash
   POST /admin/ingredients/{id}/detect-allergens
   ```

3. **Auto-rilevamento batch per tutti**:
   ```bash
   POST /admin/ajax/auto-detect-allergens
   ```

---

## 🎨 Integrazione Frontend (Opzionale)

Aggiungi questo JavaScript al form di creazione ingrediente:

```javascript
// resources/js/allergen-suggestion.js
document.getElementById('ingredient-name').addEventListener('blur', async function() {
    const ingredientName = this.value;
    
    if (ingredientName.length < 2) return;
    
    const response = await fetch('/admin/ajax/suggest-allergens', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ ingredient_name: ingredientName })
    });
    
    const data = await response.json();
    
    if (data.count > 0) {
        // Mostra suggerimenti
        showAllergenSuggestions(data.suggested_allergens);
    }
});

function showAllergenSuggestions(allergens) {
    const container = document.getElementById('allergen-suggestions');
    container.innerHTML = `
        <div class="alert alert-info">
            <strong>💡 Allergeni suggeriti:</strong>
            ${allergens.map(a => `
                <label class="form-check">
                    <input type="checkbox" name="suggested_allergens[]" value="${a.id}">
                    ${a.name}
                </label>
            `).join('')}
        </div>
    `;
}
```

---

## 🧪 Test

Verifica che tutto funzioni:

```bash
# 1. Crea un ingrediente di test
php artisan tinker
>>> $ing = Ingredient::create(['name' => 'Pecorino Romano']);
>>> $ing->allergens; // Dovrebbe mostrare "Lattosio"

# 2. Esegui il comando di rilevamento
php artisan allergens:detect-missing

# 3. Verifica il sistema completo
php artisan test:allergens
```

---

## 📊 Statistiche e Monitoraggio

Il sistema traccia automaticamente:
- ✅ Ingredienti con allergeni assegnati automaticamente
- ⚠️ Ingredienti senza match (richiedono attenzione manuale)
- 📈 Success rate del rilevamento

I log sono disponibili in `storage/logs/laravel.log`:
```
[2025-11-18] local.INFO: Allergeni rilevati per 'Gorgonzola': Lattosio
[2025-11-18] local.INFO: Associati 1 allergeni a 'Gorgonzola'
```

---

## ⚙️ Configurazione

### Disabilitare Auto-rilevamento Automatico

In `AppServiceProvider.php`, commenta:
```php
// Ingredient::observe(IngredientObserver::class);
```

### Espandere Database Locale

Modifica `AllergenDetectionService::$knownAllergens` per aggiungere nuovi ingredienti:

```php
private static $knownAllergens = [
    'bufala' => ['Lattosio'],
    'pecorino' => ['Lattosio'],
    // ... aggiungi qui
];
```

### Timeout API Esterna

Modifica il timeout (default 3 secondi):
```php
$response = Http::timeout(5) // 5 secondi invece di 3
```

---

## 🚀 Best Practices

1. **Esegui periodicamente** (1 volta/settimana):
   ```bash
   php artisan allergens:detect-missing
   ```

2. **Controlla ingredienti senza match**:
   - Aggiungi manualmente gli allergeni
   - Espandi il database locale
   - Crea issue su GitHub per condividere

3. **Monitora i log** per ingredienti problematici

4. **Usa il comando di test** dopo modifiche:
   ```bash
   php artisan test:allergens
   ```

---

## 📚 API Routes

| Metodo | Endpoint | Descrizione |
|--------|----------|-------------|
| POST | `/admin/ajax/suggest-allergens` | Suggerisce allergeni per nome ingrediente |
| POST | `/admin/ajax/auto-detect-allergens` | Auto-rileva per tutti gli ingredienti |
| POST | `/admin/ingredients/{id}/detect-allergens` | Forza rilevamento per ingrediente specifico |

---

## 🔒 Sicurezza

- ✅ Tutte le rotte richiedono autenticazione (`auth` middleware)
- ✅ CSRF protection abilitato
- ✅ API esterna con timeout per evitare blocchi
- ✅ Fallback locale se API non disponibile

---

## 📞 Supporto

**OpenFoodFacts API**:
- 🌐 Documentazione: https://world.openfoodfacts.org/data
- 📧 User-Agent: `PizzeriaBackend/1.0`
- 🆓 Gratuita e open source

**Issue noti**:
- Alcuni ingredienti regionali potrebbero non essere riconosciuti
- API esterna può essere lenta (3-5 secondi)
- Database locale richiede manutenzione

---

## ✅ Checklist Implementazione

- [x] `AllergenDetectionService` creato
- [x] `IngredientObserver` creato
- [x] `DetectMissingAllergens` command creato
- [x] `AllergenSuggestionController` creato
- [x] Observer registrato in `AppServiceProvider`
- [x] Routes aggiunte in `web.php`
- [ ] Test frontend con AJAX (opzionale)
- [ ] Schedulare comando settimanale in `Kernel.php` (opzionale)

---

## 🎯 Risultati Attesi

**Prima**:
```
Ingrediente: "Taleggio"
Allergeni: [] ❌ (dimenticato!)
```

**Dopo**:
```
Ingrediente: "Taleggio"
Allergeni: [Lattosio] ✅ (rilevato automaticamente!)
```

**Impatto**:
- 🚀 Zero sforzo per il proprietario
- 🛡️ Sicurezza alimentare garantita
- 📊 Database sempre aggiornato
- 💼 Conformità normativa EU 1169/2011
