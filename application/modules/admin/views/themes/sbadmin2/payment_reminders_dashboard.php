<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-bell text-warning"></i> Υπενθυμίσεις Πληρωμών
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Αρχική</a></li>
            <li class="breadcrumb-item active">Υπενθυμίσεις</li>
        </ol>
    </div>

    <!-- Stats Cards Row -->
    <div class="row">
        
        <!-- Overdue 30+ Days -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Χρέη 30+ Ημερών
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count($overdue_30) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Urgent 60+ Days -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Επείγοντα 60+ Ημερών
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count($urgent_60) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fire fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Πρόσφατες Πληρωμές
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count($recent_activity) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Debt Amount -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Συνολικό Χρέος
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                €<?php
                                $total_debt = 0;
                                foreach ($overdue_30 as $debt) {
                                    $total_debt += $debt['debt_amount'];
                                }
                                echo number_format($total_debt, 2);
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-euro-sign fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overdue Payments DataTable -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-clock text-warning"></i> Χρέη σε Καθυστέρηση
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow">
                    <div class="dropdown-header">Φίλτρα:</div>
                    <a class="dropdown-item filter-days" href="#" data-days="30">30+ Ημέρες</a>
                    <a class="dropdown-item filter-days" href="#" data-days="60">60+ Ημέρες</a>
                    <a class="dropdown-item filter-days" href="#" data-days="90">90+ Ημέρες</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="overdueTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th><i class="fas fa-user"></i> Πελάτης</th>
                            <th><i class="fas fa-phone"></i> Τηλέφωνο</th>
                            <?php if ($user_group == 1): ?>
                            <th><i class="fas fa-store"></i> Υποκατάστημα</th>
                            <?php endif; ?>
                            <th><i class="fas fa-headphones"></i> Συσκευή</th>
                            <th><i class="fas fa-euro-sign"></i> Χρέος</th>
                            <th><i class="fas fa-calendar"></i> Καθυστέρηση</th>
                            <th><i class="fas fa-cogs"></i> Ενέργειες</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($overdue_30 as $debt): ?>
                        <tr class="<?= $debt['days_since_sold'] > 60 ? 'table-danger' : 'table-warning' ?>">
                            <td>
                                <strong><?= htmlspecialchars($debt['customer_name'] ?? 'Άγνωστος') ?></strong>
                                <br><small class="text-muted">ID: <?= $debt['customer_id'] ?></small>
                            </td>
                            <td>
                                <?php if ($debt['phone_mobile']): ?>
                                    <a href="tel:<?= $debt['phone_mobile'] ?>" class="text-success">
                                        <i class="fas fa-mobile-alt"></i> <?= $debt['phone_mobile'] ?>
                                    </a>
                                <?php elseif ($debt['phone_home']): ?>
                                    <a href="tel:<?= $debt['phone_home'] ?>" class="text-info">
                                        <i class="fas fa-phone"></i> <?= $debt['phone_home'] ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Δεν υπάρχει</span>
                                <?php endif; ?>
                            </td>
                            <?php if ($user_group == 1): ?>
                            <td>
                                <span class="badge badge-secondary">
                                    <?= htmlspecialchars($debt['selling_point_name'] ?? '-') ?>
                                </span>
                            </td>
                            <?php endif; ?>
                            <td>
                                <strong><?= htmlspecialchars($debt['serial'] ?? '-') ?></strong>
                                <br><small class="text-muted"><?= htmlspecialchars($debt['model'] ?? '-') ?></small>
                            </td>
                            <td>
                                <span class="badge badge-danger badge-lg">
                                    €<?= number_format($debt['debt_amount'], 2) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= $debt['days_since_sold'] > 60 ? 'badge-danger' : 'badge-warning' ?>">
                                    <?= $debt['days_since_sold'] ?> ημέρες
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <!-- View Customer -->
                                    <a href="<?= base_url('admin/customers/view/' . $debt['customer_id']) ?>" 
                                       class="btn btn-outline-primary btn-sm" title="Προβολή Πελάτη">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- New Payment -->
                                    <a href="<?= base_url('admin/pays/create_specific/' . $debt['customer_id'] . '?hearing_aid_id=' . $debt['stock_id']) ?>" 
                                       class="btn btn-outline-success btn-sm" title="Νέα Πληρωμή">
                                        <i class="fas fa-euro-sign"></i>
                                    </a>
                                    
                                    <!-- Send Reminder -->
                                    <button class="btn btn-outline-warning btn-sm send-reminder" 
                                            data-customer="<?= $debt['customer_id'] ?>" 
                                            data-stock="<?= $debt['stock_id'] ?>"
                                            data-name="<?= htmlspecialchars($debt['customer_name'] ?? 'Άγνωστος') ?>"
                                            title="Αποστολή Υπενθύμισης">
                                        <i class="fas fa-bell"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if ($user_group == 1 && $selling_point_counts): ?>
    <!-- Branch Summary Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-chart-bar"></i> Σύνοψη ανά Υποκατάστημα
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Υποκατάστημα</th>
                            <th>Πελάτες σε Καθυστέρηση</th>
                            <th>Συνολικό Χρέος</th>
                            <th>Ενέργειες</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($selling_point_counts as $branch): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($branch['selling_point_name'] ?? '-') ?></strong></td>
                            <td>
                                <span class="badge badge-warning">
                                    <?= $branch['overdue_customers'] ?> πελάτες
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-danger">
                                    €<?= number_format($branch['total_debt'], 2) ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/payment_reminders?branch=' . $branch['selling_point']) ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Λεπτομέρειες
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
<!-- /.container-fluid -->

<!-- Reminder Modal -->
<div class="modal fade" id="reminderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-bell text-warning"></i> Αποστολή Υπενθύμισης
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="reminderForm" method="POST" action="<?= base_url('admin/payment_reminders/send_reminder') ?>">
                <div class="modal-body">
                    <input type="hidden" id="reminder_customer_id" name="customer_id">
                    <input type="hidden" id="reminder_stock_id" name="stock_id">
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        Θα σταλεί υπενθύμιση στον πελάτη: <strong id="customer_name"></strong>
                    </div>
                    
                    <div class="form-group">
                        <label>Τύπος Υπενθύμισης:</label>
                        <select class="form-control" name="reminder_type">
                            <option value="standard">Τυπική Υπενθύμιση</option>
                            <option value="urgent">Επείγουσα</option>
                            <option value="final">Τελική Προειδοποίηση</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ακύρωση</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-paper-plane"></i> Αποστολή Υπενθύμισης
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#overdueTable').DataTable({
        "language": {
            "url": "<?= base_url('assets/admin/vendor/datatables/Greek.json') ?>"
        },
        "order": [[ <?= $user_group == 1 ? '5' : '4' ?>, "desc" ]],
        "pageLength": 25,
        "responsive": true
    });

    // Filter by days
    $('.filter-days').on('click', function(e) {
        e.preventDefault();
        var days = $(this).data('days');
        // You can implement AJAX filtering here
        location.reload();
    });

    // Send reminder
    $('.send-reminder').on('click', function() {
        var customerId = $(this).data('customer');
        var stockId = $(this).data('stock');
        var customerName = $(this).data('name');
        
        $('#reminder_customer_id').val(customerId);
        $('#reminder_stock_id').val(stockId);
        $('#customer_name').text(customerName);
        
        $('#reminderModal').modal('show');
    });

    // Auto-refresh every 5 minutes
    setInterval(function() {
        table.ajax.reload(null, false);
    }, 300000);
});
</script>