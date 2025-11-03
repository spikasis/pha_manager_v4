# Deployment Guide - PHA Manager v4

## 🚀 URGENT: Authentication System Deployment

### Immediate Fix for 404 /auth/attempt-login Error

**Problem:** Production server returns 404 for `/auth/attempt-login` POST requests.

**Immediate Solution (Critical):**

1. **Update Routes.php** on production server:

   File: `app/Config/Routes.php`
   
   Add inside the auth group:
   ```php
   // Authentication routes with auth prefix
   $routes->group('auth', function($routes) {
       $routes->get('login', 'Auth::login');
       $routes->post('login', 'Auth::attemptLogin');
       $routes->post('attempt-login', 'Auth::attemptLogin'); // ← ADD THIS
       $routes->get('logout', 'Auth::logout');
       $routes->get('register', 'Auth::register');
       $routes->post('register', 'Auth::attemptRegister');
       $routes->post('attempt-register', 'Auth::attemptRegister'); // ← ADD THIS
   });
   ```

2. **Update Filters.php** to exclude auth from CSRF:

   File: `app/Config/Filters.php`
   
   Change CSRF section to:
   ```php
   'csrf' => [
       'before' => [
           'customers/store',
           'customers/update/*',
           'customers/delete/*'
           // REMOVED: 'auth/attempt-login', 'auth/attempt-register'
       ]
   ]
   ```

3. **Clear server cache:**
   ```bash
   php spark cache:clear
   sudo systemctl restart php8.3-fpm  # or apache2
   ```

### Complete Authentication System Files to Upload:

**Controllers:**
- `app/Controllers/Auth.php` (NEW)
- `app/Controllers/Dashboard.php` (UPDATE - branch logic)

**Models:**  
- `app/Models/UserModel.php` (NEW)
- `app/Models/GroupModel.php` (NEW)
- `app/Models/LoginAttemptModel.php` (NEW)

**Config:**
- `app/Config/Auth.php` (NEW)
- `app/Config/Routes.php` (UPDATE)
- `app/Config/Filters.php` (UPDATE)

**Filters:**
- `app/Filters/AuthFilter.php` (NEW)
- `app/Filters/AdminFilter.php` (NEW) 
- `app/Filters/PermissionFilter.php` (NEW)

**Views:**
- `app/Views/auth/login.php` (NEW)
- `app/Views/auth/register.php` (NEW)
- `app/Views/dashboard/branch.php` (NEW)
- `app/Views/dashboard/index.php` (UPDATE)
- `app/Views/templates/layout.php` (UPDATE - CDN assets)

**Test Tools (Optional):**
- `public/reset_password.php` (for password resets)

---

## Production Deployment on HTTPS

### Issue: Mixed Content Errors

If you see errors like:
```
Mixed Content: The page at 'https://manager.pikasishearing.gr/public/' was loaded over HTTPS, 
but requested an insecure element 'http://localhost:8080/...'
```

This happens when the application is configured with an HTTP baseURL but deployed on HTTPS.

### Solution

1. **Update your `.env` file** on the production server:

   ```bash
   # Change this:
   app.baseURL = 'http://localhost:8080/'
   
   # To this (recommended):
   app.baseURL = ''
   
   # Or specify your production URL:
   app.baseURL = 'https://manager.pikasishearing.gr/'
   ```

2. **Set the environment to production:**

   ```bash
   CI_ENVIRONMENT = production
   ```

3. **Update database settings:**

   ```bash
   database.default.hostname = your-db-host
   database.default.database = your-db-name
   database.default.username = your-db-user
   database.default.password = your-db-password
   ```

4. **Generate a new encryption key** (if not already done):

   ```bash
   php spark key:generate
   ```

5. **Clear all caches:**

   ```bash
   # Clear CodeIgniter cache
   php spark cache:clear
   
   # Clear PHP opcache (if using PHP-FPM)
   sudo systemctl restart php8.3-fpm
   # Or for Apache with mod_php
   sudo systemctl restart apache2
   ```

6. **Update the codebase** (pull latest changes):

   ```bash
   git pull origin main
   composer install --no-dev --optimize-autoloader
   ```

### Web Server Configuration

#### Apache (.htaccess in public/)

The `.htaccess` file is already configured. Ensure `mod_rewrite` is enabled:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Your Apache VirtualHost should point to the `public/` directory:

```apache
<VirtualHost *:443>
    ServerName manager.pikasishearing.gr
    DocumentRoot /path/to/pha_manager_v4/public
    
    <Directory /path/to/pha_manager_v4/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    SSLEngine on
    SSLCertificateFile /path/to/cert.pem
    SSLCertificateKeyFile /path/to/key.pem
</VirtualHost>
```

#### Nginx

```nginx
server {
    listen 443 ssl;
    server_name manager.pikasishearing.gr;
    
    root /path/to/pha_manager_v4/public;
    index index.php;
    
    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### File Permissions

Ensure the `writable/` directory is writable by the web server:

```bash
sudo chown -R www-data:www-data writable/
sudo chmod -R 755 writable/
```

### Security Checklist

- [ ] Set `CI_ENVIRONMENT = production` in `.env`
- [ ] Set correct `app.baseURL` (HTTPS or empty)
- [ ] Generate unique encryption key
- [ ] Configure database with production credentials
- [ ] Set proper file permissions on `writable/`
- [ ] Remove or protect `.env` file from web access
- [ ] Enable HTTPS with valid SSL certificate
- [ ] Disable error display in production

### Testing

After deployment, test your site:

1. Open your site in a browser: `https://manager.pikasishearing.gr/`
2. Open browser DevTools (F12) → Console tab
3. Check for any Mixed Content or resource loading errors
4. All resources should load from HTTPS

### Troubleshooting

**Problem:** Resources still loading from `http://localhost:8080/` even after updating `.env`

**Root Cause:** The `app/Config/App.php` file has a hardcoded default baseURL that overrides the `.env` setting.

**Solution:**
1. Update the latest code which sets `app/Config/App.php` baseURL to empty string (auto-detect)
2. Clear all caches:
   ```bash
   php spark cache:clear
   sudo systemctl restart php8.3-fpm  # or restart apache2
   ```
3. Clear browser cache (Ctrl+Shift+Delete)
4. Verify the `.env` file on production server has:
   ```bash
   app.baseURL = ''
   ```

**Problem:** Resources still loading from HTTP after all fixes

**Solution:** Clear your browser cache and check:
- `.env` file has correct `app.baseURL = ''`
- `app/Config/App.php` has `public string $baseURL = '';`
- Web server cache is cleared
- PHP opcache is cleared and PHP-FPM/Apache restarted
- Browser cache is cleared (hard refresh: Ctrl+Shift+R)

**Problem:** 404 errors on routes

**Solution:** 
- Check web server points to `public/` directory
- Verify `.htaccess` exists in `public/`
- For Apache, ensure `mod_rewrite` is enabled

## Greek Version / Ελληνική Έκδοση

### Πρόβλημα: Mixed Content Errors

Εάν βλέπετε σφάλματα όπως:
```
Mixed Content: The page at 'https://manager.pikasishearing.gr/public/' was loaded over HTTPS, 
but requested an insecure element 'http://localhost:8080/...'
```

Αυτό συμβαίνει όταν η εφαρμογή είναι ρυθμισμένη με HTTP baseURL αλλά έχει αναπτυχθεί σε HTTPS.

### Λύση

1. **Ενημερώστε το `.env` αρχείο** στον production server:

   ```bash
   # Αλλάξτε αυτό:
   app.baseURL = 'http://localhost:8080/'
   
   # Σε αυτό (συνιστάται):
   app.baseURL = ''
   
   # Ή καθορίστε το production URL:
   app.baseURL = 'https://manager.pikasishearing.gr/'
   ```

2. **Ρυθμίστε το περιβάλλον σε production:**

   ```bash
   CI_ENVIRONMENT = production
   ```

3. **Καθαρίστε το cache:**

   ```bash
   php spark cache:clear
   ```

### Έλεγχος

Μετά την αλλαγή:
1. Ανοίξτε το site: `https://manager.pikasishearing.gr/`
2. Ελέγξτε το Console (F12) για σφάλματα
3. Όλοι οι πόροι πρέπει να φορτώνονται από HTTPS

Για περισσότερες λεπτομέρειες, δείτε την αγγλική έκδοση παραπάνω.
