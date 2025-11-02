# PHA Manager v4

## Σχετικά με το έργο

Αυτό το έργο χρησιμοποιεί το **CodeIgniter 4** framework για την ανάπτυξη εφαρμογών PHP.

## Απαιτήσεις συστήματος

- PHP 8.1 ή νεότερη έκδοση
- Composer
- Επεκτάσεις PHP:
  - intl
  - mbstring
  - json
  - mysqlnd (αν χρησιμοποιείτε MySQL)
  - libcurl (αν χρησιμοποιείτε το HTTP\CURLRequest)

## Εγκατάσταση

### 1. Κλωνοποίηση του repository

```bash
git clone https://github.com/spikasis/pha_manager_v4.git
cd pha_manager_v4
```

### 2. Εγκατάσταση των dependencies

```bash
composer install
```

### 3. Ρύθμιση του περιβάλλοντος

Αντιγράψτε το αρχείο `env` σε `.env` και προσαρμόστε τις ρυθμίσεις σύμφωνα με το περιβάλλον σας:

```bash
cp env .env
```

Επεξεργαστείτε το `.env` για να ρυθμίσετε:
- Το `baseURL` της εφαρμογής σας
- Τις ρυθμίσεις βάσης δεδομένων
- Άλλες παραμέτρους περιβάλλοντος

### 4. Δημιουργία κλειδιού κρυπτογράφησης

```bash
php spark key:generate
```

## Εκτέλεση της εφαρμογής

### Development Server

Για να εκκινήσετε τον διακομιστή ανάπτυξης:

```bash
php spark serve
```

Η εφαρμογή θα είναι διαθέσιμη στο: http://localhost:8080

### Production

Για production περιβάλλον, ρυθμίστε τον web server σας (Apache/Nginx) να δείχνει στο φάκελο `public/`.

**Σημαντικό:** Το `index.php` βρίσκεται στον φάκελο `public/`, όχι στο root του έργου!

## Χρήσιμες εντολές

### Εμφάνιση όλων των διαθέσιμων εντολών

```bash
php spark list
```

### Εκτέλεση migrations

```bash
php spark migrate
```

### Εκτέλεση tests

```bash
vendor/bin/phpunit
```

### Καθαρισμός cache

```bash
php spark cache:clear
```

## Δομή φακέλων

- `app/` - Ο κώδικας της εφαρμογής σας (Controllers, Models, Views, κ.λπ.)
- `public/` - Ο public web root (περιέχει το index.php και static assets)
- `tests/` - Τα tests της εφαρμογής
- `writable/` - Φάκελος για logs, cache, sessions, uploads
- `vendor/` - Dependencies του Composer (δεν περιλαμβάνεται στο Git)

## Τεκμηρίωση

- [CodeIgniter 4 User Guide](https://codeigniter.com/user_guide/)
- [CodeIgniter 4 Forum](https://forum.codeigniter.com)

## Άδεια χρήσης

Αυτό το έργο χρησιμοποιεί την άδεια MIT. Δείτε το αρχείο LICENSE για περισσότερες λεπτομέρειες.
