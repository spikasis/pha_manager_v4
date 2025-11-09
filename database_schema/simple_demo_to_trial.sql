-- Απλό script: Όλα τα demo ακουστικά γίνονται "trial" (προς δοκιμή)
-- Εκτέλεσε αυτό το script στη MySQL για να κάνεις όλα τα demo ακουστικά trial

UPDATE stocks 
SET demo_type = 'trial' 
WHERE status = 5;  -- status 5 = 'DEMO'

-- Επαλήθευση
SELECT 
    COUNT(*) as total_demo_items,
    SUM(CASE WHEN demo_type = 'trial' THEN 1 ELSE 0 END) as trial_items,
    SUM(CASE WHEN demo_type = 'replacement' THEN 1 ELSE 0 END) as replacement_items
FROM stocks 
WHERE status = 5;