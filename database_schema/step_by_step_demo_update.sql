-- ===========================================
-- ΕΝΤΟΛΕΣ ΓΙΑ ΧΕΙΡΟΚΙΝΗΤΗ ΕΚΤΕΛΕΣΗ ΜΙΑ-ΜΙΑ
-- Αντιγράψτε και επικολλήστε κάθε εντολή ξεχωριστά
-- ===========================================

-- 1️⃣ ΠΡΩΤΑ: Επιλέξτε τη βάση δεδομένων
USE customers_db2;

-- 2️⃣ ΔΕΥΤΕΡΑ: Προσθέστε το νέο πεδίο
ALTER TABLE `stocks` ADD COLUMN `demo_type` ENUM('trial', 'replacement') DEFAULT NULL COMMENT 'Τύπος Demo: trial=προς δοκιμή, replacement=προς αντικατάσταση' AFTER `on_test`;

-- 3️⃣ ΤΡΙΤΑ: Ενημερώστε τα trial ακουστικά
UPDATE `stocks` SET `demo_type` = 'trial' WHERE `status` = 5 AND `on_test` = 1;

-- 4️⃣ ΤΕΤΑΡΤΑ: Ενημερώστε τα replacement ακουστικά  
UPDATE `stocks` SET `demo_type` = 'replacement' WHERE `status` = 5 AND (`on_test` = 0 OR `on_test` IS NULL);

-- 5️⃣ ΠΕΜΠΤΑ: Προσθέστε index για demo_type
ALTER TABLE `stocks` ADD INDEX `idx_demo_type` (`demo_type`);

-- 6️⃣ ΕΚΤΑ: Προσθέστε composite index
ALTER TABLE `stocks` ADD INDEX `idx_status_demo_type` (`status`, `demo_type`);

-- 7️⃣ ΕΒΔΟΜΑ: Ελέγξτε τα αποτελέσματα
SELECT COUNT(*) as total_demo_stocks, SUM(CASE WHEN demo_type = 'trial' THEN 1 ELSE 0 END) as trial_count, SUM(CASE WHEN demo_type = 'replacement' THEN 1 ELSE 0 END) as replacement_count FROM stocks WHERE status = 5;