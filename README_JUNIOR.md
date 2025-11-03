# 📚 PROGETTO PIZZERIA - STUDENTE JUNIOR

## 🎯 Panoramica
Questo è un backoffice Laravel semplificato per la gestione di una pizzeria, 
progettato specificamente per studenti junior.

## ✅ Caratteristiche per principianti

### 🏗️ Architettura
- **Laravel 11** con struttura standard
- **Controller vanilla** senza trait complessi  
- **Route semplici** facilmente comprensibili
- **Blade templates** con logica chiara

### 📁 Controller principali
- `CategoryController` - Gestione categorie (80 righe)
- `AllergenController` - Gestione allergeni (70 righe)  
- `BeverageController` - Gestione bevande (60 righe)
- `DessertController` - Gestione dolci (90 righe)
- `DashboardController` - Dashboard con statistiche (40 righe)

### 🗄️ Database
- **MySQL** con migrazioni semplici
- **Seeders** per dati di esempio
- **Factory** per test data

### 🎨 Frontend
- **Bootstrap 5** per UI responsive
- **Alpine.js** per comportamenti leggeri
- **Choices.js** per select migliorate
- **CSS minimo** e comprensibile

## 🚀 Come iniziare

1. **Installa dipendenze**:
   ```bash
   composer install
   npm install
   ```

2. **Configura database**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   ```

3. **Compila assets**:
   ```bash
   npm run build
   # oppure per sviluppo:
   npm run dev
   ```

4. **Avvia server**:
   ```bash
   php artisan serve
   ```

## 📖 Cosa studiare

### Per principianti:
- Studia i **Controller** per capire il pattern MVC
- Esamina le **Route** in `routes/web.php`
- Guarda i **Migration** per il database design
- Prova a modificare i **Blade templates**

### Funzionalità implementate:
- ✅ CRUD completo per tutte le entità
- ✅ Validazione dei form
- ✅ Upload immagini
- ✅ Relazioni database
- ✅ Autenticazione utenti
- ✅ Dashboard con statistiche

## 🛠️ Prossimi passi per apprendere

1. **Aggiungi validazioni** personalizzate
2. **Crea nuove relazioni** tra modelli  
3. **Implementa filtri** nelle liste
4. **Aggiungi API endpoints** semplici
5. **Migliora l'interfaccia** con più Bootstrap

---
*Progetto semplificato per scopi educativi - ogni file è commentato per facilitare l'apprendimento*