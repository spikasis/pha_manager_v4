<?php
// Modern Dashboard για Υποκαταστήματα - SB Admin 2
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt"></i> Dashboard - <?php echo isset($selling_point->city) ? $selling_point->city : 'Υποκατάστημα' ?>
        </h1>
        <span class="text-muted">
            <i class="fas fa-calendar-alt"></i> <?php echo $year_now ?>
        </span>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle"></i>
            <?= $this->session->flashdata('message') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Quick Action Buttons -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-rocket"></i> Γρήγορες Ενέργειες
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-2">
                            <a href="<?= base_url('admin/tasks/create') ?>" class="btn btn-primary btn-block">
                                <i class="fas fa-plus-circle"></i> Νέα Εργασία
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-2">
                            <a href="<?= base_url('admin/customers/create') ?>" class="btn btn-success btn-block">
                                <i class="fas fa-user-plus"></i> Νέος Πελάτης
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-2">
                            <a href="<?= base_url('admin/stock/create') ?>" class="btn btn-info btn-block">
                                <i class="fas fa-box"></i> Νέο Ακουστικό
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-2">
                            <a href="<?= base_url('admin/services/create') ?>" class="btn btn-warning btn-block">
                                <i class="fas fa-tools"></i> Νέα Επισκευή
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Tables -->
    <div class="row">

        <!-- Ανοιχτές Εργασίες -->
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card shadow h-100">
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
                                        <th class="border-0">Πρόοδος</th>
                                        <th class="border-0">Ενέργεια</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($tasks, 0, 5) as $task): ?>
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold text-dark">
                                                <?= isset($task['customer_name']) ? $task['customer_name'] : 'Πελάτης #' . $task['client'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-warning" role="progressbar" 
                                                     style="width: <?= isset($task['progress']) ? $task['progress'] : 0 ?>%"
                                                     aria-valuenow="<?= isset($task['progress']) ? $task['progress'] : 0 ?>" 
                                                     aria-valuemin="0" aria-valuemax="100">
                                                    <?= isset($task['progress']) ? round($task['progress']) : 0 ?>%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/customers/view/' . $task['client']) ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
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
            <div class="card shadow h-100">
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
                                        <th class="border-0">Ενέργεια</th>
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
                                            <a href="<?= base_url('admin/earlabs/edit/' . $mould['id']) ?>" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if (count($moulds) > 5): ?>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <a href="<?= base_url('admin/earlabs/list_open') ?>" class="btn btn-sm btn-outline-info">
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

        <!-- Ανοιχτές Επισκευές -->
        <div class="col-xl-4 col-lg-12 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-tools"></i> Ανοιχτές Επισκευές
                    </h6>
                    <span class="badge badge-danger badge-pill">
                        <?= isset($services) && is_array($services) ? count($services) : '0' ?>
                    </span>
                </div>
                <div class="card-body p-0">
                    <?php if (isset($services) && !empty($services)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0">Ακουστικό</th>
                                        <th class="border-0">Παραλαβή</th>
                                        <th class="border-0">Ενέργεια</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($services, 0, 5) as $service): ?>
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold text-dark" 
                                                 data-toggle="tooltip" data-placement="top" 
                                                 title="Πελάτης: <?= isset($service['customer']) ? htmlspecialchars($service['customer']) : 'Κ/Α' ?>">
                                                <?php if (isset($service['ha_serial']) && !empty($service['ha_serial'])): ?>
                                                    <?= $service['ha_serial'] ?>
                                                <?php else: ?>
                                                    #<?= isset($service['ha_service']) ? $service['ha_service'] : 'Κ/Α' ?>
                                                <?php endif; ?>
                                            </div>
                                            <?php if (isset($service['ha_model_name']) && !empty($service['ha_model_name'])): ?>
                                                <small class="text-muted"><?= $service['ha_model_name'] ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-muted">
                                            <?= isset($service['day_in']) ? date('d/m/Y', strtotime($service['day_in'])) : 'Κ/Α' ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/services/edit/' . $service['id']) ?>" 
                                               class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if (count($services) > 5): ?>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <a href="<?= base_url('admin/services') ?>" class="btn btn-sm btn-outline-danger">
                                                Προβολή όλων (<?= count($services) ?>)
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
                            <p class="mb-0">Όλες οι επισκευές ολοκληρώθηκαν</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->

<script>
$(document).ready(function() {
    // Ενεργοποίηση tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
