<?= $this->extend('crud_templates/show') ?>

<?= $this->section('show_content') ?>
<div class="row">
    <div class="col-md-8">
        <!-- Login Attempt Details -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Στοιχεία Προσπάθειας Σύνδεσης</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <!-- Attempt Status Icon -->
                        <div class="avatar-lg mb-3">
                            <?php 
                            $isSuccess = !empty($user);
                            $iconClass = $isSuccess ? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-danger';
                            $bgClass = $isSuccess ? 'bg-success' : 'bg-danger';
                            ?>
                            <div class="<?= $bgClass ?> rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="<?= $iconClass ?> fa-2x text-white"></i>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="mb-3">
                            <?php if($isSuccess): ?>
                                <span class="badge badge-success badge-pill px-3 py-2">
                                    <i class="fas fa-check"></i> Επιτυχής
                                </span>
                            <?php else: ?>
                                <span class="badge badge-danger badge-pill px-3 py-2">
                                    <i class="fas fa-times"></i> Αποτυχημένη
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="30%" class="font-weight-bold">ID Προσπάθειας:</td>
                                    <td>#<?= esc($record['id']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Χρόνος:</td>
                                    <td><?= date('d/m/Y H:i:s', $record['time']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">IP Διεύθυνση:</td>
                                    <td>
                                        <code><?= esc($record['ip_address']) ?></code>
                                        <br><small class="text-muted">
                                            <?php if(filter_var($record['ip_address'], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)): ?>
                                                Εξωτερική IP
                                            <?php else: ?>
                                                Τοπικό δίκτυο
                                            <?php endif; ?>
                                        </small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Login:</td>
                                    <td><strong><?= esc($record['login']) ?></strong></td>
                                </tr>
                                <?php if($user): ?>
                                <tr>
                                    <td class="font-weight-bold">Χρήστης:</td>
                                    <td>
                                        <?= esc($user['first_name'] . ' ' . $user['last_name']) ?>
                                        <br><small class="text-muted"><?= esc($user['email']) ?></small>
                                        <br>
                                        <a href="<?= site_url('users/show/' . $user['id']) ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-user"></i> Προβολή Χρήστη
                                        </a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Attempts from Same IP -->
        <?php if(!empty($related_ip_attempts)): ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">
                    Σχετικές Προσπάθειες από την ίδια IP
                    <span class="badge badge-warning"><?= count($related_ip_attempts) ?></span>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Χρόνος</th>
                                <th>Login</th>
                                <th>Αποτέλεσμα</th>
                                <th>Ενέργειες</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($related_ip_attempts as $attempt): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i:s', $attempt['time']) ?></td>
                                    <td><?= esc($attempt['login']) ?></td>
                                    <td>
                                        <?php
                                        // Simple heuristic for success
                                        $attemptSuccess = true; // You might want to improve this logic
                                        ?>
                                        <?php if($attemptSuccess): ?>
                                            <span class="badge badge-success">Επιτυχής</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Αποτυχημένη</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('login-attempts/show/' . $attempt['id']) ?>" 
                                           class="btn btn-info btn-xs">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Related Attempts from Same Login -->
        <?php if(!empty($related_login_attempts)): ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">
                    Σχετικές Προσπάθειες με το ίδιο Login
                    <span class="badge badge-info"><?= count($related_login_attempts) ?></span>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Χρόνος</th>
                                <th>IP Διεύθυνση</th>
                                <th>Αποτέλεσμα</th>
                                <th>Ενέργειες</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($related_login_attempts as $attempt): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i:s', $attempt['time']) ?></td>
                                    <td><code><?= esc($attempt['ip_address']) ?></code></td>
                                    <td>
                                        <?php
                                        // Simple heuristic for success
                                        $attemptSuccess = true; // You might want to improve this logic
                                        ?>
                                        <?php if($attemptSuccess): ?>
                                            <span class="badge badge-success">Επιτυχής</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Αποτυχημένη</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('login-attempts/show/' . $attempt['id']) ?>" 
                                           class="btn btn-info btn-xs">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <!-- Quick Statistics -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Στατιστικά</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="row no-gutters align-items-center mb-3">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                ID Προσπάθειας
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">#<?= $record['id'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fingerprint fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="small text-truncate">
                    <i class="fas fa-clock text-info"></i>
                    <strong>Χρόνος:</strong> <?= date('d/m/Y H:i:s', $record['time']) ?>
                </div>

                <div class="small text-truncate">
                    <i class="fas fa-globe text-secondary"></i>
                    <strong>IP:</strong> <?= esc($record['ip_address']) ?>
                </div>

                <?php if($user): ?>
                <div class="small text-truncate">
                    <i class="fas fa-user text-success"></i>
                    <strong>Χρήστης:</strong> <?= esc($user['username']) ?>
                </div>
                <?php endif; ?>

                <div class="small text-truncate">
                    <i class="fas fa-sign-in-alt text-primary"></i>
                    <strong>Login:</strong> <?= esc($record['login']) ?>
                </div>
            </div>
        </div>

        <!-- Security Analysis -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Ανάλυση Ασφαλείας</h6>
            </div>
            <div class="card-body">
                <?php
                $riskLevel = 'low';
                $riskMessage = 'Φυσιολογική δραστηριότητα';
                $riskColor = 'success';

                // Simple risk assessment
                if (!$user) {
                    $riskLevel = 'medium';
                    $riskMessage = 'Προσπάθεια με μη έγκυρο login';
                    $riskColor = 'warning';
                }

                if (!empty($related_ip_attempts) && count($related_ip_attempts) > 5) {
                    $riskLevel = 'high';
                    $riskMessage = 'Πολλές προσπάθειες από την ίδια IP';
                    $riskColor = 'danger';
                }
                ?>

                <div class="alert alert-<?= $riskColor ?>">
                    <h6>
                        <i class="fas fa-shield-alt"></i>
                        Επίπεδο Κινδύνου: 
                        <span class="text-uppercase"><?= $riskLevel ?></span>
                    </h6>
                    <p class="mb-0"><?= $riskMessage ?></p>
                </div>

                <div class="mt-3">
                    <h6 class="font-weight-bold">Πρόσθετες Πληροφορίες:</h6>
                    <ul class="small">
                        <li>Σχετικές προσπάθειες από IP: <?= count($related_ip_attempts ?? []) ?></li>
                        <li>Σχετικές προσπάθειες με login: <?= count($related_login_attempts ?? []) ?></li>
                        <li>Τύπος IP: 
                            <?php if(filter_var($record['ip_address'], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)): ?>
                                Εξωτερική
                            <?php else: ?>
                                Εσωτερική/Τοπική
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Ενέργειες</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= site_url('login-attempts') ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Επιστροφή στη Λίστα
                    </a>
                    
                    <?php if($user): ?>
                    <a href="<?= site_url('users/show/' . $user['id']) ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-user"></i> Προβολή Χρήστη
                    </a>
                    <?php endif; ?>
                    
                    <button onclick="filterByIP('<?= esc($record['ip_address']) ?>')" class="btn btn-info btn-sm">
                        <i class="fas fa-filter"></i> Φιλτράρισμα IP
                    </button>
                    
                    <button onclick="filterByLogin('<?= esc($record['login']) ?>')" class="btn btn-warning btn-sm">
                        <i class="fas fa-search"></i> Φιλτράρισμα Login
                    </button>

                    <hr class="my-2">

                    <button onclick="exportAttemptReport(<?= $record['id'] ?>)" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-download"></i> Εξαγωγή Αναφοράς
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<script>
function filterByIP(ip) {
    // Redirect to main page with IP filter
    window.location.href = "<?= site_url('login-attempts') ?>?filter_ip=" + encodeURIComponent(ip);
}

function filterByLogin(login) {
    // Redirect to main page with login filter
    window.location.href = "<?= site_url('login-attempts') ?>?filter_login=" + encodeURIComponent(login);
}

function exportAttemptReport(attemptId) {
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
    
    $('main').prepend(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}
</script>
<?= $this->endSection() ?>