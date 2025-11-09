-- Προηγμένο script για διαχείριση demo ακουστικών
-- Ημερομηνία: 2025-11-09
-- Περιγραφή: Επιλεκτική ενημέρωση demo ακουστικών

-- 1. ΠΡΟΒΟΛΗ ΟΛΩΝ ΤΩΝ DEMO ΑΚΟΥΣΤΙΚΩΝ
SELECT 
    id,
    serial,
    manufacturer,
    model,
    type,
    status,
    demo_type,
    customer_id,
    CASE 
        WHEN customer_id IS NOT NULL THEN 'Σε χρήση'
        ELSE 'Διαθέσιμο'
    END as availability_status,
    comments
FROM stocks 
WHERE status = 5  -- status 5 = 'DEMO'
ORDER BY manufacturer, model, serial;

-- 2. ΚΑΝΕ ΟΛΑ ΤΑ ΔΙΑΘΕΣΙΜΑ DEMO ΑΚΟΥΣΤΙΚΑ "TRIAL"
-- (Αυτά που δεν έχουν customer_id)
UPDATE stocks 
SET demo_type = 'trial' 
WHERE status = 5  -- status 5 = 'DEMO'
  AND customer_id IS NULL;

-- 3. ΚΑΝΕ ΤΑ DEMO ΑΚΟΥΣΤΙΚΑ ΠΟΥ ΕΙΝΑΙ ΣΕ ΧΡΗΣΗ "REPLACEMENT" 
-- (Αυτά που έχουν customer_id)
UPDATE stocks 
SET demo_type = 'replacement' 
WHERE status = 5  -- status 5 = 'DEMO'
  AND customer_id IS NOT NULL;

-- 4. ΕΝΗΜΕΡΩΣΗ ΣΥΓΚΕΚΡΙΜΕΝΩΝ ΜΟΝΤΕΛΩΝ ΩΣ TRIAL (παράδειγμα)
-- Αλλαξε τα manufacturer/model ανάλογα με τις ανάγκες σου
/*
UPDATE stocks 
SET demo_type = 'trial' 
WHERE status = 5  -- status 5 = 'DEMO'
  AND manufacturer IN ('Phonak', 'Oticon')
  AND model LIKE '%Audeo%';
*/

-- 5. ΕΝΗΜΕΡΩΣΗ ΒΑΣΕΙ ΤΥΠΟΥ ΑΚΟΥΣΤΙΚΟΥ (BTE, ITE, κλπ)
/*
UPDATE stocks 
SET demo_type = 'trial' 
WHERE status = 5  -- status 5 = 'DEMO'
  AND type = 'BTE';

UPDATE stocks 
SET demo_type = 'replacement' 
WHERE status = 5  -- status 5 = 'DEMO'
  AND type = 'ITE';
*/

-- 6. ΠΡΟΒΟΛΗ ΑΠΟΤΕΛΕΣΜΑΤΩΝ
SELECT 
    demo_type,
    COUNT(*) as total_count,
    SUM(CASE WHEN customer_id IS NULL THEN 1 ELSE 0 END) as available_count,
    SUM(CASE WHEN customer_id IS NOT NULL THEN 1 ELSE 0 END) as in_use_count
FROM stocks 
WHERE status = 5  -- status 5 = 'DEMO'
GROUP BY demo_type
UNION ALL
SELECT 
    'ΣΥΝΟΛΟ' as demo_type,
    COUNT(*) as total_count,
    SUM(CASE WHEN customer_id IS NULL THEN 1 ELSE 0 END) as available_count,
    SUM(CASE WHEN customer_id IS NOT NULL THEN 1 ELSE 0 END) as in_use_count
FROM stocks 
WHERE status = 5;  -- status 5 = 'DEMO'

-- 7. ΛΕΠΤΟΜΕΡΕΙΣ ΣΤΑΤΙΣΤΙΚΕΣ ΑΝΑ ΚΑΤΑΣΚΕΥΑΣΤΗ
SELECT 
    manufacturer,
    model,
    demo_type,
    COUNT(*) as count,
    GROUP_CONCAT(serial ORDER BY serial SEPARATOR ', ') as serials
FROM stocks 
WHERE status = 5  -- status 5 = 'DEMO'
GROUP BY manufacturer, model, demo_type
ORDER BY manufacturer, model, demo_type;