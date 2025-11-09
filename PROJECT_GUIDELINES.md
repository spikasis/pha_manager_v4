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

### 13. **PDF Export with mPDF 8.x** ⚠️ UPDATED STANDARD
**For ALL PDF export functionality, use this pattern:**

**Controller Implementation:**
```php
// ALWAYS use Chart model's print_doc method
$html = $this->load->view('view_template', $data, true);
$title = 'PDF Document Title';
$this->chart->print_doc($html, $title);

// NEVER use M_pdf library directly:
// ❌ $this->m_pdf->pdf->WriteHTML($html); // OLD METHOD - DON'T USE
// ❌ $this->m_pdf->pdf->Output(); // OLD METHOD - DON'T USE
```

**Required Setup in Controller:**
```php
class YourController extends Admin_Controller {
    public $chart; // REQUIRED property declaration
    
    function __construct() {
        parent::__construct();
        $this->load->model('admin/chart'); // REQUIRED model loading
    }
}
```

**mPDF Version Detection:**
- System automatically detects mPDF 8.x (from Composer) vs mPDF 6.0 (legacy)
- Chart model handles version compatibility automatically
- No manual version checking needed in controllers

**Installation Status:**
- ✅ mPDF 8.2.6 installed via Composer
- ⚠️ Legacy mPDF 6.0 incompatible with PHP 8.0+ (deprecated syntax)
- ✅ Automatic version detection in Chart.php model  
- ✅ Enhanced error handling with graceful fallback
- ✅ Greek character support enabled
- ✅ Triple protection: mPDF 8.x → Legacy (PHP 7.x) → Error message

**PHP 8.2+ Compatibility:**
- ✅ All controller properties declared explicitly
- ✅ Function parameters properly ordered (required before optional)
- ✅ Error suppression during Composer loading
- ✅ Graceful degradation for broken dependencies

### 14. **DataTable Implementation Standard** ⚠️ MANDATORY PATTERN
**For ALL list views that use DataTables, follow this exact pattern:**

**Controller Setup:**
```php
// Helper method in controller (add once per controller)
private function add_datatable_config(&$data) {
    $data['page_scripts'] = [
        'assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js',
        'assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js'
    ];
    
    // Standard DataTable JavaScript configuration
    $data['custom_js'] = "
    $(document).ready(function() {
        console.log('Initializing DataTable...');
        
        if ($('#dataTable').length === 0) {
            console.error('Table #dataTable not found!');
            return;
        }
        
        if (typeof $.fn.DataTable === 'undefined') {
            console.error('DataTables library not loaded');
            return;
        }
        
        try {
            var table = $('#dataTable').DataTable({
                'responsive': true,
                'pageLength': 10,
                'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Όλα']],
                'searching': true,
                'ordering': true,
                'paging': true,
                'info': true,
                'autoWidth': false,
                'language': {
                    'search': 'Αναζήτηση:',
                    'lengthMenu': 'Εμφάνιση _MENU_ εγγραφών ανά σελίδα',
                    'info': 'Εμφάνιση _START_ έως _END_ από _TOTAL_ εγγραφές',
                    'infoEmpty': 'Εμφάνιση 0 έως 0 από 0 εγγραφές',
                    'infoFiltered': '(φιλτράρισμα από _MAX_ συνολικές εγγραφές)',
                    'paginate': {
                        'first': 'Πρώτη',
                        'last': 'Τελευταία', 
                        'next': 'Επόμενη',
                        'previous': 'Προηγούμενη'
                    },
                    'emptyTable': 'Δεν υπάρχουν δεδομένα στον πίνακα',
                    'zeroRecords': 'Δεν βρέθηκαν αποτελέσματα',
                    'loadingRecords': 'Φόρτωση...',
                    'processing': 'Επεξεργασία...'
                },
                'columnDefs': [
                    { 'orderable': false, 'targets': [-1] }, // Last column (actions)
                    { 'searchable': false, 'targets': [-1] }  // Last column (actions)
                ],
                'order': [[ 0, 'asc' ]]
            });
            
            console.log('DataTable initialized successfully');
            
        } catch (error) {
            console.error('Error initializing DataTable:', error);
        }
    });";
}

// In each list method
public function method_name() {
    // CRITICAL: Include ALL required fields for the view
    $data_array = $this->model->get_all('id, field1, field2, field3, etc.');
    
    $data['items'] = $data_array;
    $data['title'] = 'Page Title';
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "view_name";
    
    // Add DataTable configuration
    $this->add_datatable_config($data);
    
    $this->load->view($this->_container, $data);
}
```

**View Requirements:**
- Table MUST have `id="dataTable"` (or update JavaScript accordingly)
- Include ALL columns that JavaScript expects in columnDefs
- Use proper Bootstrap 4 table classes
- Never include DataTable JavaScript in view file (use custom_js instead)

**Common Issues to Avoid:**
- ❌ Missing fields in database query (causes empty columns)
- ❌ JavaScript in view instead of custom_js (loading order issues)
- ❌ Wrong table ID in JavaScript vs HTML
- ❌ Missing error handling in JavaScript
- ❌ Incorrect column count in columnDefs

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