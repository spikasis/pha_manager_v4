<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tasks text-primary"></i> <?= $title ?>
        </h1>
        <div class="d-flex">
            <button id="addTaskBtn" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Προσθήκη Εργασίας
            </button>
        </div>
    </div>

    <!-- Statistics Cards Row -->
    <div class="row mb-4">
        <!-- Total Open Tasks Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Ανοιχτές Εργασίες</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($tasks) ? count($tasks) : '0' ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scan Pending Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Εκκρεμείς Σαρώσεις</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= isset($tasks) ? count(array_filter($tasks, function($task) { return !$task['scan']; })) : '0' ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-camera fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Pending Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Εκκρεμείς Παραγγελίες</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= isset($tasks) ? count(array_filter($tasks, function($task) { return empty($task['order']) || $task['order'] == '0000-00-00'; })) : '0' ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Pending Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Εκκρεμείς Παραδόσεις</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= isset($tasks) ? count(array_filter($tasks, function($task) { return empty($task['paradosi']) || $task['paradosi'] == '0000-00-00'; })) : '0' ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-handshake fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTales -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list"></i> Λίστα Ανοιχτών Εργασιών
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Εξαγωγή:</div>
                    <a class="dropdown-item" href="#" onclick="exportTableToExcel('tasksTable', 'anoixtes_ergasies')">
                        <i class="fas fa-file-excel fa-sm fa-fw mr-2 text-gray-400"></i> Excel
                    </a>
                    <a class="dropdown-item" href="#" onclick="exportTableToPDF()">
                        <i class="fas fa-file-pdf fa-sm fa-fw mr-2 text-gray-400"></i> PDF
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="tasksTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Ημ/νία</th>
                            <th>Γιατρός</th>
                            <th>Πελάτης</th>
                            <th>Ακουστικά</th>
                            <th>Scan</th>
                            <th>Παραγγελία</th>
                            <th>Γνωμάτευση</th>
                            <th>Παραλαβή</th>
                            <th>Τηλ. Ραντεβού</th>
                            <th>Εκτέλεση</th>
                            <th>Παράδοση</th>
                            <th>Υπογραφές</th>
                            <th>Απόδειξη</th>
                            <th>Αρχείο</th>
                            <th>Πρόοδος</th>
                            <th>Ενέργειες</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($tasks) && !empty($tasks)): ?>
                        <?php foreach($tasks as $task): 
                            // Υπολογισμός προόδου
                            $completed_steps = 0;
                            $total_steps = 7;
                            
                            if ($task['scan']) $completed_steps++;
                            if (!empty($task['order']) && $task['order'] != '0000-00-00') $completed_steps++;
                            if ($task['gnomateusi']) $completed_steps++;
                            if ($task['tel_rdv']) $completed_steps++;
                            if ($task['ektelesi']) $completed_steps++;
                            if ($task['signatures']) $completed_steps++;
                            if ($task['receipt']) $completed_steps++;
                            
                            $progress = round(($completed_steps / $total_steps) * 100);
                            $progress_class = $progress < 30 ? 'danger' : ($progress < 70 ? 'warning' : 'success');
                        ?>
                        <tr>
                            <!-- Entry Date -->
                            <td class="text-sm">
                                <div class="font-weight-bold"><?= date('d/m/Y', strtotime($task['entry_date'])) ?></div>
                                <small class="text-muted"><?= date('H:i', strtotime($task['entry_date'])) ?></small>
                            </td>
                            
                            <!-- Doctor -->
                            <td class="text-sm"><?= $task['doctor_name'] ?? 'Κ/Α' ?></td>
                            
                            <!-- Customer -->
                            <td>
                                <a href="javascript:void(0);" class="viewCustomerBtn font-weight-bold text-primary" 
                                   data-id="<?= $task['client'] ?>" title="Προβολή πελάτη">
                                    <?= $task['customer_name'] ?>
                                </a>
                                <?php if (!empty($task['phone_mobile'])): ?>
                                    <br><small class="text-muted">
                                        <i class="fas fa-mobile-alt"></i> <?= $task['phone_mobile'] ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Acoustics -->
                            <td class="text-sm">
                                <?php if (!empty($task['acoustic_serial'])): ?>
                                    <div class="mb-1">
                                        <span class="badge badge-info">1:</span>
                                        <a href="javascript:void(0);" class="viewAcousticBtn text-primary" 
                                           data-id="<?= $task['acoustic_id'] ?>">
                                            <?= $task['acoustic_serial'] ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($task['acoustic_serial_2'])): ?>
                                    <div>
                                        <span class="badge badge-info">2:</span>
                                        <a href="javascript:void(0);" class="viewAcousticBtn text-primary" 
                                           data-id="<?= $task['acoustic_id_2'] ?>">
                                            <?= $task['acoustic_serial_2'] ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if (empty($task['acoustic_serial']) && empty($task['acoustic_serial_2'])): ?>
                                    <small class="text-muted">Κ/Α ακουστικό</small>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Scan Checkbox -->
                            <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input updateCheckbox" 
                                           id="scan_<?= $task['id'] ?>" data-id="<?= $task['id'] ?>" 
                                           data-field="scan" <?= $task['scan'] ? 'checked' : '' ?>>
                                    <label class="custom-control-label" for="scan_<?= $task['id'] ?>">
                                        <i class="fas fa-camera <?= $task['scan'] ? 'text-success' : 'text-muted' ?>"></i>
                                    </label>
                                </div>
                            </td>
                            
                            <!-- Order Date -->
                            <td>
                                <input type="date" class="form-control form-control-sm updateDate" 
                                       data-id="<?= $task['id'] ?>" data-field="order" 
                                       value="<?= (!empty($task['order']) && $task['order'] != '0000-00-00') ? $task['order'] : '' ?>">
                            </td>
                            
                            <!-- Gnomateusi Checkbox -->
                            <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input updateCheckbox" 
                                           id="gnomateusi_<?= $task['id'] ?>" data-id="<?= $task['id'] ?>" 
                                           data-field="gnomateusi" <?= $task['gnomateusi'] ? 'checked' : '' ?>>
                                    <label class="custom-control-label" for="gnomateusi_<?= $task['id'] ?>">
                                        <i class="fas fa-user-md <?= $task['gnomateusi'] ? 'text-success' : 'text-muted' ?>"></i>
                                    </label>
                                </div>
                            </td>
                            
                            <!-- Receive Date -->
                            <td class="text-sm">
                                <?php if (!empty($task['receive']) && $task['receive'] != '0000-00-00'): ?>
                                    <span class="badge badge-success"><?= date('d/m/Y', strtotime($task['receive'])) ?></span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Εκκρεμεί</span>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Tel RDV Checkbox -->
                            <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input updateCheckbox" 
                                           id="tel_rdv_<?= $task['id'] ?>" data-id="<?= $task['id'] ?>" 
                                           data-field="tel_rdv" <?= $task['tel_rdv'] ? 'checked' : '' ?>>
                                    <label class="custom-control-label" for="tel_rdv_<?= $task['id'] ?>">
                                        <i class="fas fa-phone <?= $task['tel_rdv'] ? 'text-success' : 'text-muted' ?>"></i>
                                    </label>
                                </div>
                                <?php if ($task['tel_rdv'] && !empty($task['tel_rdv_timestamp'])): ?>
                                    <small class="d-block text-muted"><?= date('d/m/Y', strtotime($task['tel_rdv_timestamp'])) ?></small>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Ektelesi Checkbox -->
                            <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input updateCheckbox" 
                                           id="ektelesi_<?= $task['id'] ?>" data-id="<?= $task['id'] ?>" 
                                           data-field="ektelesi" <?= $task['ektelesi'] ? 'checked' : '' ?>>
                                    <label class="custom-control-label" for="ektelesi_<?= $task['id'] ?>">
                                        <i class="fas fa-cogs <?= $task['ektelesi'] ? 'text-success' : 'text-muted' ?>"></i>
                                    </label>
                                </div>
                            </td>
                            
                            <!-- Paradosi Date -->
                            <td class="text-sm">
                                <?php if (!empty($task['paradosi']) && $task['paradosi'] != '0000-00-00'): ?>
                                    <span class="badge badge-success"><?= date('d/m/Y', strtotime($task['paradosi'])) ?></span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Εκκρεμεί</span>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Signatures Checkbox -->
                            <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input updateCheckbox" 
                                           id="signatures_<?= $task['id'] ?>" data-id="<?= $task['id'] ?>" 
                                           data-field="signatures" <?= $task['signatures'] ? 'checked' : '' ?>>
                                    <label class="custom-control-label" for="signatures_<?= $task['id'] ?>">
                                        <i class="fas fa-signature <?= $task['signatures'] ? 'text-success' : 'text-muted' ?>"></i>
                                    </label>
                                </div>
                            </td>
                            
                            <!-- Receipt Checkbox -->
                            <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input updateCheckbox" 
                                           id="receipt_<?= $task['id'] ?>" data-id="<?= $task['id'] ?>" 
                                           data-field="receipt" <?= $task['receipt'] ? 'checked' : '' ?>>
                                    <label class="custom-control-label" for="receipt_<?= $task['id'] ?>">
                                        <i class="fas fa-receipt <?= $task['receipt'] ? 'text-success' : 'text-muted' ?>"></i>
                                    </label>
                                </div>
                            </td>
                            
                            <!-- Arxeio Checkbox -->
                            <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input updateCheckbox" 
                                           id="arxeio_<?= $task['id'] ?>" data-id="<?= $task['id'] ?>" 
                                           data-field="arxeio" <?= $task['arxeio'] ? 'checked' : '' ?>>
                                    <label class="custom-control-label" for="arxeio_<?= $task['id'] ?>">
                                        <i class="fas fa-archive <?= $task['arxeio'] ? 'text-success' : 'text-muted' ?>"></i>
                                    </label>
                                </div>
                            </td>
                            
                            <!-- Progress -->
                            <td>
                                <div class="progress mb-1" style="height: 10px;">
                                    <div class="progress-bar bg-<?= $progress_class ?>" role="progressbar" 
                                         style="width: <?= $progress ?>%" aria-valuenow="<?= $progress ?>" 
                                         aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small class="text-muted"><?= $progress ?>%</small>
                            </td>
                            
                            <!-- Actions -->
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary editTaskBtn" 
                                            data-id="<?= $task['id'] ?>" title="Επεξεργασία">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-info viewTaskBtn" 
                                            data-id="<?= $task['id'] ?>" title="Προβολή">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <?php if (!empty($task['comments'])): ?>
                                    <button type="button" class="btn btn-sm btn-outline-warning" 
                                            data-toggle="popover" data-content="<?= htmlspecialchars($task['comments']) ?>" 
                                            title="Σχόλια">
                                        <i class="fas fa-comment"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="16" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                                    <h5>Συγχαρητήρια!</h5>
                                    <p class="mb-0">Δεν υπάρχουν ανοιχτές εργασίες αυτή τη στιγμή.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal for viewing customer information -->
<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="customerModalLabel">
                    <i class="fas fa-user"></i> Πληροφορίες Πελάτη
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-primary">Όνομα:</label>
                            <p class="form-control-plaintext" id="customerName">-</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-primary">Τηλέφωνο Σταθερό:</label>
                            <p class="form-control-plaintext" id="customerPhoneHome">-</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-primary">Τηλέφωνο Κινητό:</label>
                            <p class="form-control-plaintext" id="customerPhoneMobile">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-primary">Διεύθυνση:</label>
                            <p class="form-control-plaintext" id="customerAddress">-</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-primary">Πόλη:</label>
                            <p class="form-control-plaintext" id="customerCity">-</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-primary">AMKA:</label>
                            <p class="form-control-plaintext" id="customerAmka">-</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" id="viewCustomerBtn">
                    <i class="fas fa-eye"></i> Προβολή Πελάτη
                </button>
                <button type="button" class="btn btn-primary" id="editCustomerBtn">
                    <i class="fas fa-edit"></i> Επεξεργασία
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Κλείσιμο
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for viewing acoustic information -->
<div class="modal fade" id="acousticModal" tabindex="-1" role="dialog" aria-labelledby="acousticModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="acousticModalLabel">
                    <i class="fas fa-headphones"></i> Πληροφορίες Ακουστικού
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-info">Serial Number:</label>
                            <p class="form-control-plaintext" id="acousticSerialNumber">-</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-info">Σειρά:</label>
                            <p class="form-control-plaintext" id="acousticSeries">-</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-info">Μοντέλο:</label>
                            <p class="form-control-plaintext" id="acousticModel">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-info">Κατασκευαστής:</label>
                            <p class="form-control-plaintext" id="acousticManufacturer">-</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-info">Barcode Εκτέλεσης:</label>
                            <p class="form-control-plaintext" id="acousticEkaptyCode">-</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-info">Γιατρός:</label>
                            <p class="form-control-plaintext" id="acousticDoctor">-</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info" id="viewAcousticBtn">
                    <i class="fas fa-eye"></i> Προβολή Ακουστικού
                </button>
                <button type="button" class="btn btn-info" id="editAcousticBtn">
                    <i class="fas fa-edit"></i> Επεξεργασία
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Κλείσιμο
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Wait for DOM and jQuery to be ready
document.addEventListener('DOMContentLoaded', function() {
    // Check if jQuery is loaded
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded!');
        return;
    }
    
    console.log('jQuery loaded, initializing modals...');
    
    // Initialize modal events with event delegation
    $(document).on('click', '.viewCustomerBtn', function(e) {
        e.preventDefault();
        console.log('Customer button clicked!'); // Debug line
        
        var clientId = $(this).data('id');
        console.log('Client ID:', clientId); // Debug line
        
        if (!clientId) {
            alert('Δεν βρέθηκε ID πελάτη');
            return;
        }
        
        // Show loading state
        $('#customerModal .modal-body').html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Φόρτωση δεδομένων...</p></div>');
        $('#customerModal').modal('show');

        // AJAX to get customer data
        $.ajax({
            url: '<?= base_url("admin/tasks/get_customer/") ?>' + clientId,
            method: 'GET',
            success: function(data) {
                try {
                    var customer = typeof data === 'string' ? JSON.parse(data) : data;
                    
                    // Restore modal content
                    $('#customerModal .modal-body').html(`
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-primary">Όνομα:</label>
                                    <p class="form-control-plaintext" id="customerName">-</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-primary">Τηλέφωνο Σταθερό:</label>
                                    <p class="form-control-plaintext" id="customerPhoneHome">-</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-primary">Τηλέφωνο Κινητό:</label>
                                    <p class="form-control-plaintext" id="customerPhoneMobile">-</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-primary">Διεύθυνση:</label>
                                    <p class="form-control-plaintext" id="customerAddress">-</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-primary">Πόλη:</label>
                                    <p class="form-control-plaintext" id="customerCity">-</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-primary">AMKA:</label>
                                    <p class="form-control-plaintext" id="customerAmka">-</p>
                                </div>
                            </div>
                        </div>
                    `);
                    
                    // Populate data
                    $('#customerName').text(customer.name || '-');
                    $('#customerPhoneHome').text(customer.phone_home || '-');
                    $('#customerPhoneMobile').text(customer.phone_mobile || '-');
                    $('#customerAddress').text(customer.address || '-');
                    $('#customerCity').text(customer.city || '-');
                    $('#customerAmka').text(customer.amka || '-');
                    
                    // Set button actions
                    $('#editCustomerBtn').off('click').on('click', function() {
                        window.location.href = '<?= base_url("admin/customers/edit/") ?>' + clientId;
                    });
                    $('#viewCustomerBtn').off('click').on('click', function() {
                        window.location.href = '<?= base_url("admin/customers/view/") ?>' + clientId;
                    });
                    
                } catch (error) {
                    console.error('Error parsing customer data:', error);
                    $('#customerModal .modal-body').html('<div class="alert alert-danger">Σφάλμα κατά την ανάλυση των δεδομένων.</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Customer AJAX error:', error);
                $('#customerModal .modal-body').html('<div class="alert alert-danger">Σφάλμα κατά τη φόρτωση των δεδομένων του πελάτη.</div>');
            }
        });
    });

    $(document).on('click', '.viewAcousticBtn', function(e) {
        e.preventDefault();
        console.log('Acoustic button clicked!'); // Debug line
        
        var acousticId = $(this).data('id');
        console.log('Acoustic ID:', acousticId); // Debug line
        
        // Check if acoustic ID exists
        if (!acousticId || acousticId === '0' || acousticId === '') {
            alert('Δεν υπάρχει ακουστικό για προβολή.');
            return;
        }
        
        // Show loading state
        $('#acousticModal .modal-body').html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Φόρτωση δεδομένων...</p></div>');
        $('#acousticModal').modal('show');

        // AJAX to get acoustic data
        $.ajax({
            url: '<?= base_url("admin/tasks/get_acoustic/") ?>' + acousticId,
            method: 'GET',
            success: function(data) {
                try {
                    var acoustic = typeof data === 'string' ? JSON.parse(data) : data;
                    
                    // Restore modal content
                    $('#acousticModal .modal-body').html(`
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-info">Serial Number:</label>
                                    <p class="form-control-plaintext" id="acousticSerialNumber">-</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-info">Σειρά:</label>
                                    <p class="form-control-plaintext" id="acousticSeries">-</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-info">Μοντέλο:</label>
                                    <p class="form-control-plaintext" id="acousticModel">-</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-info">Κατασκευαστής:</label>
                                    <p class="form-control-plaintext" id="acousticManufacturer">-</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-info">Barcode Εκτέλεσης:</label>
                                    <p class="form-control-plaintext" id="acousticEkaptyCode">-</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-info">Γιατρός:</label>
                                    <p class="form-control-plaintext" id="acousticDoctor">-</p>
                                </div>
                            </div>
                        </div>
                    `);
                    
                    // Populate data
                    $('#acousticSerialNumber').text(acoustic.serial || '-');
                    $('#acousticSeries').text(acoustic.series_name || '-');
                    $('#acousticModel').text(acoustic.model_name || '-');
                    $('#acousticManufacturer').text(acoustic.manufacturer_name || '-');
                    $('#acousticEkaptyCode').text(acoustic.ekapty_code || '-');
                    $('#acousticDoctor').text(acoustic.doctor_name || '-');
                    
                    // Set button actions
                    $('#editAcousticBtn').off('click').on('click', function() {
                        window.location.href = '<?= base_url("admin/stocks/edit/") ?>' + acousticId;
                    });
                    $('#viewAcousticBtn').off('click').on('click', function() {
                        window.location.href = '<?= base_url("admin/stocks/view/") ?>' + acousticId;
                    });
                    
                } catch (error) {
                    console.error('Error parsing acoustic data:', error);
                    $('#acousticModal .modal-body').html('<div class="alert alert-danger">Σφάλμα κατά την ανάλυση των δεδομένων.</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Acoustic AJAX error:', error);
                $('#acousticModal .modal-body').html('<div class="alert alert-danger">Σφάλμα κατά τη φόρτωση των δεδομένων του ακουστικού.</div>');
            }
        });
    });
}); // End of DOMContentLoaded

// Wait for jQuery to be available, then initialize DataTable
$(document).ready(function() {
    // Initialize DataTable
    $('#tasksTable').DataTable({
        "responsive": true,
        "order": [[ 0, "desc" ]], // Order by date descending
        "pageLength": 25,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Greek.json"
        },
        "columnDefs": [
            { "orderable": false, "targets": [4, 5, 6, 8, 9, 11, 12, 13, 15] }, // Disable sorting for checkboxes and actions
            { "searchable": false, "targets": [15] } // Disable search for actions column
        ]
    });

    // Initialize popovers for comments
    $('[data-toggle="popover"]').popover({
        trigger: 'hover',
        placement: 'top'
    });

    // Update checkbox handler
    $('.updateCheckbox').change(function() {
        var taskId = $(this).data('id');
        var field = $(this).data('field');
        var value = $(this).is(':checked') ? 1 : 0;
        
        console.log('Updating task:', taskId, 'field:', field, 'value:', value);
        
        $.ajax({
            url: '<?= base_url("admin/tasks/update_field") ?>',
            method: 'POST',
            data: {
                id: taskId,
                field: field,
                value: value
            },
            success: function(response) {
                console.log('Update response:', response);
                
                // Try to parse response if it's a string
                var parsedResponse = response;
                if (typeof response === 'string') {
                    try {
                        parsedResponse = JSON.parse(response);
                    } catch (e) {
                        console.error('Failed to parse response:', response);
                        alert('Σφάλμα: Μη έγκυρη απάντηση από τον server');
                        return;
                    }
                }
                
                if (parsedResponse.status === 'success') {
                    // Update icon color based on new state
                    var icon = $('label[for="' + field + '_' + taskId + '"] i');
                    if (value == 1) {
                        icon.removeClass('text-muted').addClass('text-success');
                    } else {
                        icon.removeClass('text-success').addClass('text-muted');
                    }
                    
                    // Notification sent - update notification counter if available
                    if (typeof loadNotificationCount === 'function') {
                        setTimeout(loadNotificationCount, 1000);
                    }
                    
                    // Refresh the page to update progress
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    console.error('Server returned error:', parsedResponse.message);
                    alert('Σφάλμα κατά την ενημέρωση: ' + (parsedResponse.message || 'Άγνωστο σφάλμα'));
                    // Revert checkbox state
                    $(this).prop('checked', !$(this).prop('checked'));
                }
            }.bind(this),
            error: function(xhr, status, error) {
                console.error('AJAX error:', xhr.responseText, status, error);
                alert('Σφάλμα κατά την ενημέρωση: ' + (xhr.responseText || error));
                // Revert checkbox state
                $(this).prop('checked', !$(this).prop('checked'));
            }.bind(this)
        });
    });

    // Update date handler
    $('.updateDate').change(function() {
        var taskId = $(this).data('id');
        var field = $(this).data('field');
        var value = $(this).val();
        
        $.ajax({
            url: '<?= base_url("admin/tasks/update_field") ?>',
            method: 'POST',
            data: {
                id: taskId,
                field: field,
                value: value
            },
            success: function(response) {
                // Notification sent - update notification counter if available
                if (typeof loadNotificationCount === 'function') {
                    setTimeout(loadNotificationCount, 1000);
                }
                
                // Refresh the page to update progress
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function() {
                alert('Σφάλμα κατά την ενημέρωση ημερομηνίας');
            }
        });
    });
});

// Export functions
function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename ? filename + '.xls' : 'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    } else {
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}

function exportTableToPDF() {
    window.print();
}
</script>

<style>
.text-sm {
    font-size: 0.875rem;
}

.progress {
    background-color: #e9ecef;
}

.custom-control-label::before {
    border-radius: 0.25rem;
}

@media print {
    .btn, .dropdown, #tasksTable_filter, #tasksTable_length, #tasksTable_info, #tasksTable_paginate {
        display: none !important;
    }
}
</style>
        


// Export functions
function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename ? filename + '.xls' : 'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    } else {
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}

function exportTableToPDF() {
    window.print();
}
</script>

<style>
.text-sm {
    font-size: 0.875rem;
}

.progress {
    background-color: #e9ecef;
}

.custom-control-label::before {
    border-radius: 0.25rem;
}

@media print {
    .btn, .dropdown, #tasksTable_filter, #tasksTable_length, #tasksTable_info, #tasksTable_paginate {
        display: none !important;
    }
}
</style>