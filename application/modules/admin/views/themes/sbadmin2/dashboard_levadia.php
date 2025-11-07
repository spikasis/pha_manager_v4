<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        Στοιχεία <?= isset($year_now) ? $year_now : date('Y') ?> - Λιβαδειά
    </h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="window.print()">
        <i class="fas fa-download fa-sm text-white-50"></i> Εκτύπωση
    </a>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('message')): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('message') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Selling Point Selector (για Admin) -->
<?php if (isset($selling_points) && is_array($selling_points) && count($selling_points) > 1): ?>
<div class="row mb-4">
    <div class="col-lg-3 col-md-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <label for="selling_point" class="font-weight-bold text-info">Υποκατάστημα:</label>
                <select id="selling_point" name="selling_point" class="form-control" onchange="changeSellingPoint(this.value)">
                    <option value="">-- Επιλέξτε --</option>
                    <?php foreach ($selling_points as $sp): ?>
                        <option value="<?= $sp['id'] ?>" <?= ($sp['id'] == $selected_selling_point ? 'selected' : '') ?>>
                            <?= $sp['city'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Quick Actions Row -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= base_url('admin/customers/create') ?>" class="btn btn-primary btn-block shadow-sm py-4 text-decoration-none">
            <div class="text-center">
                <i class="fas fa-user-plus fa-2x mb-2"></i>
                <div class="font-weight-bold">Νέος Πελάτης</div>
            </div>
        </a>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= base_url('admin/stocks/create') ?>" class="btn btn-success btn-block shadow-sm py-4 text-decoration-none">
            <div class="text-center">
                <i class="fas fa-headphones fa-2x mb-2"></i>
                <div class="font-weight-bold">Νέο Ακουστικό</div>
            </div>
        </a>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= base_url('admin/services/create') ?>" class="btn btn-info btn-block shadow-sm py-4 text-decoration-none">
            <div class="text-center">
                <i class="fas fa-wrench fa-2x mb-2"></i>
                <div class="font-weight-bold">Νέα Επισκευή</div>
            </div>
        </a>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= base_url('admin/tasks/create') ?>" class="btn btn-warning btn-block shadow-sm py-4 text-decoration-none">
            <div class="text-center">
                <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                <div class="font-weight-bold">Νέα Εργασία</div>
            </div>
        </a>
    </div>
</div>

<!-- Tables Row -->
<div class="row">

    <!-- Ανοιχτές Εργασίες -->
    <div class="col-xl-4 col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-clipboard-list"></i> Ανοιχτές Εργασίες
                </h6>
                <span class="badge badge-warning badge-pill">
                    <?= isset($tasks) && is_array($tasks) ? count($tasks) : '0' ?>
                </span>
            </div>
            <div class="card-body p-0">
                <?php if (isset($tasks) && !empty($tasks)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">Πελάτης</th>
                                    <th class="border-0">Ημερομηνία</th>
                                    <th class="border-0">Κατάσταση</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($tasks, 0, 5) as $task): ?>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-dark">
                                            <?= isset($task['customer_name']) ? $task['customer_name'] : 'Κ/Α' ?>
                                        </div>
                                        <small class="text-muted">
                                            <?= isset($task['acoustic_serial']) ? 'S/N: ' . $task['acoustic_serial'] : '' ?>
                                        </small>
                                    </td>
                                    <td class="text-muted">
                                        <?= isset($task['created_at']) ? date('d/m/Y', strtotime($task['created_at'])) : 'Κ/Α' ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">Ενεργή</span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (count($tasks) > 5): ?>
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <a href="<?= base_url('admin/tasks') ?>" class="btn btn-sm btn-outline-warning">
                                            Προβολή όλων (<?= count($tasks) ?>)
                                        </a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="p-3 text-center text-muted">
                        <i class="fas fa-clipboard-list fa-2x mb-2 opacity-50"></i>
                        <p class="mb-0">Δεν υπάρχουν ανοιχτές εργασίες</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Ανοιχτές Κατασκευές -->
    <div class="col-xl-4 col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-flask"></i> Ανοιχτές Κατασκευές
                </h6>
                <span class="badge badge-info badge-pill">
                    <?= isset($moulds) && is_array($moulds) ? count($moulds) : '0' ?>
                </span>
            </div>
            <div class="card-body p-0">
                <?php if (isset($moulds) && !empty($moulds)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">Πελάτης</th>
                                    <th class="border-0">Παραγγελία</th>
                                    <th class="border-0">Κατάσταση</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($moulds, 0, 5) as $mould): ?>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-dark">
                                            <?= isset($mould['customer_name']) ? $mould['customer_name'] : 'Πελάτης #' . $mould['customer_id'] ?>
                                        </div>
                                    </td>
                                    <td class="text-muted">
                                        <?= isset($mould['date_order']) ? date('d/m/Y', strtotime($mould['date_order'])) : 'Κ/Α' ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">Κατασκευή</span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (count($moulds) > 5): ?>
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <a href="<?= base_url('admin/earlabs') ?>" class="btn btn-sm btn-outline-info">
                                            Προβολή όλων (<?= count($moulds) ?>)
                                        </a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="p-3 text-center text-muted">
                        <i class="fas fa-flask fa-2x mb-2 opacity-50"></i>
                        <p class="mb-0">Δεν υπάρχουν ανοιχτές κατασκευές</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Ακουστικά σε Εκκρεμότητα -->
    <div class="col-xl-4 col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-exclamation-triangle"></i> Ακουστικά Εκκρεμότητας
                </h6>
                <span class="badge badge-danger badge-pill">
                    <?= isset($stock_bc) && is_array($stock_bc) ? count($stock_bc) : '0' ?>
                </span>
            </div>
            <div class="card-body p-0">
                <?php if (isset($stock_bc) && !empty($stock_bc)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">Serial</th>
                                    <th class="border-0">Μοντέλο</th>
                                    <th class="border-0">Παραλαβή</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($stock_bc, 0, 5) as $stock): ?>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-dark">
                                            <?= isset($stock['serial']) ? $stock['serial'] : 'Κ/Α' ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted">
                                            <?= isset($stock['ha_model']) ? $stock['ha_model'] : 'Κ/Α' ?>
                                        </div>
                                        <small class="text-muted">
                                            <?= isset($stock['vendor']) ? $stock['vendor'] : '' ?>
                                        </small>
                                    </td>
                                    <td class="text-muted">
                                        <?= isset($stock['day_in']) ? date('d/m/Y', strtotime($stock['day_in'])) : 'Κ/Α' ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (count($stock_bc) > 5): ?>
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <a href="<?= base_url('admin/stocks') ?>" class="btn btn-sm btn-outline-danger">
                                            Προβολή όλων (<?= count($stock_bc) ?>)
                                        </a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="p-3 text-center text-muted">
                        <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                        <p class="mb-0">Όλα τα ακουστικά επεξεργάστηκαν</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>



<!-- JavaScript -->
<script>
<?php if (isset($selling_points) && is_array($selling_points) && count($selling_points) > 1): ?>
function changeSellingPoint(id) {
    if (!id || isNaN(id)) return;
    const year = <?= json_encode(isset($year_now) ? $year_now : date('Y')) ?>;
    window.location.href = "<?= base_url('admin/dashboard/index') ?>?sp=" + id;
}
<?php endif; ?>


</script>