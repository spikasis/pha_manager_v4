<?= $this->extend('crud_templates/edit') ?>

<?= $this->section('form_fields') ?>
<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Στοιχεία Λογαριασμού</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="username" class="form-label required">Username</label>
                    <input type="text" class="form-control" id="username" name="username" 
                           value="<?= esc($record['username']) ?>" required>
                    <div class="invalid-feedback"></div>
                    <small class="form-text text-muted">Username πρέπει να είναι μοναδικό</small>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label required">Email</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?= esc($record['email']) ?>" required>
                    <div class="invalid-feedback"></div>
                    <small class="form-text text-muted">Email πρέπει να είναι μοναδικό</small>
                </div>

                <div class="form-group">
                    <label for="group_id" class="form-label required">Ομάδα Χρήστη</label>
                    <select class="form-control" id="group_id" name="group_id" required>
                        <option value="">Επιλέξτε Ομάδα...</option>
                        <?php foreach($groups as $group): ?>
                            <option value="<?= $group['id'] ?>" 
                                    <?= ($group['id'] == $record['group_id']) ? 'selected' : '' ?>>
                                <?= esc($group['name']) ?> - <?= esc($group['description']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="active" name="active" 
                           value="1" <?= ($record['active']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="active">
                        Ενεργός Χρήστης
                    </label>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Αλλαγή Κωδικού</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Προσοχή:</strong> Συμπληρώστε μόνο αν θέλετε να αλλάξετε τον κωδικό
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Νέος Κωδικός</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <div class="invalid-feedback"></div>
                    <small class="form-text text-muted">Ελάχιστο 8 χαρακτήρες (αφήστε κενό για να μην αλλάξει)</small>
                </div>

                <div class="form-group">
                    <label for="password_confirm" class="form-label">Επιβεβαίωση Νέου Κωδικού</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm">
                    <div class="invalid-feedback"></div>
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
                <div class="form-group">
                    <label for="first_name" class="form-label required">Όνομα</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" 
                           value="<?= esc($record['first_name']) ?>" required>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label for="last_name" class="form-label required">Επώνυμο</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" 
                           value="<?= esc($record['last_name']) ?>" required>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label for="company" class="form-label">Εταιρεία</label>
                    <input type="text" class="form-control" id="company" name="company" 
                           value="<?= esc($record['company']) ?>">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Τηλέφωνο</label>
                    <input type="tel" class="form-control" id="phone" name="phone" 
                           value="<?= esc($record['phone']) ?>">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label for="branch_id" class="form-label">Παράρτημα</label>
                    <select class="form-control" id="branch_id" name="branch_id">
                        <option value="">Επιλέξτε Παράρτημα...</option>
                        <?php foreach($branches as $branch): ?>
                            <option value="<?= $branch['id'] ?>" 
                                    <?= ($branch['id'] == $record['branch_id']) ? 'selected' : '' ?>>
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
                <h6 class="m-0 font-weight-bold text-info">Πληροφορίες Χρήστη</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td><?= esc($record['id']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Δημιουργήθηκε:</strong></td>
                        <td><?= date('d/m/Y H:i', $record['created_on']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Τελευταία Ενημέρωση:</strong></td>
                        <td><?= $record['last_modified'] ? date('d/m/Y H:i', $record['last_modified']) : 'Ποτέ' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Τελευταία Σύνδεση:</strong></td>
                        <td><?= $record['last_login'] ? date('d/m/Y H:i', $record['last_login']) : 'Ποτέ' ?></td>
                    </tr>
                    <tr>
                        <td><strong>IP Τελευταίας Σύνδεσης:</strong></td>
                        <td><?= esc($record['ip_address']) ?: 'Άγνωστο' ?></td>
                    </tr>
                </table>
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
        
        if (password && confirm && password !== confirm) {
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('Οι κωδικοί δεν ταιριάζουν');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Password validation only if not empty
    $('#password').on('input', function() {
        var password = $(this).val();
        
        if (password && password.length < 8) {
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('Ελάχιστο 8 χαρακτήρες');
        } else {
            $(this).removeClass('is-invalid');
        }
        
        // Clear confirm field if password changes
        $('#password_confirm').val('').removeClass('is-invalid');
    });

    // Validate unique username (exclude current user)
    $('#username').on('blur', function() {
        var username = $(this).val();
        var currentUsername = '<?= esc($record['username']) ?>';
        
        if (username && username !== currentUsername) {
            $.ajax({
                url: '<?= site_url('users/checkUnique') ?>',
                type: 'POST',
                data: {
                    field: 'username',
                    value: username,
                    id: <?= $record['id'] ?>,
                    <?= csrf_token() ?>: "<?= csrf_hash() ?>"
                },
                success: function(response) {
                    if (!response.unique) {
                        $('#username').addClass('is-invalid');
                        $('#username').siblings('.invalid-feedback').text('Αυτό το username χρησιμοποιείται ήδη');
                    } else {
                        $('#username').removeClass('is-invalid');
                    }
                }
            });
        }
    });

    // Validate unique email (exclude current user)
    $('#email').on('blur', function() {
        var email = $(this).val();
        var currentEmail = '<?= esc($record['email']) ?>';
        
        if (email && email !== currentEmail) {
            $.ajax({
                url: '<?= site_url('users/checkUnique') ?>',
                type: 'POST',
                data: {
                    field: 'email',
                    value: email,
                    id: <?= $record['id'] ?>,
                    <?= csrf_token() ?>: "<?= csrf_hash() ?>"
                },
                success: function(response) {
                    if (!response.unique) {
                        $('#email').addClass('is-invalid');
                        $('#email').siblings('.invalid-feedback').text('Αυτό το email χρησιμοποιείται ήδη');
                    } else {
                        $('#email').removeClass('is-invalid');
                    }
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>