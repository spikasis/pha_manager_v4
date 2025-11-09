/**
 * Stock Management JavaScript Functions - Updated Version
 * Using only existing controller methods
 */

/**
 * Select stock status for viewing (Available methods only)
 */
function selectStockStatus() {
    Swal.fire({
        title: 'Κατάσταση Αποθήκης',
        input: 'select',
        inputOptions: {
            'onstock': 'Διαθέσιμα στο Απόθεμα',
            'demo': 'Demo Ακουστικά', 
            'returns': 'Επιστροφές',
            'stockblack': 'Μαύρη Λίστα'
        },
        inputPlaceholder: 'Επιλέξτε κατάσταση',
        showCancelButton: true,
        confirmButtonText: 'Εμφάνιση',
        cancelButtonText: 'Άκυρο'
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            window.location.href = `${base_url}admin/stocks/get_${result.value}`;
        }
    });
}

/**
 * Select year and selling point for barcode pending (Existing method)
 */
function selectBarcodePending() {
    const sellingPoints = [
        { id: 2, name: 'Λιβαδειά' },
        { id: 4, name: 'Θήβα' }
    ];
    
    const currentYear = new Date().getFullYear();
    const years = [];
    for (let i = currentYear; i >= currentYear - 5; i--) {
        years.push(i);
    }
    
    let spOptions = '<option value="">-- Επιλέξτε Υποκατάστημα --</option>';
    sellingPoints.forEach(sp => {
        spOptions += `<option value="${sp.id}">${sp.name}</option>`;
    });
    
    let yearOptions = '<option value="">-- Επιλέξτε Έτος --</option>';
    years.forEach(year => {
        yearOptions += `<option value="${year}">${year}</option>`;
    });
    
    Swal.fire({
        title: 'Barcodes Εκκρεμείς',
        html: `
            <div class="form-group">
                <label for="sellingPoint">Υποκατάστημα:</label>
                <select id="sellingPoint" class="form-control">
                    ${spOptions}
                </select>
            </div>
            <div class="form-group">
                <label for="year">Έτος:</label>
                <select id="year" class="form-control">
                    ${yearOptions}
                </select>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Προβολή',
        cancelButtonText: 'Άκυρο',
        preConfirm: () => {
            const sellingPoint = document.getElementById('sellingPoint').value;
            const year = document.getElementById('year').value;
            if (!sellingPoint || !year) {
                Swal.showValidationMessage('Παρακαλώ συμπληρώστε και τα δύο πεδία');
                return false;
            }
            return { sellingPoint, year };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `${base_url}admin/stocks/view_barcodes_pending/${result.value.sellingPoint}/${result.value.year}`;
        }
    });
}

/**
 * View debt/unpaid items (existing method)
 */
function viewDebtItems() {
    window.location.href = `${base_url}admin/stocks/on_debt`;
}

/**
 * Select doctor for sales report (existing method)
 */
function selectDoctorSales() {
    const currentYear = new Date().getFullYear();
    const years = [];
    for (let i = currentYear; i >= currentYear - 10; i--) {
        years.push(i);
    }
    
    let yearOptions = '<option value="">-- Επιλέξτε Έτος --</option>';
    years.forEach(year => {
        yearOptions += `<option value="${year}">${year}</option>`;
    });
    
    Swal.fire({
        title: 'Πωλήσεις Γιατρού',
        html: `
            <div class="form-group">
                <label for="year">Έτος:</label>
                <select id="year" class="form-control">
                    ${yearOptions}
                </select>
            </div>
            <div class="form-group">
                <label for="doctor">Γιατρός ID:</label>
                <input type="number" id="doctor" class="form-control" placeholder="Εισάγετε ID γιατρού">
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Προβολή',
        cancelButtonText: 'Άκυρο',
        preConfirm: () => {
            const year = document.getElementById('year').value;
            const doctor = document.getElementById('doctor').value;
            if (!year || !doctor) {
                Swal.showValidationMessage('Παρακαλώ συμπληρώστε και τα δύο πεδία');
                return false;
            }
            return { year, doctor };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `${base_url}admin/stocks/view_doctors_sales/${result.value.doctor}/${result.value.year}`;
        }
    });
}

// Initialize base URL for use in functions
var base_url = window.location.origin + '/PHA_MANAGER_V4/';