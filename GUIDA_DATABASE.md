# 🗄️ GUIDA AL DATABASE DEL PROGETTO PIZZERIA

## 🎯 PANORAMICA GENERALE

Il database è il cuore dell'applicazione dove vengono memorizzati tutti i dati. Laravel usa **Eloquent ORM** che traduce codice PHP in query SQL, rendendo il lavoro col database molto più semplice e sicuro.

---

## 📋 INDICE

1. [Architettura Database](#-parte-1-architettura-database)
2. [Migrations - Creare le Tabelle](#-parte-2-migrations)
3. [Models - Eloquent ORM](#-parte-3-models-eloquent-orm)
4. [Seeders - Popolare il Database](#-parte-4-seeders)
5. [Factories - Dati di Test](#-parte-5-factories)
6. [Relazioni Database](#-parte-6-relazioni-database)

---

## 🏗️ PARTE 1: ARCHITETTURA DATABASE

### 📊 Schema Completo delle Tabelle

```
┌─────────────┐         ┌──────────────┐         ┌─────────────┐
│  categories │◄────────│    pizzas    │────────►│ ingredients │
└─────────────┘         └──────────────┘         └─────────────┘
                              │                         │
                              │                         │
                              ▼                         ▼
                    ┌──────────────────┐      ┌──────────────────┐
                    │ ingredient_pizza │      │ allergen_ingredient│
                    │  (PIVOT TABLE)   │      │   (PIVOT TABLE)    │
                    └──────────────────┘      └──────────────────┘
                                                        ▲
                                                        │
                                              ┌─────────────┐
                                              │  allergens  │
                                              └─────────────┘
```

### 🔑 Tabelle Principali

| Tabella | Scopo | Tipo |
|---------|-------|------|
| `users` | Utenti del sistema | Entità |
| `categories` | Categorie pizze (Classiche, Bianche, Speciali) | Entità |
| `pizzas` | Le pizze del menu | Entità |
| `ingredients` | Ingredienti disponibili | Entità |
| `allergens` | Allergeni alimentari | Entità |
| `appetizers` | Antipasti | Entità |
| `beverages` | Bevande | Entità |
| `desserts` | Dolci | Entità |

### 🔗 Tabelle Pivot (Relazioni Many-to-Many)

| Tabella | Collega | Scopo |
|---------|---------|-------|
| `ingredient_pizza` | ingredienti ↔ pizze | Quali ingredienti ha ogni pizza |
| `allergen_ingredient` | allergeni ↔ ingredienti | Quali allergeni ha ogni ingrediente |
| `appetizer_ingredient` | ingredienti ↔ antipasti | Ingredienti degli antipasti |
| `dessert_ingredient` | ingredienti ↔ dolci | Ingredienti dei dolci |

### 📐 Tipi di Relazioni

**One-to-Many (Uno a Molti)**:
- Una categoria ha molte pizze
- `categories` (1) → `pizzas` (N)

**Many-to-Many (Molti a Molti)**:
- Una pizza ha molti ingredienti
- Un ingrediente è in molte pizze
- Serve tabella pivot: `ingredient_pizza`

---

## 🔨 PARTE 2: MIGRATIONS

### 📍 Cos'è una Migration?
Una migration è come un "blueprint" della struttura del database. È un file PHP che descrive come creare (o modificare) una tabella.

**Vantaggi**:
- ✅ Versionamento del database (come Git per le tabelle)
- ✅ Rollback facile (annullare modifiche)
- ✅ Condivisione struttura nel team
- ✅ Deployment automatico

---

### 1️⃣ MIGRATION: CREATE CATEGORIES TABLE

**File**: `2025_09_23_162015_create_categories_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
```

**Spiegazione**:
- `Migration` = Classe base di Laravel per migrations
- `Blueprint` = Classe per definire la struttura della tabella
- `Schema` = Facade per interagire con il database

---

```php
return new class extends Migration
{
```

**Spiegazione**:
- `new class extends Migration` = Classe anonima (PHP 8+)
- Ogni migration è una classe che eredita da `Migration`

---

```php
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
```

**Spiegazione riga per riga**:

| Codice | SQL Generato | Spiegazione |
|--------|--------------|-------------|
| `$table->id()` | `id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY` | Crea colonna ID auto-incrementale |
| `$table->string('name')` | `name VARCHAR(255) NOT NULL` | Testo fino a 255 caratteri |
| `$table->string('slug')->unique()` | `slug VARCHAR(255) UNIQUE NOT NULL` | Testo unico (indice) |
| `$table->text('description')->nullable()` | `description TEXT NULL` | Testo lungo, può essere vuoto |
| `$table->timestamps()` | `created_at, updated_at TIMESTAMP NULL` | Timestamp automatici |

**Cos'è uno slug?**
Un identificatore URL-friendly: "Pizze Classiche" → "pizze-classiche"

**Perché `unique()`?**
Nessuna categoria può avere lo stesso slug (previene duplicati).

**Cosa fa `nullable()`?**
Il campo può essere NULL nel database (opzionale).

---

```php
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
```

**Spiegazione**:
- `down()` = Funzione di rollback
- `dropIfExists()` = Elimina tabella se esiste
- Serve per annullare la migration con `php artisan migrate:rollback`

---

### 2️⃣ MIGRATION: CREATE PIZZAS TABLE

**File**: `2025_09_23_162039_create_pizzas_table.php`

```php
Schema::create('pizzas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
    $table->string('name');
    $table->string('slug')->unique();
    $table->decimal('price', 8, 2)->default(0);
    $table->text('description')->nullable();
    $table->timestamps();
});
```

**Analisi dettagliata delle colonne**:

#### `$table->foreignId('category_id')`
```sql
category_id BIGINT UNSIGNED NOT NULL
```
- Crea colonna per chiave esterna
- `BIGINT UNSIGNED` = Stesso tipo dell'ID della tabella categories
- Prepara per relazione con `categories`

#### `->nullable()`
```sql
category_id BIGINT UNSIGNED NULL
```
- La pizza può non avere categoria (opzionale)
- Permette NULL nel database

#### `->constrained()`
```sql
FOREIGN KEY (category_id) REFERENCES categories(id)
```
- **AUTOMATICAMENTE** capisce che si riferisce alla tabella `categories`
- Laravel deduce: `category_id` → tabella `categories`
- **Integrità referenziale**: Non puoi inserire `category_id = 999` se non esiste

#### `->nullOnDelete()`
```sql
ON DELETE SET NULL
```
- Se elimini una categoria, le pizze non vengono eliminate
- `category_id` diventa NULL nelle pizze orfane

**Alternative**:
- `->cascadeOnDelete()` = Elimina anche le pizze
- `->restrictOnDelete()` = Impedisci eliminazione se ci sono pizze

---

#### `$table->decimal('price', 8, 2)`
```sql
price DECIMAL(8,2) NOT NULL DEFAULT 0
```
**Spiegazione**:
- `decimal(8, 2)` = Numero con 8 cifre totali, 2 decimali
- Esempio: 999999.99 (massimo 6 cifre intere + 2 decimali)
- `->default(0)` = Valore di default se non specificato

**Perché DECIMAL e non FLOAT?**
- `DECIMAL` è preciso (per soldi!)
- `FLOAT` ha approssimazioni
- 10.50 + 10.50 con FLOAT potrebbe dare 21.000001!

---

### 3️⃣ MIGRATION: CREATE INGREDIENT_PIZZA TABLE (PIVOT)

**File**: `2025_09_23_162052_create_ingredient_pizza_table.php`

```php
Schema::create('ingredient_pizza', function (Blueprint $table) {
    $table->id();
    $table->foreignId('ingredient_id')->constrained()->cascadeOnDelete();
    $table->foreignId('pizza_id')->constrained()->cascadeOnDelete();
    $table->unique(['ingredient_id', 'pizza_id']);
    $table->timestamps();
});
```

**Spiegazione - TABELLA PIVOT**:

Una tabella pivot connette due tabelle in relazione Many-to-Many.

**Perché serve?**
- Una pizza ha molti ingredienti ✅
- Un ingrediente è in molte pizze ✅
- Non puoi mettere array nel database relazionale ❌
- Soluzione: tabella intermedia! ✅

**Esempio dati**:
```
ingredient_pizza:
| id | ingredient_id | pizza_id |
|----|---------------|----------|
| 1  | 1 (mozzarella)| 1 (Margherita) |
| 2  | 2 (pomodoro)  | 1 (Margherita) |
| 3  | 3 (basilico)  | 1 (Margherita) |
| 4  | 1 (mozzarella)| 2 (Capricciosa)|
```

**Analisi riga per riga**:

#### `$table->foreignId('ingredient_id')->constrained()->cascadeOnDelete()`

**Scomponiamo**:
1. `foreignId('ingredient_id')` = Crea colonna per ID ingrediente
2. `->constrained()` = Foreign key verso `ingredients`
3. `->cascadeOnDelete()` = Se elimini ingrediente, elimina le relazioni

**SQL generato**:
```sql
FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE
```

**Cosa significa CASCADE?**
```
Elimini "Mozzarella" (id=1)
    ↓
MySQL automaticamente elimina tutte le righe di ingredient_pizza dove ingredient_id=1
    ↓
Le pizze non vengono eliminate, solo la relazione!
```

---

#### `$table->unique(['ingredient_id', 'pizza_id'])`

**Indice composto unico**:
```sql
UNIQUE KEY unique_ingredient_pizza (ingredient_id, pizza_id)
```

**Scopo**: Previene duplicati!
- ❌ Non puoi inserire 2 volte "Mozzarella" nella stessa pizza
- ✅ Ma puoi avere "Mozzarella" in pizze diverse

**Esempio**:
```
✅ PERMESSO:
| ingredient_id | pizza_id |
| 1 (mozzarella)| 1 (Margherita) |
| 1 (mozzarella)| 2 (Capricciosa)|

❌ VIETATO (duplicato):
| ingredient_id | pizza_id |
| 1 (mozzarella)| 1 (Margherita) |
| 1 (mozzarella)| 1 (Margherita) | ← ERRORE!
```

---

### 🔄 Ordine delle Migrations

**Importantissimo**: Le migrations si eseguono in ordine cronologico (dal nome file).

**Ordine corretto**:
1. ✅ `2025_09_23_162015_create_categories_table.php`
2. ✅ `2025_09_23_162022_create_ingredients_table.php`
3. ✅ `2025_09_23_162039_create_pizzas_table.php`
4. ✅ `2025_09_23_162052_create_ingredient_pizza_table.php`

**Perché?**
Devi creare `categories` PRIMA di `pizzas` (per la foreign key)!

Se inverto l'ordine:
```
1. Creo pizzas con foreign key su categories
   ❌ ERRORE: categories non esiste!
```

---

### 📝 Comandi Migrations

```bash
# Esegui tutte le migrations
php artisan migrate

# Annulla ultima migration
php artisan migrate:rollback

# Annulla tutte e ri-esegui
php artisan migrate:fresh

# Annulla tutto, ri-esegui e popola con seeders
php artisan migrate:fresh --seed

# Vedi stato migrations
php artisan migrate:status
```

---

## 🎨 PARTE 3: MODELS (ELOQUENT ORM)

### 📍 Cos'è un Model?
Un model è una classe PHP che rappresenta una tabella del database. Con Eloquent puoi lavorare col database usando oggetti invece di SQL.

**Esempio**:
```php
// ❌ SQL grezzo (complicato)
$pizzas = DB::select('SELECT * FROM pizzas WHERE price > ?', [10]);

// ✅ Eloquent (semplice!)
$pizzas = Pizza::where('price', '>', 10)->get();
```

---

### 1️⃣ MODEL: PIZZA

**File**: `app/Models/Pizza.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
```

**Imports spiegati**:
- `HasFactory` = Trait per usare le factory (dati fake)
- `Model` = Classe base di tutti i model
- `BelongsTo` = Relazione "appartiene a"
- `BelongsToMany` = Relazione "molti a molti"
- `Collection` = Tipo di ritorno per collezioni Laravel

---

```php
class Pizza extends Model
{
    use HasFactory;
```

**Spiegazione**:
- `extends Model` = Eredita tutte le funzionalità Eloquent
- `use HasFactory` = Abilita factory per questa classe

**Cosa ottieni gratuitamente da Model?**
- ✅ Metodi CRUD: `create()`, `find()`, `update()`, `delete()`
- ✅ Query builder: `where()`, `orderBy()`, `with()`
- ✅ Relazioni: `belongsTo()`, `hasMany()`
- ✅ Eventi: `creating`, `updating`, `deleting`
- ✅ Accessors & Mutators (getter/setter custom)

---

#### `$fillable` - Mass Assignment Protection

```php
protected $fillable = [
    'category_id', 
    'name', 
    'slug', 
    'price', 
    'description', 
    'notes', 
    'manual_allergens', 
    'is_vegan', 
    'image_path'
];
```

**Spiegazione - SICUREZZA FONDAMENTALE**:

`$fillable` è una whitelist di campi che possono essere assegnati in massa.

**Esempio di attacco senza $fillable**:
```php
// Controller
Pizza::create($request->all());

// Utente malevolo invia:
POST /pizzas
{
    "name": "Hacked",
    "price": 0.01,  ← Vuole pizza gratis!
    "is_admin": true  ← Vuole diventare admin!
}
```

**Con $fillable protetto**:
```php
protected $fillable = ['name', 'price'];

// Laravel ignora is_admin perché NON è in $fillable!
Pizza::create($request->all());
// Inserisce solo name e price ✅
```

**Alternative**:
- `$guarded = ['id', 'is_admin']` = Blacklist (sconsigliato)
- `$fillable = []` = Blocca tutto
- `$guarded = []` = Permetti tutto (PERICOLOSO!)

---

#### `$casts` - Type Casting Automatico

```php
protected $casts = [
    'manual_allergens' => 'array',
    'is_vegan' => 'boolean',
    'image_path' => 'string',
];
```

**Spiegazione - CONVERSIONE AUTOMATICA**:

Laravel converte automaticamente i tipi tra database e PHP.

**Esempio `'manual_allergens' => 'array'`**:

**Database** (JSON string):
```sql
manual_allergens = '["1","2","3"]'
```

**PHP** (array automatico):
```php
$pizza->manual_allergens; // [1, 2, 3]

$pizza->manual_allergens = [4, 5];
$pizza->save();
// Laravel converte automaticamente in JSON: '["4","5"]'
```

**Tipi di cast disponibili**:
| Cast | Da DB | A PHP | Esempio |
|------|-------|-------|---------|
| `array` | JSON | Array | `["a","b"]` → `[a,b]` |
| `boolean` | 0/1 | true/false | `1` → `true` |
| `integer` | String | Int | `"10"` → `10` |
| `float` | String | Float | `"10.5"` → `10.5` |
| `date` | String | Carbon | `"2025-01-01"` → Carbon object |
| `datetime` | String | Carbon | Timestamp → Carbon |
| `json` | JSON | Stdclass | JSON → Object |

---

### 2️⃣ RELAZIONI ELOQUENT

#### Relazione BelongsTo (Appartiene A)

```php
public function category(): BelongsTo
{
    return $this->belongsTo(Category::class);
}
```

**Spiegazione**:
- Una pizza **appartiene a** una categoria
- Pizza ha `category_id` (foreign key)
- Laravel automaticamente fa join con `categories`

**Uso**:
```php
$pizza = Pizza::find(1);
$pizza->category->name; // "Classiche"

// SQL generato:
// SELECT * FROM pizzas WHERE id = 1
// SELECT * FROM categories WHERE id = pizza.category_id
```

**Convenzioni Eloquent**:
- Method name: `category` (singolare)
- Foreign key: `category_id` (dedotto automaticamente)
- Owner key: `id` (nella tabella categories)

---

#### Relazione BelongsToMany (Molti a Molti)

```php
public function ingredients(): BelongsToMany
{
    return $this->belongsToMany(Ingredient::class)->withTimestamps();
}
```

**Spiegazione**:
- Una pizza ha molti ingredienti
- Un ingrediente è in molte pizze
- Usa tabella pivot `ingredient_pizza`

**Cosa fa `withTimestamps()`?**
Aggiorna `created_at` e `updated_at` nella tabella pivot.

**Uso**:
```php
$pizza = Pizza::find(1);

// Ottieni ingredienti
$pizza->ingredients; // Collection di Ingredient objects

// Aggiungi ingrediente
$pizza->ingredients()->attach(5);

// Rimuovi ingrediente
$pizza->ingredients()->detach(5);

// Sostituisci tutto
$pizza->ingredients()->sync([1, 2, 3]);
```

**SQL generato**:
```sql
-- $pizza->ingredients
SELECT ingredients.* 
FROM ingredients
INNER JOIN ingredient_pizza ON ingredients.id = ingredient_pizza.ingredient_id
WHERE ingredient_pizza.pizza_id = 1
```

**Convenzioni Eloquent**:
- Method name: `ingredients` (plurale)
- Pivot table: `ingredient_pizza` (alfabetico)
- Foreign keys: `ingredient_id`, `pizza_id` (dedotti)

---

### 3️⃣ METODI CUSTOM NEL MODEL

#### `getAutomaticAllergens()` - Logica Business

```php
public function getAutomaticAllergens(): Collection
{
    // Se gli ingredienti e i loro allergeni sono già caricati, usali
    if ($this->relationLoaded('ingredients')) {
        return $this->ingredients
            ->pluck('allergens')
            ->flatten()
            ->unique('id');
    }
    
    // Fallback: query normale (solo se non in eager loading)
    return $this->ingredients()
        ->with('allergens')
        ->get()
        ->pluck('allergens')
        ->flatten()
        ->unique('id');
}
```

**Spiegazione riga per riga**:

#### `if ($this->relationLoaded('ingredients'))`
- Controlla se gli ingredienti sono già stati caricati
- **Ottimizzazione**: Evita query duplicate!

**Scenario 1** - Con eager loading:
```php
$pizzas = Pizza::with('ingredients.allergens')->get();
// 1 query per pizzas
// 1 query per ingredienti
// 1 query per allergeni
// TOTALE: 3 query per TUTTE le pizze!

foreach ($pizzas as $pizza) {
    $pizza->getAutomaticAllergens(); // ✅ Usa dati già in memoria
}
```

**Scenario 2** - Senza eager loading:
```php
$pizzas = Pizza::all();
// 1 query per pizzas

foreach ($pizzas as $pizza) {
    $pizza->getAutomaticAllergens(); 
    // ❌ 2 query per ogni pizza (ingredients + allergens)
    // 10 pizze = 21 query totali!
}
```

---

#### `->pluck('allergens')`
Estrae solo la proprietà `allergens` da ogni ingrediente.

**Esempio**:
```php
// Prima:
[
    Ingredient {id: 1, name: "Mozzarella", allergens: [Allergen {...}]},
    Ingredient {id: 2, name: "Pomodoro", allergens: [Allergen {...}]}
]

// Dopo pluck('allergens'):
[
    [Allergen {id: 1, name: "Lattosio"}],
    [Allergen {id: 2, name: "Nichel"}]
]
```

---

#### `->flatten()`
Appiattisce array multidimensionali.

**Esempio**:
```php
// Prima:
[
    [Allergen {id: 1}, Allergen {id: 2}],
    [Allergen {id: 3}],
    [Allergen {id: 1}]  // Duplicato!
]

// Dopo flatten():
[
    Allergen {id: 1},
    Allergen {id: 2},
    Allergen {id: 3},
    Allergen {id: 1}  // Ancora duplicato
]
```

---

#### `->unique('id')`
Rimuove duplicati basandosi sull'ID.

**Esempio**:
```php
// Prima:
[
    Allergen {id: 1, name: "Lattosio"},
    Allergen {id: 2, name: "Nichel"},
    Allergen {id: 1, name: "Lattosio"}  // Duplicato!
]

// Dopo unique('id'):
[
    Allergen {id: 1, name: "Lattosio"},
    Allergen {id: 2, name: "Nichel"}
]
```

**Perché servono duplicati?**
Esempio: Pizza con mozzarella E parmigiano → entrambi hanno "Lattosio"!

---

### 4️⃣ MODEL: CATEGORY (Semplice)

**File**: `app/Models/Category.php`

```php
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'is_white'];

    public function pizzas(): HasMany
    {
        return $this->hasMany(Pizza::class);
    }
}
```

**Relazione HasMany**:
- Una categoria **ha molte** pizze
- Inverso di BelongsTo
- `categories` (1) → `pizzas` (N)

**Uso**:
```php
$category = Category::find(1);
$category->pizzas; // Tutte le pizze di questa categoria

// SQL generato:
// SELECT * FROM pizzas WHERE category_id = 1
```

---

## 🌱 PARTE 4: SEEDERS

### 📍 Cos'è un Seeder?
Un seeder popola il database con dati iniziali o di test. Utile per:
- ✅ Sviluppo (dati di esempio)
- ✅ Testing (dati consistenti)
- ✅ Demo (mostrare l'app)
- ✅ Produzione (dati iniziali come categorie, ruoli)

---

### 1️⃣ SEEDER: ALLERGENS

**File**: `database/seeders/AllergenSeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\Allergen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AllergenSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Glutine',
            'Lattosio',
            'Uova',
            'Soia',
            'Arachidi',
            'Frutta a guscio',
            // ... altri
        ];
        
        foreach ($items as $name) {
            Allergen::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
```

**Spiegazione**:

#### `public function run(): void`
- Metodo chiamato da `php artisan db:seed`
- Qui metti tutta la logica di popolamento

---

#### `Allergen::firstOrCreate()`

**Sintassi**:
```php
Model::firstOrCreate(
    ['condizione' => 'valore'],  // Cerca con questa condizione
    ['dati' => 'da inserire']    // Se non trova, crea con questi dati
);
```

**Comportamento**:
1. Cerca un record con `slug = 'glutine'`
2. Se esiste → Ritorna quello esistente (non crea duplicato)
3. Se non esiste → Crea nuovo record con `name = 'Glutine'` e `slug = 'glutine'`

**Equivalente SQL**:
```sql
-- 1. Cerca
SELECT * FROM allergens WHERE slug = 'glutine' LIMIT 1;

-- 2. Se non trovato, inserisci
INSERT INTO allergens (name, slug) VALUES ('Glutine', 'glutine');
```

**Perché firstOrCreate()?**
- ✅ Idempotente: Puoi eseguire il seeder più volte senza duplicati
- ✅ Sicuro: Non da errore se i dati esistono già

**Alternative**:
```php
// updateOrCreate: Aggiorna se esiste
Allergen::updateOrCreate(
    ['slug' => 'glutine'],
    ['name' => 'Glutine Aggiornato']
);

// firstOrNew: Crea oggetto ma NON salva
$allergen = Allergen::firstOrNew(['slug' => 'glutine']);
$allergen->save(); // Devi salvare manualmente
```

---

### 2️⃣ SEEDER: INGREDIENTS (Con Relazioni)

**File**: `database/seeders/IngredientSeeder.php`

```php
public function run(): void
{
    $map = [
        'Mozzarella' => ['Lattosio'],
        'Pomodoro' => ['Nichel'],
        'Basilico' => [],
        'Gorgonzola' => ['Lattosio'],
        'Funghi champignon' => ['Nichel'],
        // ...
    ];

    foreach ($map as $name => $allergens) {
        $ingredient = Ingredient::updateOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name, 'is_tomato' => Str::slug($name) === 'pomodoro']
        );

        $ids = Allergen::whereIn('name', $allergens)->pluck('id');
        $ingredient->allergens()->syncWithoutDetaching($ids);
    }
}
```

**Spiegazione riga per riga**:

#### Struttura dati
```php
$map = [
    'Mozzarella' => ['Lattosio'],  // Ingrediente → Array di allergeni
];
```
- Key: Nome ingrediente
- Value: Array di nomi allergeni

---

#### `Ingredient::updateOrCreate()`
```php
$ingredient = Ingredient::updateOrCreate(
    ['slug' => Str::slug($name)],  // Cerca per slug
    ['name' => $name, 'is_tomato' => ...]  // Crea/aggiorna con questi dati
);
```

**Differenza con firstOrCreate**:
- `firstOrCreate`: Crea se non esiste, NON aggiorna
- `updateOrCreate`: Crea se non esiste, AGGIORNA se esiste

**Comportamento**:
```sql
-- Se esiste:
UPDATE ingredients SET name = 'Mozzarella', is_tomato = false WHERE slug = 'mozzarella';

-- Se non esiste:
INSERT INTO ingredients (name, slug, is_tomato) VALUES ('Mozzarella', 'mozzarella', false);
```

---

#### `Allergen::whereIn('name', $allergens)->pluck('id')`

**Scomponiamo**:
1. `whereIn('name', ['Lattosio', 'Nichel'])` = SQL `WHERE name IN ('Lattosio', 'Nichel')`
2. `->pluck('id')` = Estrai solo gli ID

**Risultato**:
```php
// Input: ['Lattosio', 'Nichel']
// Output: Collection([1, 5])  // ID degli allergeni
```

**SQL generato**:
```sql
SELECT id FROM allergens WHERE name IN ('Lattosio', 'Nichel');
```

---

#### `$ingredient->allergens()->syncWithoutDetaching($ids)`

**Spiegazione - SYNC VS SYNC WITHOUT DETACHING**:

**`sync([1, 2, 3])`**:
- ❌ Rimuove tutte le vecchie relazioni
- ✅ Aggiunge le nuove

**`syncWithoutDetaching([1, 2, 3])`**:
- ✅ Mantiene le vecchie relazioni
- ✅ Aggiunge solo le nuove (senza duplicati)

**Esempio**:
```php
// Stato iniziale:
// ingredient_id=1 ha allergens=[1, 2]

$ingredient->allergens()->sync([3, 4]);
// Risultato: allergens=[3, 4] (ha rimosso 1 e 2!)

$ingredient->allergens()->syncWithoutDetaching([5, 6]);
// Risultato: allergens=[3, 4, 5, 6] (ha mantenuto 3 e 4!)
```

**Perché usarlo qui?**
Se esegui il seeder due volte, non vuoi perdere relazioni esistenti!

---

### 3️⃣ SEEDER: DATABASE (Orchestratore)

**File**: `database/seeders/DatabaseSeeder.php`

```php
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            CustomUserSeeder::class,
            CategorySeeder::class,
            AllergenSeeder::class,
            IngredientSeeder::class,
            PizzaSeeder::class,
            AppetizerSeeder::class,
            BeverageSeeder::class,
            DessertSeeder::class,
        ]);
    }
}
```

**Spiegazione**:

#### `$this->call([...])`
Esegue altri seeders nell'ordine specificato.

**Ordine importantissimo**:
1. ✅ `AllergenSeeder` PRIMA di `IngredientSeeder` (per le relazioni)
2. ✅ `CategorySeeder` PRIMA di `PizzaSeeder` (foreign key!)
3. ✅ `IngredientSeeder` PRIMA di `PizzaSeeder` (relazioni)

**Perché?**
```php
// Se esegui PizzaSeeder prima di CategorySeeder:
Pizza::create(['category_id' => 1, ...]); 
// ❌ ERRORE: category_id=1 non esiste ancora!
```

---

#### `bcrypt('password')`
- Hash della password con Bcrypt
- **MAI** salvare password in chiaro!
- `bcrypt()` è one-way: non puoi decifrare l'hash

**Esempio**:
```php
bcrypt('password'); 
// $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

// Stesso input, hash diverso (per sicurezza):
bcrypt('password'); 
// $2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm
```

---

#### `now()`
- Helper Laravel per data/ora corrente
- Ritorna oggetto Carbon (estensione di DateTime)

```php
now(); // Carbon instance
now()->format('Y-m-d'); // "2025-11-17"
now()->addDays(7); // Data tra 7 giorni
```

---

### 📝 Comandi Seeders

```bash
# Esegui tutti i seeders
php artisan db:seed

# Esegui seeder specifico
php artisan db:seed --class=AllergenSeeder

# Reset DB e seeders
php artisan migrate:fresh --seed

# Solo un seeder dopo fresh
php artisan migrate:fresh
php artisan db:seed --class=CategorySeeder
```

---

## 🏭 PARTE 5: FACTORIES

### 📍 Cos'è una Factory?
Una factory genera dati fake per testing. Usa la libreria Faker per creare nomi, email, numeri casuali realistici.

---

### 1️⃣ FACTORY: PIZZA

**File**: `database/factories/PizzaFactory.php`

```php
<?php

namespace Database\Factories;

use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PizzaFactory extends Factory
{
    protected $model = Pizza::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'category_id' => Category::factory(),
            'name'        => $name,
            'slug'        => Str::slug($name),
            'price'       => $this->faker->randomFloat(2, 6.0, 18.0),
            'notes'       => $this->faker->optional(0.3)->sentence(),
            'is_vegan'    => $this->faker->boolean(25),
        ];
    }
}
```

**Spiegazione**:

#### `protected $model = Pizza::class`
- Specifica quale model questa factory crea
- Laravel lo deduce dal nome, ma esplicito è meglio

---

#### `public function definition(): array`
- Definisce i dati di default per creare una pizza
- Ritorna array di attributi

---

#### `$this->faker->unique()->words(2, true)`

**Scomponiamo**:
- `$this->faker` = Istanza di Faker
- `->unique()` = Valori unici (no duplicati)
- `->words(2, true)` = 2 parole casuali come stringa

**Esempi generati**:
```php
"Dolore Ipsum"
"Consectetur Adipiscing"
"Magna Aliqua"
```

**Senza `true`**:
```php
->words(2); // ["dolore", "ipsum"] ← Array
->words(2, true); // "dolore ipsum" ← String
```

---

#### `Category::factory()`
- Crea automaticamente una categoria
- **Relazione automatica**: Laravel crea la categoria e usa il suo ID

**Equivalente**:
```php
// Senza factory():
$category = Category::create(['name' => 'Test']);
'category_id' => $category->id;

// Con factory():
'category_id' => Category::factory();  // Laravel fa tutto!
```

---

#### `$this->faker->randomFloat(2, 6.0, 18.0)`
- Numero decimale casuale
- `2` = 2 decimali
- `6.0` = minimo
- `18.0` = massimo

**Esempi**:
```php
8.50
12.75
17.99
6.00
```

---

#### `$this->faker->optional(0.3)->sentence()`
- `optional(0.3)` = 30% probabilità di essere NULL
- `->sentence()` = Frase casuale

**Risultati**:
```php
// 70% dei casi:
"Voluptatum ut quia molestiae et."

// 30% dei casi:
null
```

---

#### `$this->faker->boolean(25)`
- Booleano casuale
- `25` = 25% probabilità di `true`
- 75% probabilità di `false`

**Uso**:
```php
is_vegan: true   // 25% delle pizze
is_vegan: false  // 75% delle pizze
```

---

### 2️⃣ USARE LE FACTORIES

```php
// Crea 1 pizza
$pizza = Pizza::factory()->create();

// Crea 10 pizze
$pizzas = Pizza::factory()->count(10)->create();

// Crea pizza con attributi custom
$pizza = Pizza::factory()->create([
    'name' => 'Margherita',
    'price' => 8.50
]);

// Crea ma NON salva (per test)
$pizza = Pizza::factory()->make();

// Crea con relazioni
$pizza = Pizza::factory()
    ->has(Ingredient::factory()->count(3))
    ->create();
```

---

### 🎲 FAKER - Metodi Utili

```php
// Testo
$faker->word;                // "ipsum"
$faker->words(3, true);      // "lorem ipsum dolor"
$faker->sentence;            // "Voluptatum ut quia."
$faker->paragraph;           // Paragrafo lungo
$faker->text(200);           // Testo di 200 caratteri

// Numeri
$faker->randomDigit;         // 0-9
$faker->randomNumber(4);     // 0000-9999
$faker->numberBetween(1, 100); // 1-100
$faker->randomFloat(2, 0, 100); // 0.00-100.00

// Persone
$faker->name;                // "Mario Rossi"
$faker->firstName;           // "Mario"
$faker->lastName;            // "Rossi"
$faker->email;               // "mario@example.com"

// Date
$faker->dateTime;            // DateTime object
$faker->date('Y-m-d');       // "2025-11-17"
$faker->dateTimeBetween('-1 year', 'now');

// Internet
$faker->url;                 // "https://example.com"
$faker->slug;                // "lorem-ipsum"
$faker->ipv4;                // "192.168.1.1"

// Booleani e scelte
$faker->boolean;             // true/false (50/50)
$faker->boolean(70);         // true 70%
$faker->randomElement(['a', 'b', 'c']); // Scelta casuale
$faker->optional()->word;    // null o word
```

---

## 🔗 PARTE 6: RELAZIONI DATABASE

### 📊 Riepilogo Relazioni

| Relazione | Caso d'uso | Eloquent | SQL |
|-----------|------------|----------|-----|
| **One-to-Many** | Una categoria → molte pizze | `hasMany()` / `belongsTo()` | Foreign Key |
| **Many-to-Many** | Pizze ↔ Ingredienti | `belongsToMany()` | Tabella Pivot |
| **One-to-One** | User → Profilo | `hasOne()` / `belongsTo()` | Foreign Key |
| **Polymorphic** | Commenti su post/video | `morphTo()` / `morphMany()` | Tipo + ID |

---

### 1️⃣ ONE-TO-MANY (Uno a Molti)

**Esempio**: Category → Pizzas

```php
// Model: Category
public function pizzas(): HasMany
{
    return $this->hasMany(Pizza::class);
}

// Model: Pizza
public function category(): BelongsTo
{
    return $this->belongsTo(Category::class);
}
```

**Database**:
```
categories:
| id | name      |
|----|-----------|
| 1  | Classiche |

pizzas:
| id | name       | category_id |
|----|------------|-------------|
| 1  | Margherita | 1           |
| 2  | Marinara   | 1           |
```

**Uso**:
```php
// Da categoria a pizze (1 → N)
$category = Category::find(1);
$category->pizzas; // Collection di pizze

// Da pizza a categoria (N → 1)
$pizza = Pizza::find(1);
$pizza->category->name; // "Classiche"
```

---

### 2️⃣ MANY-TO-MANY (Molti a Molti)

**Esempio**: Pizzas ↔ Ingredients

```php
// Model: Pizza
public function ingredients(): BelongsToMany
{
    return $this->belongsToMany(Ingredient::class)->withTimestamps();
}

// Model: Ingredient
public function pizzas(): BelongsToMany
{
    return $this->belongsToMany(Pizza::class)->withTimestamps();
}
```

**Database**:
```
pizzas:              ingredient_pizza:          ingredients:
| id | name       |  | pizza_id | ingredient_id | | id | name      |
|----|------------|  |----------|---------------|  |----|-----------|
| 1  | Margherita |  | 1        | 1             |  | 1  | Mozzarella|
| 2  | Marinara   |  | 1        | 2             |  | 2  | Pomodoro  |
                     | 2        | 2             |  | 3  | Basilico  |
                     | 1        | 3             |
```

**Uso**:
```php
// Leggi ingredienti
$pizza->ingredients; // Collection

// Aggiungi ingrediente
$pizza->ingredients()->attach(4);

// Rimuovi ingrediente
$pizza->ingredients()->detach(4);

// Sostituisci tutti
$pizza->ingredients()->sync([1, 2, 3]);

// Sincronizza senza rimuovere
$pizza->ingredients()->syncWithoutDetaching([4, 5]);
```

---

### 🎯 EAGER LOADING VS LAZY LOADING

**Lazy Loading** (Lento):
```php
$pizzas = Pizza::all(); // 1 query

foreach ($pizzas as $pizza) {
    echo $pizza->category->name; // 1 query per pizza!
}
// 10 pizze = 11 query totali (N+1 problem)
```

**Eager Loading** (Veloce):
```php
$pizzas = Pizza::with('category')->get(); // 2 query totali

foreach ($pizzas as $pizza) {
    echo $pizza->category->name; // Usa dati già caricati
}
// 10 pizze = 2 query totali ✅
```

**Eager Loading Annidato**:
```php
$pizzas = Pizza::with(['category', 'ingredients.allergens'])->get();
// Carica pizze + categorie + ingredienti + allergeni
// Solo 4 query per tutto!
```

---

## 🎯 COMANDI UTILI

```bash
# MIGRATIONS
php artisan make:migration create_pizzas_table
php artisan migrate
php artisan migrate:rollback
php artisan migrate:fresh
php artisan migrate:fresh --seed

# MODELS
php artisan make:model Pizza -m  # Con migration
php artisan make:model Pizza -mfs  # Con migration, factory, seeder

# SEEDERS
php artisan make:seeder PizzaSeeder
php artisan db:seed
php artisan db:seed --class=PizzaSeeder

# FACTORIES
php artisan make:factory PizzaFactory

# DATABASE
php artisan db:show  # Info database
php artisan db:table pizzas  # Info tabella

# TINKER (Console interattiva)
php artisan tinker
>>> Pizza::count()
>>> Pizza::factory()->count(5)->create()
```

---

## 💡 BEST PRACTICES

### ✅ DO (Fai)

1. **Usa Migrations** per tutte le modifiche al database
2. **Definisci $fillable** in ogni model (sicurezza)
3. **Usa Eager Loading** per evitare N+1 queries
4. **Nomina tabelle al plurale**: `pizzas`, `categories`
5. **Nomina model al singolare**: `Pizza`, `Category`
6. **Usa foreignId()->constrained()** per foreign keys
7. **Aggiungi indici** su colonne ricercate spesso
8. **Usa Seeders** per dati iniziali
9. **Usa Factories** per testing

### ❌ DON'T (Non fare)

1. ❌ Non modificare migrations già eseguite in produzione
2. ❌ Non usare `$guarded = []` (insicuro)
3. ❌ Non fare query in loop (N+1 problem)
4. ❌ Non salvare password in chiaro
5. ❌ Non usare raw SQL (usa query builder)
6. ❌ Non ignorare le foreign keys
7. ❌ Non dimenticare `->nullable()` per campi opzionali

---

## 🎓 CONCLUSIONE

Questo database dimostra:
- ✅ **Schema normalizzato** (3NF)
- ✅ **Relazioni complesse** (One-to-Many, Many-to-Many)
- ✅ **Integrità referenziale** (Foreign Keys)
- ✅ **Migrations versionabili**
- ✅ **Models eloquenti** con relazioni
- ✅ **Seeders per dati iniziali**
- ✅ **Factories per testing**
- ✅ **Ottimizzazioni** (eager loading, indici)
- ✅ **Sicurezza** (fillable, constraints)

**Per studenti junior**: Questa struttura database rappresenta un caso reale di e-commerce alimentare con gestione avanzata degli allergeni. Ogni concetto qui applicato è uno standard dell'industria nel development web moderno!
