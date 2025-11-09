# PHA Manager V4 - mPDF Upgrade Instructions

## Εγκατάσταση νέας έκδοσης mPDF 8.x

### Βήμα 1: Εγκατάσταση dependencies
```bash
cd c:\Users\spika\PHA_MANAGER_V4
composer install --no-dev --optimize-autoloader
```

### Βήμα 2: Εναλλακτικά, αν θέλεις μόνο το mPDF
```bash
composer require mpdf/mpdf:^8.2
```

### Βήμα 3: Επιβεβαίωση εγκατάστασης
Μετά την εγκατάσταση θα έχεις:
- `vendor/mpdf/mpdf/` - Νέα έκδοση 8.x
- `vendor/autoload.php` - Composer autoloader

### Βήμα 4: Τεστ της λειτουργίας
1. Πήγαινε σε έναν πελάτη με ακουστικά
2. Κάντε κλικ στο "Καρτέλα PDF" από το dropdown
3. Θα πρέπει να δημιουργηθεί το PDF χωρίς σφάλματα

### Αντιμετώπιση προβλημάτων:

**Αν παίρνεις σφάλμα "Class not found":**
```bash
composer dump-autoload
```

**Αν θέλεις να κρατήσεις και την παλιά έκδοση:**
Μην διαγράψεις το `application/third_party/mpdf/` - ο κώδικας υποστηρίζει και τις δύο εκδόσεις.

**Αν έχεις memory issues:**
Πρόσθεσε στο `php.ini`:
```
memory_limit = 256M
max_execution_time = 300
```

### Πλεονεκτήματα νέας έκδοσης:
✅ Καλύτερη υποστήριξη ελληνικών χαρακτήρων
✅ Βελτιωμένη απόδοση
✅ Περισσότερες επιλογές CSS
✅ PHP 8.x compatibility
✅ Καλύτερο error handling

### Rollback αν χρειαστεί:
Αν κάτι πάει στραβά, απλά διαγράφεις τον φάκελο `vendor/` και χρησιμοποιείς την παλιά έκδοση από `application/third_party/mpdf/`.