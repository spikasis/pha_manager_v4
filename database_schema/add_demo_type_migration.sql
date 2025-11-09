-- Add demo_type field to stocks table for better categorization
-- This will replace the confusing on_test logic with clear categories

ALTER TABLE `stocks` 
ADD COLUMN `demo_type` ENUM('trial', 'replacement') DEFAULT NULL 
COMMENT 'Τύπος Demo: trial=προς δοκιμή, replacement=προς αντικατάσταση' 
AFTER `on_test`;

-- Update existing records based on current logic
-- Assume all current demo items (status=5) with on_test are trials for now
UPDATE `stocks` 
SET `demo_type` = 'trial' 
WHERE `status` = 5;

-- Add index for better performance
ALTER TABLE `stocks` 
ADD INDEX `idx_demo_type` (`demo_type`);

-- Add composite index for common queries
ALTER TABLE `stocks` 
ADD INDEX `idx_status_demo_type` (`status`, `demo_type`);