<?= $this->extend('crud_templates/show') ?>

<?= $this->section('show_content') ?>
<div class="row">
    <div class="col-md-8">
        <!-- User Profile Information -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Προφίλ Χρήστη</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <a class="dropdown-item" href="<?= site_url('users/edit/' . $record['id']) ?>">
                            <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                            Επεξεργασία
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#" onclick="confirmDelete(<?= $record['id'] ?>)">
                            <i class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i>
                            Διαγραφή
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <!-- User Avatar -->
                        <div class="avatar-lg mb-3">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <span class="text-white h2 mb-0">
                                    <?= strtoupper(substr($record['first_name'], 0, 1) . substr($record['last_name'], 0, 1)) ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="mb-3">
                            <?php if($record['active']): ?>
                                <span class="badge badge-success badge-pill">
                                    <i class="fas fa-check-circle"></i> Ενεργός
                                </span>
                            <?php else: ?>
                                <span class="badge badge-danger badge-pill">
                                    <i class="fas fa-times-circle"></i> Ανενεργός
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <button class="btn btn-sm btn-outline-primary" onclick="toggleUserActive(<?= $record['id'] ?>)">
                                <i class="fas fa-power-off"></i> 
                                <?= $record['active'] ? 'Απενεργοποίηση' : 'Ενεργοποίηση' ?>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="30%" class="font-weight-bold">Πλήρες Όνομα:</td>
                                    <td><?= esc($record['first_name'] . ' ' . $record['last_name']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Username:</td>
                                    <td><?= esc($record['username']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Email:</td>
                                    <td>
                                        <a href="mailto:<?= esc($record['email']) ?>" class="text-primary">
                                            <?= esc($record['email']) ?>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Εταιρεία:</td>
                                    <td><?= esc($record['company']) ?: '<em class="text-muted">Δεν έχει καθοριστεί</em>' ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Τηλέφωνο:</td>
                                    <td>
                                        <?php if($record['phone']): ?>
                                            <a href="tel:<?= esc($record['phone']) ?>" class="text-primary">
                                                <?= esc($record['phone']) ?>
                                            </a>
                                        <?php else: ?>
                                            <em class="text-muted">Δεν έχει καθοριστεί</em>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Ομάδα:</td>
                                    <td>
                                        <?php if(isset($record['group_name'])): ?>
                                            <span class="badge badge-info">
                                                <?= esc($record['group_name']) ?>
                                            </span>
                                        <?php else: ?>
                                            <em class="text-muted">Δεν έχει ανατεθεί ομάδα</em>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Παράρτημα:</td>
                                    <td>
                                        <?php if(isset($record['branch_name'])): ?>
                                            <span class="badge badge-secondary">
                                                <?= esc($record['branch_name']) ?>
                                            </span>
                                        <?php else: ?>
                                            <em class="text-muted">Δεν έχει ανατεθεί παράρτημα</em>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Πρόσφατη Δραστηριότητα</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Ημερομηνία</th>
                                <th>IP Διεύθυνση</th>
                                <th>Δραστηριότητα</th>
                                <th>Αποτέλεσμα</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($loginAttempts)): ?>
                                <?php foreach($loginAttempts as $attempt): ?>
                                    <tr>
                                        <td><?= date('d/m/Y H:i:s', strtotime($attempt['time'])) ?></td>
                                        <td><?= esc($attempt['ip_address']) ?></td>
                                        <td>Προσπάθεια Σύνδεσης</td>
                                        <td>
                                            <?php if($attempt['login']): ?>
                                                <span class="badge badge-success">Επιτυχής</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Αποτυχημένη</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        Δεν υπάρχουν καταγεγραμμένες δραστηριότητες
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Account Statistics -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Στατιστικά Λογαριασμού</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="row no-gutters align-items-center mb-3">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                ID Χρήστη
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">#<?= $record['id'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="small text-truncate">
                    <i class="fas fa-calendar-plus text-success"></i>
                    <strong>Δημιουργία:</strong> <?= date('d/m/Y H:i', $record['created_on']) ?>
                </div>

                <?php if($record['last_modified']): ?>
                <div class="small text-truncate">
                    <i class="fas fa-edit text-warning"></i>
                    <strong>Τελευταία Ενημέρωση:</strong> <?= date('d/m/Y H:i', $record['last_modified']) ?>
                </div>
                <?php endif; ?>

                <?php if($record['last_login']): ?>
                <div class="small text-truncate">
                    <i class="fas fa-sign-in-alt text-info"></i>
                    <strong>Τελευταία Σύνδεση:</strong> <?= date('d/m/Y H:i', $record['last_login']) ?>
                </div>
                <?php endif; ?>

                <?php if($record['ip_address']): ?>
                <div class="small text-truncate">
                    <i class="fas fa-map-marker-alt text-secondary"></i>
                    <strong>IP Διεύθυνση:</strong> <?= esc($record['ip_address']) ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Security Information -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Ασφάλεια</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <?php
                    $daysSinceLastLogin = $record['last_login'] ? 
                        floor((time() - $record['last_login']) / (60 * 60 * 24)) : null;
                    ?>

                    <?php if($daysSinceLastLogin === null): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Προσοχή:</strong> Ο χρήστης δεν έχει συνδεθεί ποτέ
                        </div>
                    <?php elseif($daysSinceLastLogin > 30): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Πληροφορία:</strong> Αδρανής για <?= $daysSinceLastLogin ?> ημέρες
                        </div>
                    <?php elseif($daysSinceLastLogin > 90): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Προσοχή:</strong> Πολύ αδρανής χρήστης (<?= $daysSinceLastLogin ?> ημέρες)
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <strong>Ενεργός χρήστης</strong>
                        </div>
                    <?php endif; ?>

                    <div class="mt-3">
                        <a href="<?= site_url('users/edit/' . $record['id']) ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Επεξεργασία
                        </a>
                        <button onclick="resetPassword(<?= $record['id'] ?>)" class="btn btn-warning btn-sm">
                            <i class="fas fa-key"></i> Reset Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
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
                // Reload page to show updated status
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                showAlert('error', response.message);
            }
        },
        error: function() {
            showAlert('error', 'Σφάλμα κατά την ενημέρωση της κατάστασης χρήστη!');
        }
    });
}

function resetPassword(userId) {
    if (confirm('Είστε σίγουροι ότι θέλετε να κάνετε reset τον κωδικό του χρήστη;')) {
        $.ajax({
            url: "<?= site_url('users/resetPassword/') ?>" + userId,
            type: 'POST',
            data: {
                <?= csrf_token() ?>: "<?= csrf_hash() ?>"
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', 'Ο κωδικός έχει επαναφερθεί. Νέος κωδικός: ' + response.newPassword);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function() {
                showAlert('error', 'Σφάλμα κατά την επαναφορά του κωδικού!');
            }
        });
    }
}

function confirmDelete(userId) {
    if (confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτόν τον χρήστη;')) {
        window.location.href = "<?= site_url('users/delete/') ?>" + userId;
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
    
    $('main').prepend(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}
</script>
<?= $this->endSection() ?>