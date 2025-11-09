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

## 🔧 Server Deployment (Production)

### Μεθοδος 1: Composer στον server (Προτεινόμενη)
```bash
# SSH στον production server
cd /var/www/vhosts/asal.gr/manager.pikasishearing.gr/

# Εγκατάσταση
composer install --no-dev --optimize-autoloader

# Αν δεν υπάρχει composer.json, copy από development
```

### Μέθοδος 2: Upload vendor folder
```bash
# Στο development
zip -r vendor.zip vendor/

# Upload στον server και extract
unzip vendor.zip
```

### Μέθοδος 3: Git deployment
```bash
# Στο development
git add composer.json composer.lock vendor/
git commit -m "Add mPDF 8.x"
git push

# Στον server
git pull origin main
```

## 🚨 Server Troubleshooting

### Αν παίρνεις σφάλματα στον server:

**1. Upload `server_pdf_check.php` στη root και visit στο browser:**
```
https://manager.pikasishearing.gr/server_pdf_check.php
```

**2. Common errors και λύσεις:**

```bash
# Error: "require(...): Failed to open stream"
rm -rf vendor/
composer install --no-dev

# Error: "Class not found"  
composer dump-autoload -o

# Error: "Permission denied"
chown -R www-data:www-data vendor/
chmod -R 755 vendor/
```

**3. Safe fallback:**
Η εφαρμογή τώρα έχει triple fallback:
1. mPDF 8.x (αν υπάρχει vendor/)
2. mPDF 6.0 (αν υπάρχει third_party/mpdf/)
3. Error message (αν τίποτα δεν δουλεύει)

### Rollback αν χρειαστεί:
Αν κάτι πάει στραβά, απλά διαγράφεις τον φάκελο `vendor/` και χρησιμοποιείς την παλιά έκδοση από `application/third_party/mpdf/`.

## 📋 Server Deployment Checklist

- [ ] Upload composer.json και composer.lock
- [ ] Run `composer install --no-dev` ή upload vendor/
- [ ] Test με server_pdf_check.php
- [ ] Test εγγύηση PDF από εφαρμογή
- [ ] Verify permissions (www-data:www-data)
- [ ] Check error logs αν υπάρχουν θέματα