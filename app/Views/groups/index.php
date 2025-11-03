<?= $this->extend('crud_templates/index') ?>

<?= $this->section('table_headers') ?>
<th>ID</th>
<th>Όνομα Ομάδας</th>
<th>Περιγραφή</th>
<th>Χρήστες</th>
<?= $this->endSection() ?>

<?= $this->section('datatable_columns') ?>
{ "data": "id", "name": "id" },
{ "data": "name", "name": "name" },
{ "data": "description", "name": "description" },
{ "data": "user_count", "name": "user_count", "orderable": false },
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Additional scripts for group management -->
<script>
$(document).ready(function() {
    // Load group statistics
    loadGroupStats();
});

function loadGroupStats() {
    $.ajax({
        url: "<?= site_url('groups/getStatistics') ?>",
        type: 'GET',
        success: function(response) {
            if (response) {
                updateStatsDisplay(response);
            }
        },
        error: function() {
            console.log('Could not load group statistics');
        }
    });
}

function updateStatsDisplay(stats) {
    // Add statistics cards if they exist
    if ($('.stats-container').length) {
        $('.stats-container').html(`
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Σύνολο Ομάδων</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">${stats.total_groups}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                        Ομάδες με Χρήστες</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">${stats.total_groups - stats.empty_groups}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-check fa-2x text-gray-300"></i>
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
                                        Κενές Ομάδες</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">${stats.empty_groups}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-slash fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }
}

function showAlert(type, message) {
    var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    
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

<!-- Statistics container -->
<div class="stats-container mb-4">
    <!-- Statistics will be loaded here via AJAX -->
</div>

<?= $this->endSection() ?>