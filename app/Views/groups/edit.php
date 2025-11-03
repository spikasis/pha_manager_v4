<?= $this->extend('crud_templates/edit') ?>

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
                           value="<?= esc($record['name']) ?>" required>
                    <div class="invalid-feedback"></div>
                    <small class="form-text text-muted">Το όνομα της ομάδας πρέπει να είναι μοναδικό</small>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Περιγραφή</label>
                    <textarea class="form-control" id="description" name="description" 
                              rows="4" placeholder="Προαιρετική περιγραφή της ομάδας..."><?= esc($record['description']) ?></textarea>
                    <div class="invalid-feedback"></div>
                    <small class="form-text text-muted">Μέγιστο 255 χαρακτήρες</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Πληροφορίες Ομάδας</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td><?= esc($record['id']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Όνομα:</strong></td>
                        <td><span class="badge badge-primary"><?= esc($record['name']) ?></span></td>
                    </tr>
                    <?php if(isset($record['user_count'])): ?>
                    <tr>
                        <td><strong>Χρήστες:</strong></td>
                        <td>
                            <?php if($record['user_count'] > 0): ?>
                                <span class="badge badge-success"><?= $record['user_count'] ?> χρήστες</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Κενή ομάδα</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Προσοχή</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Σημαντικό:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Η αλλαγή του ονόματος ομάδας μπορεί να επηρεάσει τα δικαιώματα</li>
                        <li>Βεβαιωθείτε ότι το νέο όνομα είναι περιγραφικό</li>
                        <li>Οι χρήστες θα συνεχίσουν να ανήκουν στην ομάδα</li>
                    </ul>
                </div>
            </div>
        </div>

        <?php if(isset($record['user_count']) && $record['user_count'] > 0): ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Ενεργοί Χρήστες</h6>
            </div>
            <div class="card-body">
                <p class="text-success">
                    <i class="fas fa-users"></i>
                    Αυτή η ομάδα έχει <strong><?= $record['user_count'] ?></strong> 
                    <?= $record['user_count'] == 1 ? 'χρήστη' : 'χρήστες' ?>.
                </p>
                <a href="<?= site_url('groups/show/' . $record['id']) ?>" class="btn btn-sm btn-outline-success">
                    <i class="fas fa-eye"></i> Προβολή Χρηστών
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<script>
$(document).ready(function() {
    // Real-time validation for group name uniqueness (exclude current record)
    $('#name').on('blur', function() {
        var groupName = $(this).val();
        var currentName = '<?= esc($record['name']) ?>';
        
        if (groupName && groupName !== currentName) {
            checkGroupNameUnique(groupName, <?= $record['id'] ?>);
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

function checkGroupNameUnique(name, excludeId) {
    $.ajax({
        url: '<?= site_url('groups/checkUnique') ?>',
        type: 'POST',
        data: {
            field: 'name',
            value: name,
            id: excludeId,
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