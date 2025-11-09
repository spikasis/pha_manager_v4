-- Migration Script για Demo Type Field
-- Εκτελέστε αυτό το script στη βάση δεδομένων σας

USE customers_db2;

-- Έλεγχος αν υπάρχει ήδη η στήλη
SET @col_exists = 0;
SELECT COUNT(*)
INTO @col_exists
FROM information_schema.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'stocks' 
AND COLUMN_NAME = 'demo_type';

-- Προσθήκη στήλης μόνο αν δεν υπάρχει
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE stocks ADD COLUMN demo_type ENUM(\'trial\', \'replacement\') DEFAULT NULL COMMENT \'Τύπος Demo: trial=προς δοκιμή, replacement=προς αντικατάσταση\' AFTER on_test',
    'SELECT "Column demo_type already exists" as message'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Ενημέρωση υπαρχόντων εγγραφών (μόνο αν η στήλη προστέθηκε)
SELECT @col_exists as 'Column_Added (0=Yes, 1=Already_Existed)';

-- Εάν η στήλη προστέθηκε, ενημέρωσε τα δεδομένα
UPDATE stocks 
SET demo_type = CASE 
    WHEN on_test = 1 THEN 'trial'
    WHEN on_test = 0 OR on_test IS NULL THEN 'replacement'
    ELSE 'replacement'
END 
WHERE status = 5 AND demo_type IS NULL;

-- Προσθήκη indexes για καλύτερη απόδοση
ALTER TABLE stocks ADD INDEX IF NOT EXISTS idx_demo_type (demo_type);
ALTER TABLE stocks ADD INDEX IF NOT EXISTS idx_status_demo_type (status, demo_type);

-- Προβολή αποτελεσμάτων
SELECT 
    'Migration completed successfully!' as status,
    COUNT(*) as total_demo_records,
    SUM(CASE WHEN demo_type = 'trial' THEN 1 ELSE 0 END) as trial_records,
    SUM(CASE WHEN demo_type = 'replacement' THEN 1 ELSE 0 END) as replacement_records
FROM stocks 
WHERE status = 5;