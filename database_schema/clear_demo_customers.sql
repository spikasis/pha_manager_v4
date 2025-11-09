-- Βρες το ID του "not set customer"
SELECT id, name FROM customers WHERE name LIKE '%not set%' OR name LIKE '%Not Set%';

-- Κάνε όλα τα demo ακουστικά διαθέσιμα που έχουν "not set customer"
UPDATE stocks 
SET customer_id = NULL 
WHERE status = 5 
  AND customer_id = (SELECT id FROM customers WHERE name LIKE '%not set%' OR name LIKE '%Not Set%' LIMIT 1);