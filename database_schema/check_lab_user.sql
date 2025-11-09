-- Έλεγχος χρήστη lab στον πίνακα users

-- 1. Αναζήτηση χρήστη lab
SELECT 
    id,
    username,
    email,
    active,
    created_on,
    last_login,
    first_name,
    last_name
FROM users 
WHERE username = 'lab' OR username LIKE '%lab%';

-- 2. Αν δεν βρεθεί, δες όλους τους χρήστες
SELECT 
    id,
    username,
    email,
    active,
    created_on
FROM users 
ORDER BY id;

-- 3. Έλεγχος groups του χρήστη lab (αν υπάρχει)
SELECT 
    u.id as user_id,
    u.username,
    ug.group_id,
    g.name as group_name,
    g.description
FROM users u
LEFT JOIN users_groups ug ON u.id = ug.user_id
LEFT JOIN groups g ON ug.group_id = g.id
WHERE u.username = 'lab';

-- 4. Όλα τα διαθέσιμα groups
SELECT * FROM groups ORDER BY id;

-- 5. Όλες οι αντιστοιχίες users-groups
SELECT 
    u.username,
    g.name as group_name,
    ug.user_id,
    ug.group_id
FROM users_groups ug
JOIN users u ON ug.user_id = u.id
JOIN groups g ON ug.group_id = g.id
ORDER BY ug.user_id;