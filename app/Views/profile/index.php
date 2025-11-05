<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user me-2"></i>
                    Στοιχεία Προφίλ
                </h6>
            </div>
            <div class="card-body">
                <?= form_open('profile', ['class' => 'user']) ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Όνομα Χρήστη</label>
                            <input type="text" class="form-control" id="username" value="<?= esc($user['username']) ?>" readonly>
                            <small class="form-text text-muted">Το όνομα χρήστη δεν μπορεί να αλλάξει</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="role" class="form-label">Ρόλος</label>
                            <input type="text" class="form-control" id="role" value="<?= esc($user['role']) ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="full_name" class="form-label">Πλήρες Όνομα</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" 
                           value="<?= old('full_name', $user['full_name']) ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?= old('email', $user['email']) ?>" required>
                </div>

                <hr>

                <h6 class="text-primary mb-3">
                    <i class="fas fa-lock me-2"></i>
                    Αλλαγή Κωδικού Πρόσβασης
                </h6>

                <div class="form-group mb-3">
                    <label for="current_password" class="form-label">Τρέχων Κωδικός</label>
                    <input type="password" class="form-control" id="current_password" name="current_password">
                    <small class="form-text text-muted">Αφήστε κενό αν δεν θέλετε να αλλάξετε τον κωδικό</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="new_password" class="form-label">Νέος Κωδικός</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="confirm_password" class="form-label">Επιβεβαίωση Νέου Κωδικού</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Ενημέρωση Προφίλ
                    </button>
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Επιστροφή
                    </a>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>
                    Πληροφορίες Λογαριασμού
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="fas fa-user-circle fa-5x text-gray-400"></i>
                </div>
                
                <div class="text-center">
                    <h5 class="mb-1"><?= esc($user['full_name']) ?></h5>
                    <p class="text-muted mb-2"><?= esc($user['role']) ?></p>
                    <small class="text-muted">
                        <i class="fas fa-envelope me-1"></i>
                        <?= esc($user['email']) ?>
                    </small>
                </div>

                <hr>

                <div class="small">
                    <div class="mb-2">
                        <strong>Τελευταία Σύνδεση:</strong><br>
                        <span class="text-muted">Σήμερα, <?= date('H:i') ?></span>
                    </div>
                    <div class="mb-2">
                        <strong>Κατάσταση:</strong><br>
                        <span class="badge bg-success">Ενεργός</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-shield-alt me-2"></i>
                    Ασφάλεια
                </h6>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-3">
                    Βεβαιωθείτε ότι ο λογαριασμός σας χρησιμοποιεί ασφαλή κωδικό πρόσβασης.
                </p>
                
                <div class="small">
                    <div class="mb-2">
                        <i class="fas fa-check text-success me-1"></i>
                        Κωδικός τουλάχιστον 6 χαρακτήρων
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-check text-success me-1"></i>
                        Έγκυρη διεύθυνση email
                    </div>
                </div>

                <a href="<?= base_url('settings/security') ?>" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-cog me-1"></i>
                    Ρυθμίσεις Ασφαλείας
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Password strength indicator
    $('#new_password').on('input', function() {
        var password = $(this).val();
        var strength = 0;
        
        if (password.length >= 6) strength += 1;
        if (password.match(/[a-z]/)) strength += 1;
        if (password.match(/[A-Z]/)) strength += 1;
        if (password.match(/[0-9]/)) strength += 1;
        if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
        
        var strengthText = '';
        var strengthClass = '';
        
        switch(strength) {
            case 0:
            case 1:
                strengthText = 'Πολύ Αδύναμος';
                strengthClass = 'text-danger';
                break;
            case 2:
                strengthText = 'Αδύναμος';
                strengthClass = 'text-warning';
                break;
            case 3:
                strengthText = 'Καλός';
                strengthClass = 'text-info';
                break;
            case 4:
            case 5:
                strengthText = 'Ισχυρός';
                strengthClass = 'text-success';
                break;
        }
        
        // Show strength indicator
        $('#password-strength').remove();
        if (password.length > 0) {
            $('#new_password').after('<small id="password-strength" class="form-text ' + strengthClass + '">' + strengthText + '</small>');
        }
    });
});
</script>
<?= $this->endSection() ?>