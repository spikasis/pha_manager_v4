<?= $this->extend('crud_templates/show') ?>

<?= $this->section('show_content') ?>
<div class="row">
    <div class="col-md-8">
        <!-- Group Information -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Στοιχεία Ομάδας</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <a class="dropdown-item" href="<?= site_url('groups/edit/' . $record['id']) ?>">
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
                        <!-- Group Icon -->
                        <div class="avatar-lg mb-3">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-users fa-2x text-white"></i>
                            </div>
                        </div>
                        
                        <!-- Group Badge -->
                        <div class="mb-3">
                            <span class="badge badge-primary badge-pill px-3 py-2">
                                <?= esc($record['name']) ?>
                            </span>
                        </div>

                        <!-- Quick Actions -->
                        <div class="d-grid gap-2">
                            <a href="<?= site_url('groups/edit/' . $record['id']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Επεξεργασία
                            </a>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="30%" class="font-weight-bold">ID Ομάδας:</td>
                                    <td>#<?= esc($record['id']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Όνομα:</td>
                                    <td><?= esc($record['name']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Περιγραφή:</td>
                                    <td><?= esc($record['description']) ?: '<em class="text-muted">Δεν έχει καθοριστεί περιγραφή</em>' ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Αριθμός Χρηστών:</td>
                                    <td>
                                        <?php if(isset($record['user_count']) && $record['user_count'] > 0): ?>
                                            <span class="badge badge-success">
                                                <?= $record['user_count'] ?> 
                                                <?= $record['user_count'] == 1 ? 'χρήστης' : 'χρήστες' ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Κενή ομάδα</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php if(isset($record['permissions'])): ?>
                                <tr>
                                    <td class="font-weight-bold">Δικαιώματα:</td>
                                    <td>
                                        <?php foreach($record['permissions'] as $module => $perms): ?>
                                            <div class="mb-1">
                                                <span class="badge badge-info"><?= ucfirst($module) ?>:</span>
                                                <?php foreach($perms as $perm): ?>
                                                    <span class="badge badge-light"><?= $perm ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Group Users -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Χρήστες Ομάδας 
                    <?php if(isset($record['users'])): ?>
                        <span class="badge badge-primary"><?= count($record['users']) ?></span>
                    <?php endif; ?>
                </h6>
            </div>
            <div class="card-body">
                <?php if(isset($record['users']) && !empty($record['users'])): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Όνομα</th>
                                    <th>Email</th>
                                    <th>Κατάσταση</th>
                                    <th>Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($record['users'] as $user): ?>
                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td><?= esc($user['username']) ?></td>
                                        <td><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></td>
                                        <td>
                                            <a href="mailto:<?= esc($user['email']) ?>" class="text-primary">
                                                <?= esc($user['email']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php if($user['active']): ?>
                                                <span class="badge badge-success">Ενεργός</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Ανενεργός</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= site_url('users/show/' . $user['id']) ?>" 
                                               class="btn btn-info btn-sm" title="Προβολή Χρήστη">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= site_url('users/edit/' . $user['id']) ?>" 
                                               class="btn btn-warning btn-sm" title="Επεξεργασία Χρήστη">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-users fa-3x mb-3"></i>
                        <h5>Δεν υπάρχουν χρήστες σε αυτή την ομάδα</h5>
                        <p>Μπορείτε να προσθέσετε χρήστες επεξεργάζοντας τους χρήστες και επιλέγοντας αυτή την ομάδα.</p>
                        <a href="<?= site_url('users/create') ?>" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Δημιουργία Νέου Χρήστη
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Group Statistics -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Στατιστικά</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="row no-gutters align-items-center mb-3">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                ID Ομάδας
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">#<?= $record['id'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-id-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>

                <hr>

                <?php if(isset($record['user_count'])): ?>
                <div class="small text-truncate">
                    <i class="fas fa-users text-primary"></i>
                    <strong>Συνολικοί Χρήστες:</strong> <?= $record['user_count'] ?>
                </div>
                <?php endif; ?>

                <?php if(isset($record['users'])): ?>
                <?php 
                $activeUsers = array_filter($record['users'], function($user) { return $user['active']; });
                $inactiveUsers = count($record['users']) - count($activeUsers);
                ?>
                <div class="small text-truncate">
                    <i class="fas fa-user-check text-success"></i>
                    <strong>Ενεργοί Χρήστες:</strong> <?= count($activeUsers) ?>
                </div>
                <?php if($inactiveUsers > 0): ?>
                <div class="small text-truncate">
                    <i class="fas fa-user-slash text-warning"></i>
                    <strong>Ανενεργοί Χρήστες:</strong> <?= $inactiveUsers ?>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Actions -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Ενέργειες</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= site_url('groups/edit/' . $record['id']) ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Επεξεργασία Ομάδας
                    </a>
                    
                    <a href="<?= site_url('users/create') ?>?group_id=<?= $record['id'] ?>" class="btn btn-success btn-sm">
                        <i class="fas fa-user-plus"></i> Προσθήκη Χρήστη
                    </a>
                    
                    <a href="<?= site_url('users') ?>?group=<?= $record['id'] ?>" class="btn btn-info btn-sm">
                        <i class="fas fa-filter"></i> Φιλτράρισμα Χρηστών
                    </a>

                    <hr class="my-2">

                    <?php if(isset($record['user_count']) && $record['user_count'] == 0): ?>
                    <button onclick="confirmDelete(<?= $record['id'] ?>)" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Διαγραφή Ομάδας
                    </button>
                    <?php else: ?>
                    <div class="alert alert-warning p-2">
                        <small>
                            <i class="fas fa-exclamation-triangle"></i>
                            Δεν μπορείτε να διαγράψετε ομάδα με χρήστες
                        </small>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<script>
function confirmDelete(groupId) {
    if (confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτή την ομάδα;')) {
        window.location.href = "<?= site_url('groups/delete/') ?>" + groupId;
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