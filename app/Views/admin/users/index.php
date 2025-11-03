<?= $this->extend('templates/layout') ?>

<?= $this->section('content') ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-users-cog"></i> Διαχείριση Χρηστών
    </h1>
    <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Νέος Χρήστης</span>
    </a>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Users Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Χρήστες Συστήματος (<?= $total_users ?>)
        </h6>
    </div>
    <div class="card-body">
        <?php if (empty($users)): ?>
            <div class="text-center py-4">
                <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                <p class="text-gray-500">Δεν υπάρχουν χρήστες στο σύστημα.</p>
                <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary">
                    Δημιουργία Πρώτου Χρήστη
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Όνομα Χρήστη</th>
                            <th>Ονοματεπώνυμο</th>
                            <th>Email</th>
                            <th>Ρόλος</th>
                            <th>Κατάσταση</th>
                            <th>Τελευταία Σύνδεση</th>
                            <th>Ενέργειες</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= esc($user['id']) ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="img-profile rounded-circle mr-2" 
                                         src="https://via.placeholder.com/30x30/6c757d/ffffff?text=<?= substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1) ?>" 
                                         style="width: 30px; height: 30px;">
                                    <strong><?= esc($user['username']) ?></strong>
                                </div>
                            </td>
                            <td><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></td>
                            <td>
                                <a href="mailto:<?= esc($user['email']) ?>" class="text-decoration-none">
                                    <?= esc($user['email']) ?>
                                </a>
                            </td>
                            <td>
                                <span class="badge badge-<?= $user['group_name'] === 'admin' ? 'danger' : ($user['group_name'] === 'manager' ? 'warning' : 'info') ?>">
                                    <?= esc($user['group_description'] ?? $user['group_name']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($user['active']): ?>
                                    <span class="badge badge-success">Ενεργός</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Ανενεργός</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($user['last_login']): ?>
                                    <small class="text-muted">
                                        <?= format_user_last_login($user['last_login']) ?>
                                    </small>
                                <?php else: ?>
                                    <small class="text-muted">Ποτέ</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?= base_url('admin/users/' . $user['id']) ?>" 
                                       class="btn btn-info btn-sm" title="Προβολή">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/users/' . $user['id'] . '/edit') ?>" 
                                       class="btn btn-warning btn-sm" title="Επεξεργασία">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($user['id'] != current_user_id()): ?>
                                        <?php if ($user['active']): ?>
                                            <button class="btn btn-secondary btn-sm" 
                                                    onclick="deactivateUser(<?= $user['id'] ?>)" title="Απενεργοποίηση">
                                                <i class="fas fa-user-slash"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-success btn-sm" 
                                                    onclick="activateUser(<?= $user['id'] ?>)" title="Ενεργοποίηση">
                                                <i class="fas fa-user-check"></i>
                                            </button>
                                        <?php endif; ?>
                                        <button class="btn btn-danger btn-sm" 
                                                onclick="deleteUser(<?= $user['id'] ?>, '<?= esc($user['username']) ?>')" title="Διαγραφή">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Activate user
function activateUser(userId) {
    if (confirm('Είστε σίγουροι ότι θέλετε να ενεργοποιήσετε αυτόν τον χρήστη;')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('admin/users') ?>/' + userId + '/activate';
        document.body.appendChild(form);
        form.submit();
    }
}

// Deactivate user
function deactivateUser(userId) {
    if (confirm('Είστε σίγουροι ότι θέλετε να απενεργοποιήσετε αυτόν τον χρήστη;')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('admin/users') ?>/' + userId + '/deactivate';
        document.body.appendChild(form);
        form.submit();
    }
}

// Delete user
function deleteUser(userId, username) {
    if (confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε τον χρήστη "' + username + '"; Αυτή η ενέργεια δεν μπορεί να αναιρεθεί!')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('admin/users') ?>/' + userId;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Initialize DataTables
$(document).ready(function() {
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Greek.json"
        },
        "pageLength": 25,
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [7] }
        ]
    });
});
</script>

<?= $this->endSection() ?>