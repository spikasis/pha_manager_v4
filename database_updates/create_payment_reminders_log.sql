-- Create payment_reminders_log table for production database
-- Execute this SQL in the customers_db2 database

CREATE TABLE `payment_reminders_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `reminder_type` enum('standard','urgent','final') DEFAULT 'standard',
  `sent_date` datetime NOT NULL,
  `sent_by` int(11) NOT NULL,
  `method` enum('system','manual','sms','email') DEFAULT 'system',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_customer_id` (`customer_id`),
  KEY `idx_stock_id` (`stock_id`),
  KEY `idx_sent_date` (`sent_date`),
  CONSTRAINT `fk_payment_reminders_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_payment_reminders_stock` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_payment_reminders_user` FOREIGN KEY (`sent_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Optional: Add selling point column to users table if not exists
-- ALTER TABLE `users` ADD COLUMN `selling_point_id` int(11) DEFAULT NULL AFTER `active`;
-- ALTER TABLE `users` ADD KEY `idx_selling_point` (`selling_point_id`);