/**
 * Stock Management JavaScript Functions
 * Dynamic menu selections for different user groups
 */

// Stock-related functions for dynamic menu selections

/**
 * Select selling point for stock sales (Admin only)
 */
function selectSellingPointSales() {
    const sellingPoints = [
        { id: 2, name: 'Λιβαδειά' },
        { id: 4, name: 'Θήβα' }
    ];
    
    let options = '<option value="">-- Επιλέξτε Υποκατάστημα --</option>';
    sellingPoints.forEach(sp => {
        options += `<option value="${sp.id}">${sp.name}</option>`;
    });
    
    Swal.fire({
        title: 'Πωλήσεις ανά Υποκατάστημα',
        html: `
            <div class="form-group">
                <label for="sellingPoint">Υποκατάστημα:</label>
                <select id="sellingPoint" class="form-control">
                    ${options}
                </select>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Προβολή',
        cancelButtonText: 'Άκυρο',
        preConfirm: () => {
            const sellingPoint = document.getElementById('sellingPoint').value;
            if (!sellingPoint) {
                Swal.showValidationMessage('Παρακαλώ επιλέξτε υποκατάστημα');
                return false;
            }
            return sellingPoint;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `${base_url}admin/stocks/get_sold/${result.value}`;
        }
    });
}

/**
 * Select selling point for current month sales (Admin only)
 */
function selectCurrentMonthSales() {
    const sellingPoints = [
        { id: 2, name: 'Λιβαδειά' },
        { id: 4, name: 'Θήβα' }
    ];
    
    let options = '<option value="">-- Επιλέξτε Υποκατάστημα --</option>';
    sellingPoints.forEach(sp => {
        options += `<option value="${sp.id}">${sp.name}</option>`;
    });
    
    Swal.fire({
        title: 'Πωλήσεις Τρέχοντος Μήνα',
        html: `
            <div class="form-group">
                <label for="sellingPoint">Υποκατάστημα:</label>
                <select id="sellingPoint" class="form-control">
                    ${options}
                </select>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Προβολή',
        cancelButtonText: 'Άκυρο',
        preConfirm: () => {
            const sellingPoint = document.getElementById('sellingPoint').value;
            if (!sellingPoint) {
                Swal.showValidationMessage('Παρακαλώ επιλέξτε υποκατάστημα');
                return false;
            }
            return sellingPoint;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `${base_url}admin/stocks/get_sold_current_month/${result.value}`;
        }
    });
}

/**
 * Select selling point for current year sales (Admin only)
 */
function selectCurrentYearSales() {
    const sellingPoints = [
        { id: 2, name: 'Λιβαδειά' },
        { id: 4, name: 'Θήβα' }
    ];
    
    let options = '<option value="">-- Επιλέξτε Υποκατάστημα --</option>';
    sellingPoints.forEach(sp => {
        options += `<option value="${sp.id}">${sp.name}</option>`;
    });
    
    Swal.fire({
        title: 'Πωλήσεις Τρέχοντος Έτους',
        html: `
            <div class="form-group">
                <label for="sellingPoint">Υποκατάστημα:</label>
                <select id="sellingPoint" class="form-control">
                    ${options}
                </select>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Προβολή',
        cancelButtonText: 'Άκυρο',
        preConfirm: () => {
            const sellingPoint = document.getElementById('sellingPoint').value;
            if (!sellingPoint) {
                Swal.showValidationMessage('Παρακαλώ επιλέξτε υποκατάστημα');
                return false;
            }
            return sellingPoint;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `${base_url}admin/stocks/get_sold_current_year/${result.value}`;
        }
    });
}

/**
 * Select selling point for service (Admin only)
 */
function selectServicePoint() {
    const sellingPoints = [
        { id: 2, name: 'Λιβαδειά' },
        { id: 4, name: 'Θήβα' }
    ];
    
    let options = '<option value="">-- Επιλέξτε Υποκατάστημα --</option>';
    sellingPoints.forEach(sp => {
        options += `<option value="${sp.id}">${sp.name}</option>`;
    });
    
    Swal.fire({
        title: 'Service ανά Υποκατάστημα',
        html: `
            <div class="form-group">
                <label for="sellingPoint">Υποκατάστημα:</label>
                <select id="sellingPoint" class="form-control">
                    ${options}
                </select>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Προβολή',
        cancelButtonText: 'Άκυρο',
        preConfirm: () => {
            const sellingPoint = document.getElementById('sellingPoint').value;
            if (!sellingPoint) {
                Swal.showValidationMessage('Παρακαλώ επιλέξτε υποκατάστημα');
                return false;
            }
            return sellingPoint;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `${base_url}admin/stocks/get_service/${result.value}`;
        }
    });
}

/**
 * Select doctor for sales report (Admin only)
 */
function selectDoctorSales() {
    // This would need to be populated from the database
    // For now, show a year selection first, then doctor selection
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

/**
 * Select year and selling point for barcode pending (Admin only)
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
 * Branch-specific functions (Groups 2, 4, 5)
 * These functions use the user's selling point from session
 */

/**
 * Branch sales - uses user's selling point
 */
function selectBranchSales() {
    // This will be handled by the controller to get user's selling point
    window.location.href = `${base_url}admin/stocks/get_branch_sales`;
}

/**
 * Branch current month sales
 */
function selectBranchCurrentMonth() {
    window.location.href = `${base_url}admin/stocks/get_branch_current_month`;
}

/**
 * Branch current year sales
 */
function selectBranchCurrentYear() {
    window.location.href = `${base_url}admin/stocks/get_branch_current_year`;
}

/**
 * Branch service
 */
function selectBranchService() {
    window.location.href = `${base_url}admin/stocks/get_branch_service`;
}

/**
 * Lab/Service group functions (Group 6)
 * These provide access to all branches for service purposes
 */

/**
 * All branches service for lab
 */
function selectAllBranchesService(sellingPoint = 2) {
    window.location.href = `${base_url}admin/stocks/get_service/${sellingPoint}`;
}

// Initialize base URL for use in functions
var base_url = window.location.origin + '/PHA_MANAGER_V4/';