<?= $this->extend('crud_templates/index') ?>

<?= $this->section('table_headers') ?>
<th>ID</th>
<th>Χρόνος</th>
<th>IP Διεύθυνση</th>
<th>Login</th>
<th>Χρήστης</th>
<th>Αποτέλεσμα</th>
<?= $this->endSection() ?>

<?= $this->section('datatable_columns') ?>
{ "data": "id", "name": "id" },
{ "data": "time", "name": "time" },
{ "data": "ip_address", "name": "ip_address" },
{ "data": "login", "name": "login" },
{ "data": "user_info", "name": "user_info", "orderable": false },
{ "data": "success", "name": "success", "orderable": false },
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Security Statistics Dashboard -->
<div class="stats-container mb-4">
    <!-- Statistics will be loaded here via AJAX -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Σύνολο Προσπαθειών</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-attempts">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sign-in-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Τελευταίες 24ώρες</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="recent-attempts">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Αποτυχημένες</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="failed-attempts">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Καθαρισμός</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <button class="btn btn-success btn-sm" onclick="showCleanupModal()">
                                    <i class="fas fa-broom"></i> Εκκαθάριση
                                </button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trash-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top IPs Section -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Κορυφαίες IP Διευθύνσεις</h6>
            </div>
            <div class="card-body">
                <div id="top-ips-list">
                    <p class="text-muted">Φόρτωση...</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Ασφάλεια</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-shield-alt"></i> Παρακολούθηση Ασφαλείας</h6>
                    <ul class="mb-0">
                        <li>Παρακολουθούνται όλες οι προσπάθειες σύνδεσης</li>
                        <li>Εντοπισμός ύποπτης δραστηριότητας</li>
                        <li>Ανάλυση IP διευθύνσεων</li>
                        <li>Ιστορικό επιτυχών/αποτυχημένων συνδέσεων</li>
                    </ul>
                </div>
                <button class="btn btn-outline-primary btn-sm" onclick="exportSecurityReport()">
                    <i class="fas fa-download"></i> Εξαγωγή Αναφοράς
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cleanup Modal -->
<div class="modal fade" id="cleanupModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Εκκαθάριση Παλιών Εγγραφών</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Διαγραφή προσπαθειών σύνδεσης παλαιότερων από:</p>
                <div class="form-group">
                    <select class="form-control" id="cleanup-days">
                        <option value="30">30 ημέρες</option>
                        <option value="60">60 ημέρες</option>
                        <option value="90" selected>90 ημέρες</option>
                        <option value="180">180 ημέρες</option>
                        <option value="365">1 χρόνο</option>
                    </select>
                </div>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Προσοχή:</strong> Αυτή η ενέργεια δεν μπορεί να αναιρεθεί!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ακύρωση</button>
                <button type="button" class="btn btn-danger" onclick="performCleanup()">Εκκαθάριση</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Load statistics
    loadSecurityStats();
    
    // Refresh stats every 30 seconds
    setInterval(loadSecurityStats, 30000);
});

function loadSecurityStats() {
    $.ajax({
        url: "<?= site_url('login-attempts/getStatistics') ?>",
        type: 'GET',
        success: function(response) {
            if (response) {
                $('#total-attempts').text(response.total_attempts || '0');
                $('#recent-attempts').text(response.recent_attempts || '0');
                $('#failed-attempts').text(response.failed_attempts || '0');
                
                // Update top IPs
                updateTopIPs(response.top_ips || []);
            }
        },
        error: function() {
            console.log('Could not load security statistics');
        }
    });
}

function updateTopIPs(topIps) {
    var html = '';
    if (topIps.length > 0) {
        topIps.forEach(function(ip, index) {
            html += '<div class="mb-2">';
            html += '<span class="badge badge-primary mr-2">' + (index + 1) + '</span>';
            html += '<strong>' + ip.ip_address + '</strong>';
            html += '<span class="badge badge-secondary ml-2">' + ip.count + ' προσπάθειες</span>';
            html += '</div>';
        });
    } else {
        html = '<p class="text-muted">Δεν υπάρχουν δεδομένα</p>';
    }
    $('#top-ips-list').html(html);
}

function showCleanupModal() {
    $('#cleanupModal').modal('show');
}

function performCleanup() {
    var days = $('#cleanup-days').val();
    
    $.ajax({
        url: "<?= site_url('login-attempts/cleanup') ?>",
        type: 'POST',
        data: {
            days: days,
            <?= csrf_token() ?>: "<?= csrf_hash() ?>"
        },
        success: function(response) {
            $('#cleanupModal').modal('hide');
            
            if (response.success) {
                showAlert('success', response.message);
                // Reload the table
                $('#dataTable').DataTable().ajax.reload();
                // Reload stats
                loadSecurityStats();
            } else {
                showAlert('error', response.message);
            }
        },
        error: function() {
            $('#cleanupModal').modal('hide');
            showAlert('error', 'Σφάλμα κατά την εκκαθάριση!');
        }
    });
}

function exportSecurityReport() {
    // Placeholder for export functionality
    showAlert('info', 'Η λειτουργία εξαγωγής αναφοράς θα υλοποιηθεί σύντομα');
}

function showAlert(type, message) {
    var alertClass = type === 'success' ? 'alert-success' : 
                     type === 'info' ? 'alert-info' : 'alert-danger';
    var icon = type === 'success' ? 'fa-check-circle' : 
               type === 'info' ? 'fa-info-circle' : 'fa-exclamation-triangle';
    
    var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
        '<i class="fas ' + icon + '"></i> ' + message +
        '<button type="button" class="close" data-dismiss="alert">' +
        '<span aria-hidden="true">&times;</span>' +
        '</button>' +
        '</div>';
    
    $('.card').first().before(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}
</script>

<?= $this->endSection() ?>