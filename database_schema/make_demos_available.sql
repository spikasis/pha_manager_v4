-- Script για να κάνει όλα τα demo ακουστικά διαθέσιμα
-- Ημερομηνία: 2025-11-09
-- Περιγραφή: Καθαρίζει τα customer_id από τα demo ακουστικά για να γίνουν διαθέσιμα

-- Προβολή των demo ακουστικών πριν την αλλαγή
SELECT 
    COUNT(*) as total_demos,
    SUM(CASE WHEN customer_id IS NOT NULL THEN 1 ELSE 0 END) as in_use,
    SUM(CASE WHEN customer_id IS NULL THEN 1 ELSE 0 END) as available
FROM stocks 
WHERE status = 5;

-- Προβολή των πρώτων 10 demo που είναι in use
SELECT 
    id,
    serial,
    customer_id,
    selling_point,
    demo_type,
    comments
FROM stocks 
WHERE status = 5 AND customer_id IS NOT NULL
LIMIT 10;

-- ΚΥΡΙΟ SCRIPT: Κάνε όλα τα demo ακουστικά διαθέσιμα
UPDATE stocks 
SET 
    customer_id = NULL,
    day_out = NULL,
    on_test = 0
WHERE status = 5;

-- Επαλήθευση αποτελεσμάτων
SELECT 
    COUNT(*) as total_demos,
    SUM(CASE WHEN customer_id IS NOT NULL THEN 1 ELSE 0 END) as in_use,
    SUM(CASE WHEN customer_id IS NULL THEN 1 ELSE 0 END) as available,
    SUM(CASE WHEN demo_type = 'trial' THEN 1 ELSE 0 END) as trial_count,
    SUM(CASE WHEN demo_type = 'replacement' THEN 1 ELSE 0 END) as replacement_count
FROM stocks 
WHERE status = 5;

-- Προβολή ανά υποκατάστημα
SELECT 
    selling_point,
    COUNT(*) as count,
    SUM(CASE WHEN demo_type = 'trial' THEN 1 ELSE 0 END) as trial,
    SUM(CASE WHEN demo_type = 'replacement' THEN 1 ELSE 0 END) as replacement
FROM stocks 
WHERE status = 5
GROUP BY selling_point
ORDER BY selling_point;