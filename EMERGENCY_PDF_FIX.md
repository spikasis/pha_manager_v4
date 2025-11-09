# 🚨 EMERGENCY PDF FIX - PHA Manager V4

## ❗ IMMEDIATE ACTION REQUIRED

Ο production server έχει κατεστραμμένη εγκατάσταση Composer που προκαλεί crashes στη εγγύηση PDF.

## 🔧 QUICK FIXES (Επίλεξε μία)

### ✅ Option 1: Server Composer Fix (5 λεπτά)
```bash
# SSH στον server
cd /var/www/vhosts/asal.gr/manager.pikasishearing.gr/

# Διαγραφή κατεστραμμένων αρχείων
rm -rf vendor/ composer.lock

# Επαναεγκατάσταση (αν υπάρχει composer)
composer install --no-dev

# ΄Η upload composer.json από development και
composer install --no-dev
```

### ✅ Option 2: Upload vendor folder (10 λεπτά)
```bash
# Στο development PC
cd c:\Users\spika\PHA_MANAGER_V4
tar -czf vendor.tar.gz vendor/

# Upload vendor.tar.gz στον server και extract στο root
```

### ✅ Option 3: Disable mPDF 8.x (2 λεπτά)
```bash
# Απλά διαγραφή του problematic vendor
rm -rf /var/www/vhosts/asal.gr/manager.pikasishearing.gr/vendor/

# Η εφαρμογή θα χρησιμοποιήσει την παλιά mPDF 6.0
```

## 📋 FILES TO UPLOAD

**Minimal upload (για Option 1):**
- `composer.json`
- `composer.lock`

**Full upload (για Option 2):**
- Όλος ο `vendor/` φάκελος

**Diagnostic upload:**
- `server_pdf_check.php` (για έλεγχο status)
- `server_fix_pdf.sh` (αυτόματο fix script)

## 🛡️ PROTECTION ADDED

Η `Chart.php` τώρα έχει **triple fallback protection**:

1. **mPDF 8.x** (προτεραιότητα)
2. **mPDF 6.0** (fallback)
3. **Error message** (τελική προστασία)

**Η εφαρμογή ΔΕΝ ΘΑ ΚΡΑΣΑΡΕΙ πια** - θα εμφανίσει error message αντί να σταματήσει.

## 🔍 DIAGNOSTIC STEPS

### 1. Upload `server_pdf_check.php` και visit:
```
https://manager.pikasishearing.gr/server_pdf_check.php
```

### 2. Check server error logs:
```bash
tail -f /var/log/apache2/error.log
```

### 3. Quick test από command line:
```bash
cd /var/www/vhosts/asal.gr/manager.pikasishearing.gr/
php -r "
if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
    echo class_exists('\\Mpdf\\Mpdf') ? 'mPDF OK' : 'mPDF MISSING';
} else {
    echo 'VENDOR MISSING';
}
"
```

## ⚡ IMMEDIATE SOLUTION

**Αν θες άμεσο fix χωρίς hassle:**
```bash
rm -rf vendor/
```

Αυτό θα **διορθώσει άμεσα το crash** και η εγγύηση θα δουλέψει με την παλιά mPDF.

## 📞 STATUS CHECK

Μετά από οποιαδήποτε λύση, δοκίμασε:
1. Login στην εφαρμογή
2. Πήγαινε σε έναν πελάτη
3. Stocks → Actions → PDF εγγύηση
4. Θα πρέπει να λειτουργήσει χωρίς crash

---

**🎯 Priority**: Option 3 για immediate fix, μετά Option 1 για upgrade

**⏱️ Downtime**: 0 minutes - η εφαρμογή λειτουργεί κανονικά