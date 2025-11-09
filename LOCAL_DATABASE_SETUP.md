# Οδηγίες για Local Database Setup

## 1. Εγκατάσταση XAMPP/WAMP/MAMP
- Download XAMPP από: https://www.apachefriends.org/
- Εκκίνηση Apache και MySQL services

## 2. Δημιουργία Local Database
```sql
-- Στο phpMyAdmin ή MySQL command line:
CREATE DATABASE customers_db2 CHARACTER SET utf8 COLLATE utf8_general_ci;
```

## 3. Import Schema
```bash
# Από command line:
mysql -u root -p customers_db2 < database_schema/customers_db2_2025-10-19_01-43-51.sql
```

## 4. Ενημέρωση Database Config
Στο `application/config/database.php`:
```php
'hostname' => 'localhost',
'username' => 'root',
'password' => '',  // ή το password που έβαλες
'database' => 'customers_db2',
```

## 5. Εκτέλεση Migration για demo_type
```sql
ALTER TABLE stocks ADD COLUMN demo_type ENUM('trial', 'replacement') NULL AFTER ektelesi_eopyy;
```

## 6. Populate Demo Data
```sql
-- Χρήση του simple_demo_to_trial.sql script
UPDATE stocks SET demo_type = 'trial' WHERE status = 5;
```