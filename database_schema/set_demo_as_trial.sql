-- Script για να κάνει όλα τα demo ακουστικά "trial" (προς δοκιμή)
-- Ημερομηνία: 2025-11-09
-- Περιγραφή: Ενημερώνει όλα τα ακουστικά με status='Demo' να έχουν demo_type='trial'

-- Προβολή των τρεχουσών demo ακουστικών πριν την αλλαγή
SELECT 
    id,
    serial,
    manufacturer,
    model,
    status,
    demo_type,
    comments
FROM stocks 
WHERE status = 'Demo'
ORDER BY id;

-- Ενημέρωση όλων των demo ακουστικών να γίνουν trial
UPDATE stocks 
SET demo_type = 'trial' 
WHERE status = 'Demo';

-- Προβολή των αποτελεσμάτων μετά την ενημέρωση
SELECT 
    id,
    serial,
    manufacturer,
    model,
    status,
    demo_type,
    comments,
    'Updated to trial' as action_performed
FROM stocks 
WHERE status = 'Demo'
ORDER BY id;

-- Στατιστικά των demo ακουστικών ανά τύπο
SELECT 
    demo_type,
    COUNT(*) as count,
    GROUP_CONCAT(CONCAT(manufacturer, ' ', model) SEPARATOR ', ') as models
FROM stocks 
WHERE status = 'Demo'
GROUP BY demo_type;

-- Επαλήθευση ότι όλα τα demo είναι πλέον trial
SELECT 
    CASE 
        WHEN COUNT(*) = SUM(CASE WHEN demo_type = 'trial' THEN 1 ELSE 0 END) 
        THEN 'SUCCESS: Όλα τα demo ακουστικά είναι πλέον trial'
        ELSE CONCAT('WARNING: ', 
                   COUNT(*) - SUM(CASE WHEN demo_type = 'trial' THEN 1 ELSE 0 END), 
                   ' demo ακουστικά δεν είναι trial')
    END as verification_result
FROM stocks 
WHERE status = 'Demo';