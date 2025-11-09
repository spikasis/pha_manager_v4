# PHA MANAGER V4 - PROJECT GUIDELINES & CONSTANTS

## 🎯 CORE PRINCIPLES - MUST FOLLOW ALWAYS

### 1. **UI/UX Standards**
- **Theme**: SB Admin 2 Bootstrap 4 - **ALWAYS** use sbadmin2 assets
- **Greek Language**: All UI text in Greek, proper Greek typography
- **Responsive Design**: Bootstrap 4 classes, mobile-first approach
- **Icons**: FontAwesome 5+ for consistency
- **Color Scheme**: Primary #4e73df, Success #1cc88a, Warning #f6c23e, Danger #e74a3b

### 2. **Database Architecture** ⚠️ REFERENCE REQUIRED
- **Schema Source**: ALWAYS check `database_schema/customers_db2_2025-10-19_01-43-51.sql` for exact table/field names
- **Primary Tables**: customers, tasks, stocks, selling_points, notifications, banks, etc.
- **Key Relationships**: 
  - tasks.client → customers.id
  - tasks.acoustic_id → stocks.id  
  - tasks.selling_point → selling_points.id
- **Always filter by selling_point** for multi-branch isolation
- **Use proper JOIN queries** instead of multiple separate queries
- **NEVER modify database structure** - both production and development use live data

### 3. **PHP Development Standards**
- **Framework**: CodeIgniter 3.1.14-dev with HMVC
- **PHP Version**: 8.2+ compatibility (declare all properties)
- **Authentication**: Ion_auth for user management and permissions
- **Error Handling**: Always use try-catch, comprehensive logging
- **Models**: Extend from MY_Model, use consistent naming

### 4. **User Groups & Permissions** ⚠️ MANDATORY CONSULTATION
```
Group 1: Admin (administrator - full access)
Group 2: Member (public - basic access)
Group 4: Levadia (Λιβαδιά - branch limited access)  
Group 5: Thiva (Θήβα - branch limited access)
Group 6: Service (Lab - consolidated data across all selling points)
```

**CRITICAL RULE:** Every new method/view list MUST:
1. **Be added to sidemenu.php** - no exceptions
2. **Have permission level defined** - ALWAYS ask client:
   - "Όλοι οι χρήστες (all groups)?"
   - "Μόνο Admin (groups 1-2)?" 
   - "Υποκαταστήματα στα δικά τους μόνο (με selling_point filter)?"
3. **Implement proper Ion_auth checks** in controller

### 5. **JavaScript Standards**
- **jQuery**: Always wait for DOM and jQuery availability
- **DataTables**: Include proper CSS/JS, use Greek language pack
- **AJAX**: Always use POST, proper error handling, JSON responses
- **Event Delegation**: Use $(document).on() for dynamic elements
- **Debug Logging**: Comprehensive console.log for troubleshooting

### 6. **File Structure Patterns**
```
application/modules/admin/
├── controllers/ (business logic)
├── models/ (data access)
└── views/themes/sbadmin2/ (UI templates)

assets/sbadmin2/ (SB Admin 2 theme files)
├── vendor/ (third-party libraries)
├── css/ (stylesheets)
└── js/ (JavaScript files)
```

### 7. **Naming Conventions**
- **Controllers**: PascalCase (e.g., Tasks, Dashboard)
- **Models**: Singular lowercase (e.g., task, customer, stock)
- **Views**: snake_case (e.g., tasks_list, dashboard_sp)
- **Database Fields**: snake_case (e.g., client_id, selling_point)
- **CSS Classes**: Bootstrap 4 + custom Greek-friendly names

### 8. **Common Mistakes to AVOID** ⚠️ CRITICAL
- ❌ **NOT checking database_schema/ folder for correct field names**
- ❌ **Modifying existing controller methods without permission**
- ❌ **Testing on localhost (application is server-only)**
- ❌ **Making ANY database changes (FORBIDDEN)**
- ❌ Using old admin theme assets instead of sbladmin2
- ❌ Hardcoding URLs instead of using base_url()
- ❌ Missing selling_point filters in queries
- ❌ jQuery code outside DOMContentLoaded
- ❌ Missing property declarations for PHP 8.2+
- ❌ Forgetting to include DataTable scripts when needed
- ❌ Using direct SQL instead of CodeIgniter Query Builder

### 9. **Template System**
- **Layout**: Always use `admin/themes/sbadmin2/layout.php`
- **Components**: header.php, sidemenu.php, topbar.php, footer.php
- **Page Scripts**: Use `$data['page_scripts']` array in controllers
- **Modals**: Bootstrap 4 modals with AJAX data loading
- **Forms**: Bootstrap 4 styling with Ion_auth validation

### 10. **Notification System**
- **Real-time Updates**: Between service group and branch offices
- **Database Table**: notifications with proper relationships
- **Cross-Branch Communication**: Service group sees all, branches see own
- **UI Integration**: TopBar notification bell with counter

### 11. **Development Workflow** ⚠️ CRITICAL
1. **Database Schema Reference**: ALWAYS check `database_schema/` folder first for correct table/field names
2. **Use Existing Methods**: Use existing controller methods WITHOUT modification - focus on VIEW adaptations only
3. **NO Controller Refactoring**: Only modify controllers if explicitly told by client
4. **NO Localhost Testing**: Application runs on production/development server only
5. **GitHub Workflow**: Changes go to GitHub → client pulls → deploys to server
6. **NEVER Modify Database**: Both production and development use live database - NO database changes allowed
7. **Sidemenu Integration**: Every new method/view MUST be added to sidemenu with proper permissions
8. **Permission Consultation**: ALWAYS ask client about access levels for new features
9. **Always read existing code first** to understand patterns
10. **Document changes** in meaningful commit messages

### 12. **Performance & Security**
- **Database**: Use indexes, limit queries, proper WHERE clauses
- **Security**: Sanitize inputs, use CodeIgniter's built-in protection
- **Caching**: Avoid unnecessary repeated database calls
- **Sessions**: Proper session management with secure paths

---

## �️ DATABASE FIELD REFERENCE GUIDE

**Before writing ANY query, check these files:**
- `database_schema/customers_db2_2025-10-19_01-43-51.sql` - Complete schema
- `database_schema/notifications_table.sql` - Notifications structure

**Quick Search Commands:**
```bash
# Find table structure:
grep -A 20 "CREATE TABLE \`table_name\`" database_schema/*.sql

# Find all tables:
grep "CREATE TABLE" database_schema/*.sql

# Find specific field:
grep "field_name" database_schema/*.sql
```

**Common Tables Reference:**
- `customers` - Client data
- `tasks` - Work assignments  
- `stocks` - Hearing aid inventory
- `selling_points` - Branch offices
- `notifications` - System notifications
- `banks` - Banking information

---

## 🔐 SIDEMENU PERMISSION PATTERNS

**When adding new menu items, ask client:**

> "Για το νέο [feature name], ποιος θέλεις να έχει πρόσβαση;"
> 
> **Επιλογές:**
> - **Όλοι οι χρήστες** (groups 1,2,3,6)
> - **Μόνο Διαχειριστές** (groups 1,2) 
> - **Υποκαταστήματα στα δικά τους** (με selling_point filter)
> - **Μόνο Service Group** (group 6) - για συγκεντρωτικά δεδομένα

**Code Templates:**
```php
// All users
<?php if ($this->ion_auth->logged_in()): ?>

// Admin only  
<?php if ($this->ion_auth->in_group(1)): ?>

// Branch access (Levadia, Thiva, Member)
<?php if (in_array($group_id, [2, 4, 5])): ?>

// Service group access (Lab)
<?php if ($this->ion_auth->in_group(6)): ?>
```

---

##  QUICK REFERENCE CHECKLIST ⚠️ MANDATORY

Before making ANY changes, verify:
- [ ] **Checked database_schema/ folder for correct table/field names**
- [ ] **Using existing controller methods WITHOUT modification**
- [ ] **NO database changes planned or executed**
- [ ] **NO localhost testing - server-only deployment**
- [ ] **Asked client about user group permissions for new features**
- [ ] **Added sidemenu link with proper Ion_auth permission checks**
- [ ] Using SB Admin 2 theme assets
- [ ] Including selling_point filters where needed  
- [ ] PHP 8.2+ property declarations added
- [ ] jQuery wrapped in proper DOMContentLoaded
- [ ] DataTable scripts included if using tables
- [ ] Greek language support maintained
- [ ] Bootstrap 4 classes used consistently
- [ ] Error handling and logging in place
- [ ] Ion_auth permissions respected
- [ ] Mobile responsive design maintained

---

*This document should be referenced for EVERY development task to maintain consistency and avoid repeating mistakes.*