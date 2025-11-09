# mPDF Server Installation Fix

## Πρόβλημα
Στον production server υπάρχει πρόβλημα με το Composer autoloader που προκαλεί σφάλματα κατά τη φόρτωση του mPDF.

## Λύση 1: Επαναεγκατάσταση Composer Dependencies (Προτεινόμενη)

### Στον Server Terminal:
```bash
# Μετάβαση στο directory του project
cd /var/www/vhosts/asal.gr/manager.pikasishearing.gr/

# Διαγραφή κατεστραμμένων vendor files
rm -rf vendor/
rm -f composer.lock

# Επαναεγκατάσταση
composer install --no-dev --optimize-autoloader

# Ή αν δεν υπάρχει composer.json
composer require mpdf/mpdf:^8.2 --no-dev
```

## Λύση 2: Fallback - Χρήση Legacy mPDF

### Αν δεν μπορείς να εκτελέσεις Composer στον server:

1. **Disable Composer loading στη Chart.php**:
   - Άλλαξε το `$composerLoaded = true;` σε `$composerLoaded = false;`
   - Η εφαρμογή θα χρησιμοποιήσει την παλιά mPDF 6.0 από third_party/

2. **Ή διαγραφή προβληματικού vendor folder**:
```bash
# Απλή διαγραφή του vendor directory
rm -rf /var/www/vhosts/asal.gr/manager.pikasishearing.gr/vendor/
```

## Λύση 3: Manual Fix (Προχωρημένη)

### Αν τα παραπάνω δεν δουλεύουν:

1. **Κατέβασε το vendor folder από το local**:
   - Compress το local `vendor/` folder
   - Upload στον server
   - Extract στο σωστό location

2. **Ή χρησιμοποίησε Git deployment**:
```bash
# Στο local
git add composer.json composer.lock vendor/
git commit -m "Add mPDF 8.x vendor files"
git push

# Στον server
git pull
```

## Επαλήθευση

### Test script στον server:
```bash
php -r "
if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
    if (class_exists('\\Mpdf\\Mpdf')) {
        echo 'mPDF 8.x OK\n';
    } else {
        echo 'mPDF 8.x NOT FOUND\n';
    }
} else {
    echo 'Composer autoloader missing\n';
}
"
```

## Fallback Protection

Η Chart.php τώρα έχει προστασία:
- Προσπαθεί να φορτώσει mPDF 8.x
- Αν αποτύχει, χρησιμοποιεί την παλιά mPDF 6.0
- Δεν θα crashάρει η εφαρμογή

## Συστάσεις

1. **Προτεραιότητα**: Λύση 1 (επαναεγκατάσταση Composer)
2. **Backup**: Λύση 2 (disable Composer, χρήση legacy)
3. **Τελευταία επιλογή**: Manual upload vendor files

Η εφαρμογή θα συνεχίσει να λειτουργεί ακόμα κι αν το mPDF 8.x δεν φορτωθεί.