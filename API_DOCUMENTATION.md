# 🌐 API DOCUMENTATION - Pizzeria Backend

## 📋 Base URL
```
http://localhost/api/v1
```

## 🎯 Endpoints Disponibili

### 📋 Menu Completo (Ottimizzato)
**Endpoint aggregato che restituisce tutto il menu in una sola chiamata**

```http
GET /api/v1/menu
```

**Response:**
```json
{
  "success": true,
  "data": {
    "categories": [...],
    "pizzas": [...],
    "appetizers": [...],
    "beverages": [...],
    "desserts": [...],
    "allergens": [...]
  },
  "meta": {
    "total_pizzas": 15,
    "total_appetizers": 8,
    "total_beverages": 12,
    "total_desserts": 6,
    "timestamp": "2025-11-17T10:30:00Z"
  }
}
```

---

### 🍕 Pizze

#### Lista tutte le pizze
```http
GET /api/v1/pizzas
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Margherita",
      "slug": "margherita",
      "price": 8.50,
      "description": "Pomodoro, mozzarella e basilico",
      "notes": null,
      "is_vegan": false,
      "image_url": "http://localhost/storage/pizzas/margherita.jpg",
      "category": {
        "id": 1,
        "name": "Classiche",
        "slug": "classiche",
        "is_white": false
      },
      "ingredients": [
        {"id": 1, "name": "Mozzarella", "slug": "mozzarella"},
        {"id": 2, "name": "Pomodoro", "slug": "pomodoro"},
        {"id": 3, "name": "Basilico", "slug": "basilico"}
      ],
      "allergens": [
        {"id": 1, "name": "Lattosio", "slug": "lattosio"},
        {"id": 15, "name": "Nichel", "slug": "nichel"}
      ]
    }
  ],
  "meta": {
    "total": 15
  }
}
```

#### Dettaglio singola pizza
```http
GET /api/v1/pizzas/{slug}
```

**Esempio:**
```http
GET /api/v1/pizzas/margherita
```

---

### 📂 Categorie

#### Lista tutte le categorie
```http
GET /api/v1/categories
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Classiche",
      "slug": "classiche",
      "description": "Le pizze più amate",
      "is_white": false,
      "pizzas_count": 8
    },
    {
      "id": 2,
      "name": "Bianche",
      "slug": "bianche",
      "description": "Senza pomodoro",
      "is_white": true,
      "pizzas_count": 5
    }
  ]
}
```

#### Dettaglio singola categoria
```http
GET /api/v1/categories/{slug}
```

#### Pizze di una categoria
```http
GET /api/v1/categories/{slug}/pizzas
```

**Esempio:**
```http
GET /api/v1/categories/classiche/pizzas
```

---

### 🥗 Antipasti

#### Lista tutti gli antipasti
```http
GET /api/v1/appetizers
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Bruschetta",
      "slug": "bruschetta",
      "price": 5.00,
      "description": "Pane tostato con pomodoro e basilico",
      "ingredients": [...],
      "allergens": [...]
    }
  ],
  "meta": {
    "total": 8
  }
}
```

#### Dettaglio singolo antipasto
```http
GET /api/v1/appetizers/{slug}
```

---

### 🥤 Bevande

#### Lista tutte le bevande
```http
GET /api/v1/beverages
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Coca Cola",
      "slug": "coca-cola",
      "price": 3.00,
      "description": "Bottiglia 33cl"
    }
  ],
  "meta": {
    "total": 12
  }
}
```

#### Dettaglio singola bevanda
```http
GET /api/v1/beverages/{slug}
```

---

### 🍰 Dolci

#### Lista tutti i dolci
```http
GET /api/v1/desserts
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Tiramisù",
      "slug": "tiramisu",
      "price": 6.00,
      "description": "Classico dolce italiano",
      "ingredients": [...],
      "allergens": [...]
    }
  ],
  "meta": {
    "total": 6
  }
}
```

#### Dettaglio singolo dolce
```http
GET /api/v1/desserts/{slug}
```

---

### 🧪 Ingredienti (per filtri)

#### Lista tutti gli ingredienti
```http
GET /api/v1/ingredients
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Mozzarella",
      "slug": "mozzarella",
      "is_tomato": false,
      "allergens": [
        {"id": 1, "name": "Lattosio", "slug": "lattosio"}
      ]
    }
  ],
  "meta": {
    "total": 30
  }
}
```

---

### ⚠️ Allergeni (per filtri)

#### Lista tutti gli allergeni
```http
GET /api/v1/allergens
```

**Response:**
```json
{
  "success": true,
  "data": [
    {"id": 1, "name": "Glutine", "slug": "glutine"},
    {"id": 2, "name": "Lattosio", "slug": "lattosio"},
    {"id": 3, "name": "Uova", "slug": "uova"}
  ],
  "meta": {
    "total": 15
  }
}
```

---

## 🔧 Configurazione Frontend React

### Axios Client
Il tuo frontend React è già configurato! Il file axios che hai fornito punta a `/api/v1`.

### Variabili d'ambiente (.env)
```env
VITE_API_BASE_URL=http://localhost
```

---

## 📊 Struttura Response Standard

Tutte le risposte seguono questo formato:

```json
{
  "success": true,
  "data": [...],
  "meta": {
    "total": 10,
    "...": "..."
  }
}
```

In caso di errore (non gestito lato backend in questo momento):
```json
{
  "success": false,
  "message": "Errore descrittivo"
}
```

---

## 🚀 Performance & Best Practices

### ✅ Eager Loading
Tutte le API usano eager loading per evitare il problema N+1:
```php
Pizza::with(['category', 'ingredients.allergens'])
```

### ✅ Route Model Binding con Slug
Puoi accedere alle risorse tramite slug user-friendly:
```
/api/v1/pizzas/margherita  ← invece di /api/v1/pizzas/1
```

### ✅ Type Casting
Tutti i numeri e booleani sono convertiti correttamente:
- `price`: float
- `is_vegan`: boolean
- `id`: integer

### ✅ Endpoint Aggregato
`/api/v1/menu` restituisce tutto in una chiamata per ridurre latenza HTTP.

---

## 🧪 Testing con Postman/Insomnia

### Collection Endpoints
```
GET http://localhost/api/v1/menu
GET http://localhost/api/v1/pizzas
GET http://localhost/api/v1/pizzas/margherita
GET http://localhost/api/v1/categories
GET http://localhost/api/v1/categories/classiche
GET http://localhost/api/v1/categories/classiche/pizzas
GET http://localhost/api/v1/appetizers
GET http://localhost/api/v1/beverages
GET http://localhost/api/v1/desserts
GET http://localhost/api/v1/ingredients
GET http://localhost/api/v1/allergens
```

### Headers
```
Accept: application/json
Content-Type: application/json
```

---

## 🔒 Sicurezza

### CORS
Configurato per accettare richieste da:
- `http://localhost:5173` (Vite default)
- `http://localhost:5174` (tuo frontend)
- Altri localhost:517x

### Rate Limiting
Laravel applica automaticamente rate limiting alle API:
- 60 richieste al minuto per IP
- Configurabile in `app/Http/Kernel.php`

---

## 💡 Esempi Uso Frontend React

### Fetch Menu Completo
```javascript
import api from './api'

const fetchMenu = async () => {
  try {
    const response = await api.get('/menu')
    const { pizzas, appetizers, beverages, desserts, allergens } = response.data.data
    console.log('Menu caricato:', pizzas.length, 'pizze')
  } catch (error) {
    console.error('Errore caricamento menu:', error)
  }
}
```

### Fetch Singola Pizza
```javascript
const fetchPizza = async (slug) => {
  try {
    const response = await api.get(`/pizzas/${slug}`)
    const pizza = response.data.data
    console.log('Pizza:', pizza.name, pizza.price)
  } catch (error) {
    console.error('Pizza non trovata:', error)
  }
}
```

### Fetch Pizze per Categoria
```javascript
const fetchCategoryPizzas = async (categorySlug) => {
  try {
    const response = await api.get(`/categories/${categorySlug}/pizzas`)
    const pizzas = response.data.data
    console.log(`Pizze categoria ${categorySlug}:`, pizzas.length)
  } catch (error) {
    console.error('Errore:', error)
  }
}
```

---

## 📝 Note Importanti

1. **Nessuna autenticazione**: Le API sono pubbliche (menu vetrina)
2. **Solo GET**: Nessuna modifica dati dal frontend (solo backoffice Laravel)
3. **CORS abilitato**: Frontend React può fare richieste cross-origin
4. **Slug-based routing**: URL SEO-friendly
5. **Allergeni automatici**: Calcolati automaticamente dagli ingredienti + manuali

---

## 🎯 Prossimi Passi

1. ✅ API create e funzionanti
2. ⏳ Testare con Postman/Insomnia
3. ⏳ Integrare nel frontend React
4. ⏳ Aggiungere cache (opzionale per performance)
5. ⏳ Aggiungere ricerca/filtri avanzati (opzionale)

---

**Le API sono pronte! 🚀**

Puoi testare subito con:
```bash
curl http://localhost/api/v1/menu
```
