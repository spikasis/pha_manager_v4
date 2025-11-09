-- =====================================================
-- ΜΟΝΟ ΠΡΟΣΘΗΚΗ ΠΕΔΙΟΥ demo_type - Εκτελέστε χειροκίνητα
-- =====================================================

-- Επιλέξτε τη βάση δεδομένων
USE customers_db2;

-- Προσθέστε το νέο πεδίο demo_type
ALTER TABLE `stocks` 
ADD COLUMN `demo_type` ENUM('trial', 'replacement') DEFAULT NULL 
COMMENT 'Τύπος Demo: trial=προς δοκιμή, replacement=προς αντικατάσταση' 
AFTER `on_test`;

-- Προσθέστε index για καλύτερη απόδοση
ALTER TABLE `stocks` 
ADD INDEX `idx_demo_type` (`demo_type`);

-- Έλεγχος ότι το πεδίο προστέθηκε επιτυχώς
DESCRIBE `stocks`;