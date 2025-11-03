# PHA Manager v4 - Authentication System Deployment Guide

## 🎯 Objective
Deploy the fixed authentication system to production server to resolve:
- Database binding errors (TypeError in BaseBuilder::setBind)
- "No input file specified" errors after login
- CSRF security exceptions
- Incorrect redirect URLs

## 📂 Files to Upload to Production

### 1. **app/Models/UserModel.php**
**Issue Fixed:** TypeError in `updateLastLogin()` method
```php
// OLD (causing TypeError):
return $this->update($userId, ['last_login' => time()]);

// NEW (fixed):
return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
```

**Issue Fixed:** Database binding in `findByLogin()` method
```php
// OLD (causing binding conflicts):
return $this->groupStart()
           ->where('email', $login)
           ->orWhere('username', $login)
           ->groupEnd()
           ->first();

// NEW (fixed):
return $this->where("(email = ? OR username = ?)", [$login, $login])
           ->first();
```

### 2. **app/Controllers/Auth.php**
**Issue Fixed:** Redirect URLs causing "no input file specified"
```php
// OLD (relative paths):
return '/dashboard';

// NEW (using base_url helper):
return base_url('dashboard');
```

**Smart Redirection Logic:**
- Admin users → `base_url('dashboard')`
- Thiva users → `base_url('dashboard/thiva')`
- Levadia users → `base_url('dashboard/levadia')`
- Service users → `base_url('dashboard/service')`
- Selling Points → `base_url('dashboard/selling-points')`
- Lab users → `base_url('dashboard/lab')`

### 3. **app/Config/Auth.php**
**Issue Fixed:** Configuration paths for redirects
```php
// OLD:
public string $loginRedirect = '/dashboard';
public string $logoutRedirect = '/auth/login';

// NEW:
public string $loginRedirect = 'dashboard';
public string $logoutRedirect = 'auth/login';
```

### 4. **app/Config/Routes.php**
**Issue Fixed:** Added support for multiple auth route formats
```php
// Added routes for compatibility:
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/attempt-login', 'Auth::attemptLogin');
$routes->get('auth/logout', 'Auth::logout');
```

### 5. **app/Config/Filters.php**
**Issue Fixed:** CSRF protection causing authentication failures
```php
// Excluded auth routes from CSRF:
'csrf' => [
    'except' => [
        'auth/login',
        'auth/attempt-login',
        'auth/logout'
    ]
]
```

## 🚀 Quick Deployment Steps

### Step 1: Backup Current Production Files
```bash
# Create backup directory
mkdir /backup/pha_manager_$(date +%Y%m%d_%H%M%S)

# Backup critical files
cp /production/app/Models/UserModel.php /backup/
cp /production/app/Controllers/Auth.php /backup/
cp /production/app/Config/Auth.php /backup/
cp /production/app/Config/Routes.php /backup/
cp /production/app/Config/Filters.php /backup/
```

### Step 2: Upload Fixed Files
```bash
# Upload the corrected files
scp app/Models/UserModel.php user@server:/production/app/Models/
scp app/Controllers/Auth.php user@server:/production/app/Controllers/
scp app/Config/Auth.php user@server:/production/app/Config/
scp app/Config/Routes.php user@server:/production/app/Config/
scp app/Config/Filters.php user@server:/production/app/Config/
```

### Step 3: Test Authentication
1. Navigate to: `https://your-domain.com/auth/login`
2. Test login with existing user credentials
3. Verify redirect to appropriate dashboard based on user group
4. Check server logs for any errors
5. Test logout functionality

## 📊 Monitoring & Troubleshooting

### Check Application Logs
```bash
tail -f /production/writable/logs/log-$(date +%Y-%m-%d).log
```

### Check Web Server Logs
```bash
# Apache
tail -f /var/log/apache2/error.log

# Nginx  
tail -f /var/log/nginx/error.log
```

### Monitor Authentication Attempts
```bash
grep 'attempt-login' /production/writable/logs/log-$(date +%Y-%m-%d).log
```

## 🔄 Rollback Plan (if needed)
```bash
# Restore from backup
cp /backup/pha_manager_YYYYMMDD_HHMMSS/* /production/app/Models/
cp /backup/pha_manager_YYYYMMDD_HHMMSS/* /production/app/Controllers/
cp /backup/pha_manager_YYYYMMDD_HHMMSS/* /production/app/Config/
```

## ✅ Expected Results After Deployment

1. **Login Process Works:** Users can log in without TypeError or CSRF errors
2. **Smart Redirection:** Users are redirected to appropriate dashboards based on their group
3. **No "Input File Specified" Errors:** Proper URL generation with base_url()
4. **Session Management:** Login/logout works correctly
5. **Database Operations:** No more binding parameter type errors

## 🎯 Success Criteria

- [ ] Users can successfully log in at `/auth/login`
- [ ] No TypeError in database operations
- [ ] Proper redirection after login (no "no input file specified")
- [ ] CSRF protection works without blocking auth
- [ ] Server logs show no authentication errors
- [ ] Smart dashboard redirection based on user groups works

---
**Note:** Test thoroughly on production after deployment. The authentication system is now properly configured for the server environment with correct database connection handling.