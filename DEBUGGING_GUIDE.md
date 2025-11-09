# 🔧 DEBUGGING TOOLS - Εγγύηση PDF Error 500

## 🚨 Current Status
- **Error**: 500 στη `/admin/stocks/eggyisi_doc/2443` 
- **Time**: 2025-11-09 13:19:56
- **User**: 2a02:587:9b0c:90a2:38ea:a2e7:7fa6:1fb3

## 🔍 DEBUGGING STEPS (σε σειρά προτεραιότητας)

### 1. **Immediate Diagnosis** (1 λεπτό)
```bash
# Upload files to server:
- debug_eggyisi_method.php (with debug method inside)
- application/modules/admin/controllers/Stocks.php (updated with debug method)

# Then visit:
https://manager.pikasishearing.gr/admin/stocks/debug_eggyisi_doc/2443
```

### 2. **Server Error Logs** (2 λεπτά)
```bash
# SSH to server and run:
bash check_server_errors.sh

# Or manually check:
tail -f /var/log/apache2/error.log
```

### 3. **PDF System Status** (1 λεπτό)
```bash
# Upload and run:
php server_pdf_check.php

# View in browser:
https://manager.pikasishearing.gr/server_pdf_check.php
```

### 4. **Emergency Fix** (1 λεπτό)
```bash
# If everything else fails:
php emergency_fix.php

# Or manual:
rm -rf vendor/
```

## 🎯 LIKELY CAUSES

### Most Probable Issues:
1. **Missing database fields** - Stock ID 2443 missing `ha_model`, `series`, etc.
2. **Broken relationships** - Model/Series/Manufacturer not found
3. **Still broken Composer** - mPDF 8.x loading issues
4. **View file errors** - PHP syntax issues in `eggyisi_doc_final.php`

### Database Issues:
```sql
-- Check if stock 2443 exists and has required fields
SELECT id, serial, customer_id, ha_model, manufacturer, type 
FROM stocks WHERE id = 2443;

-- Check if related data exists
SELECT * FROM models WHERE id = (SELECT ha_model FROM stocks WHERE id = 2443);
```

## 📁 FILES READY FOR UPLOAD

### Core Fixes:
- ✅ `application/modules/admin/controllers/Stocks.php` (PHP 8.2+ fixes + debug method)
- ✅ `application/modules/admin/models/Chart.php` (Enhanced error handling)
- ✅ `application/views/eggyisi_doc_final.php` (Fixed view syntax)

### Diagnostic Tools:
- ✅ `debug_eggyisi_method.php` (Step-by-step debugging)
- ✅ `server_pdf_check.php` (PDF system status)
- ✅ `emergency_fix.php` (Automated fix)
- ✅ `check_server_errors.sh` (Error log analysis)

### Documentation:
- ✅ `CRITICAL_SERVER_FIX.md` (Complete action plan)
- ✅ `EMERGENCY_PDF_FIX.md` (Quick fixes)

## 🔄 DEBUGGING WORKFLOW

```
1. Upload Stocks.php with debug method
   ↓
2. Visit debug_eggyisi_doc/2443 URL
   ↓
3. Identify exact failure point
   ↓
4. Apply targeted fix:
   - Data issue → Check database
   - mPDF issue → Fix Composer  
   - View issue → Fix template
   ↓
5. Remove debug method
   ↓
6. Test actual eggyisi_doc/2443
```

## ⚡ QUICK ACTIONS

### If you just want it working NOW:
```bash
rm -rf /var/www/vhosts/asal.gr/manager.pikasishearing.gr/vendor/
```
**Result**: Will use legacy mPDF (if available) or show error message instead of crashing.

### If you want proper solution:
1. Upload all fixed files from this session
2. Run debug to identify exact issue
3. Apply targeted fix
4. Test and verify

## 📊 SUCCESS METRICS

- ✅ **Before**: Fatal error 500, application crashes
- ✅ **After**: Either PDF generates OR user-friendly error message
- ✅ **Goal**: No more server crashes, graceful error handling

---

**Next Action**: Upload `Stocks.php` with debug method and visit debug URL to see exact failure point.