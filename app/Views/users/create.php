<?= $this->extend('crud_templates/create') ?>

<?= $this->section('form_fields') ?>
<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Στοιχεία Λογαριασμού</h6>
            </div>
            <div class="card-body">
                <?= form_text('username', 'Username', '', 'required|is_unique[users.username]', 'Username πρέπει να είναι μοναδικό') ?>
                <?= form_email('email', 'Email', '', 'required|valid_email|is_unique[users.email]', 'Email πρέπει να είναι μοναδικό') ?>
                
                <div class="form-group">
                    <label for="password" class="form-label required">Κωδικός Πρόσβασης</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback"></div>
                    <small class="form-text text-muted">Ελάχιστο 8 χαρακτήρες</small>
                </div>

                <div class="form-group">
                    <label for="password_confirm" class="form-label required">Επιβεβαίωση Κωδικού</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label for="group_id" class="form-label required">Ομάδα Χρήστη</label>
                    <select class="form-control" id="group_id" name="group_id" required>
                        <option value="">Επιλέξτε Ομάδα...</option>
                        <?php foreach($groups as $group): ?>
                            <option value="<?= $group['id'] ?>" <?= set_select('group_id', $group['id']) ?>>
                                <?= esc($group['name']) ?> - <?= esc($group['description']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="active" name="active" value="1" <?= set_checkbox('active', '1', true) ?>>
                    <label class="form-check-label" for="active">
                        Ενεργός Χρήστης
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Προσωπικά Στοιχεία</h6>
            </div>
            <div class="card-body">
                <?= form_text('first_name', 'Όνομα', '', 'required') ?>
                <?= form_text('last_name', 'Επώνυμο', '', 'required') ?>
                <?= form_text('company', 'Εταιρεία') ?>
                <?= form_phone('phone', 'Τηλέφωνο') ?>
                
                <div class="form-group">
                    <label for="branch_id" class="form-label">Παράρτημα</label>
                    <select class="form-control" id="branch_id" name="branch_id">
                        <option value="">Επιλέξτε Παράρτημα...</option>
                        <?php foreach($branches as $branch): ?>
                            <option value="<?= $branch['id'] ?>" <?= set_select('branch_id', $branch['id']) ?>>
                                <?= esc($branch['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Πληροφορίες</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Σημείωση:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Το username και το email πρέπει να είναι μοναδικά</li>
                        <li>Ο κωδικός πρόσβασης θα κρυπτογραφηθεί αυτόματα</li>
                        <li>Η ομάδα καθορίζει τα δικαιώματα του χρήστη</li>
                        <li>Μόνο ενεργοί χρήστες μπορούν να συνδεθούν</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<script>
$(document).ready(function() {
    // Password confirmation validation
    $('#password_confirm').on('input', function() {
        var password = $('#password').val();
        var confirm = $(this).val();
        
        if (confirm && password !== confirm) {
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('Οι κωδικοί δεν ταιριάζουν');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Password strength indicator
    $('#password').on('input', function() {
        var password = $(this).val();
        var strength = checkPasswordStrength(password);
        
        if (password.length > 0 && password.length < 8) {
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('Ελάχιστο 8 χαρακτήρες');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
});

function checkPasswordStrength(password) {
    var strength = 0;
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]/)) strength++;
    if (password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;
    
    return strength;
}
</script>
<?= $this->endSection() ?>