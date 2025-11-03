<?= $this->extend('crud_templates/create') ?>

<?= $this->section('form_fields') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Στοιχεία Ομάδας</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="form-label required">Όνομα Ομάδας</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="<?= set_value('name') ?>" required>
                    <div class="invalid-feedback"></div>
                    <small class="form-text text-muted">Το όνομα της ομάδας πρέπει να είναι μοναδικό</small>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Περιγραφή</label>
                    <textarea class="form-control" id="description" name="description" 
                              rows="4" placeholder="Προαιρετική περιγραφή της ομάδας..."><?= set_value('description') ?></textarea>
                    <div class="invalid-feedback"></div>
                    <small class="form-text text-muted">Μέγιστο 255 χαρακτήρες</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Οδηγίες</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Πληροφορίες:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Το όνομα της ομάδας πρέπει να είναι μοναδικό</li>
                        <li>Η περιγραφή βοηθά στην κατανόηση του σκοπού της ομάδας</li>
                        <li>Μετά τη δημιουργία, μπορείτε να ανατεθούν χρήστες στην ομάδα</li>
                        <li>Οι ομάδες καθορίζουν τα δικαιώματα πρόσβασης</li>
                    </ul>
                </div>

                <hr>

                <h6 class="font-weight-bold">Προτεινόμενες Ομάδες:</h6>
                <div class="mb-2">
                    <span class="badge badge-dark">admin</span> - Διαχειριστές
                </div>
                <div class="mb-2">
                    <span class="badge badge-primary">manager</span> - Διευθυντές
                </div>
                <div class="mb-2">
                    <span class="badge badge-success">employee</span> - Υπάλληλοι
                </div>
                <div class="mb-2">
                    <span class="badge badge-secondary">members</span> - Μέλη
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Δικαιώματα</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">
                    Τα δικαιώματα κάθε ομάδας καθορίζονται από το σύστημα με βάση το όνομά της:
                </p>
                <ul class="small text-muted">
                    <li><strong>admin:</strong> Πλήρη δικαιώματα</li>
                    <li><strong>manager:</strong> Δικαιώματα διαχείρισης</li>
                    <li><strong>employee:</strong> Βασικά δικαιώματα εργασίας</li>
                    <li><strong>members:</strong> Δικαιώματα ανάγνωσης</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<script>
$(document).ready(function() {
    // Real-time validation for group name uniqueness
    $('#name').on('blur', function() {
        var groupName = $(this).val();
        
        if (groupName) {
            checkGroupNameUnique(groupName);
        }
    });

    // Character count for description
    $('#description').on('input', function() {
        var length = $(this).val().length;
        var maxLength = 255;
        var remaining = maxLength - length;
        
        var helpText = $(this).siblings('.form-text');
        if (remaining < 50) {
            helpText.text('Απομένουν ' + remaining + ' χαρακτήρες');
            if (remaining < 0) {
                helpText.addClass('text-danger');
                $(this).addClass('is-invalid');
            } else {
                helpText.removeClass('text-danger').addClass('text-warning');
                $(this).removeClass('is-invalid');
            }
        } else {
            helpText.text('Μέγιστο 255 χαρακτήρες');
            helpText.removeClass('text-danger text-warning');
            $(this).removeClass('is-invalid');
        }
    });
});

function checkGroupNameUnique(name) {
    $.ajax({
        url: '<?= site_url('groups/checkUnique') ?>',
        type: 'POST',
        data: {
            field: 'name',
            value: name,
            <?= csrf_token() ?>: "<?= csrf_hash() ?>"
        },
        success: function(response) {
            if (!response.unique) {
                $('#name').addClass('is-invalid');
                $('#name').siblings('.invalid-feedback').text('Αυτό το όνομα ομάδας χρησιμοποιείται ήδη');
            } else {
                $('#name').removeClass('is-invalid');
                $('#name').siblings('.invalid-feedback').text('');
            }
        },
        error: function() {
            console.log('Could not validate group name uniqueness');
        }
    });
}
</script>
<?= $this->endSection() ?>