-- Table for task notifications system
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `from_selling_point` int(11) NOT NULL,
  `to_selling_point` int(11) NOT NULL,
  `message` text NOT NULL,
  `type` enum('task_update','task_complete','task_assigned') NOT NULL DEFAULT 'task_update',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_to_selling_point` (`to_selling_point`),
  KEY `idx_is_read` (`is_read`),
  KEY `idx_task_id` (`task_id`),
  FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`from_selling_point`) REFERENCES `selling_points` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`to_selling_point`) REFERENCES `selling_points` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;