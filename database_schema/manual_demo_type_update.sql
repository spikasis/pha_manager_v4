-- =====================================================
-- Manual Database Update Script για Demo Type Field
-- Εκτελέστε αυτές τις εντολές μία-μία στο phpMyAdmin ή MySQL client
-- =====================================================

-- ΒΗΜΑ 1: Χρησιμοποιήστε τη σωστή βάση δεδομένων
USE customers_db2;

-- ΒΗΜΑ 2: Προσθέστε το νέο πεδίο demo_type
ALTER TABLE `stocks` 
ADD COLUMN `demo_type` ENUM('trial', 'replacement') DEFAULT NULL 
COMMENT 'Τύπος Demo: trial=προς δοκιμή, replacement=προς αντικατάσταση' 
AFTER `on_test`;

-- ΒΗΜΑ 3: Ενημερώστε τα υπάρχοντα δεδομένα
-- Όλα τα demo ακουστικά (status=5) με on_test=1 γίνονται trial
UPDATE `stocks` 
SET `demo_type` = 'trial' 
WHERE `status` = 5 AND `on_test` = 1;

-- Όλα τα demo ακουστικά (status=5) με on_test=0 ή NULL γίνονται replacement  
UPDATE `stocks` 
SET `demo_type` = 'replacement' 
WHERE `status` = 5 AND (`on_test` = 0 OR `on_test` IS NULL);

-- ΒΗΜΑ 4: Προσθέστε indexes για καλύτερη απόδοση
ALTER TABLE `stocks` 
ADD INDEX `idx_demo_type` (`demo_type`);

ALTER TABLE `stocks` 
ADD INDEX `idx_status_demo_type` (`status`, `demo_type`);

-- ΒΗΜΑ 5: Έλεγχος αποτελεσμάτων
SELECT 
    'Migration Results' as info,
    COUNT(*) as total_demo_stocks,
    SUM(CASE WHEN demo_type = 'trial' THEN 1 ELSE 0 END) as trial_count,
    SUM(CASE WHEN demo_type = 'replacement' THEN 1 ELSE 0 END) as replacement_count
FROM stocks 
WHERE status = 5;

-- ΒΗΜΑ 6: Προβολή λεπτομερειών (προαιρετικό)
SELECT 
    serial,
    on_test,
    demo_type,
    customer_id,
    CASE 
        WHEN customer_id IS NOT NULL AND customer_id > 0 THEN 'Σε χρήση' 
        ELSE 'Διαθέσιμο' 
    END as availability_status
FROM stocks 
WHERE status = 5 
ORDER BY demo_type, serial 
LIMIT 10;