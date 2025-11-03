<?= $this->extend('crud_templates/index') ?>

<?= $this->section('table_headers') ?>
<th>ID</th>
<th>Username</th>
<th>Email</th>
<th>Όνομα</th>
<th>Εταιρεία</th>
<th>Τηλέφωνο</th>
<th>Κατάσταση</th>
<th>Τελευταία Σύνδεση</th>
<th>Εγγραφή</th>
<?= $this->endSection() ?>

<?= $this->section('datatable_columns') ?>
{ "data": "id", "name": "id" },
{ "data": "username", "name": "username" },
{ "data": "email", "name": "email" },
{ "data": "full_name", "name": "full_name" },
{ "data": "company", "name": "company" },
{ "data": "phone", "name": "phone" },
{ "data": "active", "name": "active", "orderable": false },
{ "data": "last_login", "name": "last_login" },
{ "data": "created_on", "name": "created_on" },
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Additional scripts for user management -->
<script>
function toggleUserActive(userId) {
    $.ajax({
        url: "<?= site_url('users/toggleActive/') ?>" + userId,
        type: 'POST',
        data: {
            <?= csrf_token() ?>: "<?= csrf_hash() ?>"
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                // Reload table
                $('#dataTable').DataTable().ajax.reload();
            } else {
                showAlert('error', response.message);
            }
        },
        error: function() {
            showAlert('error', 'Σφάλμα κατά την ενημέρωση της κατάστασης χρήστη!');
        }
    });
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
<?= $this->endSection() ?>