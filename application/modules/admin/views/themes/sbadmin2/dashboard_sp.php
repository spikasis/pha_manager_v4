<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        Στοιχεία <?= isset($year_now) ? $year_now : date('Y') ?> - <?= isset($selling_point) ? $selling_point->city : 'Υποκατάστημα' ?>
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

<!-- Content Row -->
<div class="row">

    <!-- Sales Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Πωλήσεις Έτους</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($current_sales) ? number_format($current_sales) : '0' ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-euro-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Ανοιχτές Εργασίες</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($tasks) && is_array($tasks) ? count($tasks) : '0' ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tasks fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Ακουστικά σε Χρέωση</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($debt_count) ? number_format($debt_count) : '0' ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-headphones fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Μηνιαίος Τζίρος</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">€<?= isset($monthly_revenue) ? number_format($monthly_revenue, 2) : '0.00' ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row -->
<div class="row">

    <!-- Tasks List -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ανοιχτές Εργασίες</h6>
            </div>
            <div class="card-body">
                <?php if (isset($tasks) && !empty($tasks)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Πελάτης</th>
                                    <th>Εργασία</th>
                                    <th>Ημερομηνία</th>
                                    <th>Κατάσταση</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tasks as $task): ?>
                                <tr>
                                    <td><?= isset($task['customer_name']) ? $task['customer_name'] : 'Κ/Α' ?></td>
                                    <td><?= isset($task['description']) ? substr($task['description'], 0, 30) . '...' : 'Κ/Α' ?></td>
                                    <td><?= isset($task['created_at']) ? date('d/m/Y', strtotime($task['created_at'])) : 'Κ/Α' ?></td>
                                    <td>
                                        <span class="badge badge-warning">Ανοιχτή</span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Δεν υπάρχουν ανοιχτές εργασίες.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Γρήγορες Ενέργειες</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <a href="<?= base_url('admin/customers/create') ?>" class="btn btn-primary btn-block">
                            <i class="fas fa-user-plus"></i><br>
                            Νέος Πελάτης
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="<?= base_url('admin/stocks/create') ?>" class="btn btn-success btn-block">
                            <i class="fas fa-plus"></i><br>
                            Νέο Ακουστικό
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="<?= base_url('admin/services/create') ?>" class="btn btn-info btn-block">
                            <i class="fas fa-wrench"></i><br>
                            Νέα Επισκευή
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="<?= base_url('admin/tasks/create') ?>" class="btn btn-warning btn-block">
                            <i class="fas fa-clipboard-list"></i><br>
                            Νέα Εργασία
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Charts Row (για admin) -->
<?php if ($this->ion_auth->is_admin()): ?>
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Πωλήσεις Ανά Μήνα</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Κατανομή Προϊόντων</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="productsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- JavaScript -->
<script>
<?php if (isset($selling_points) && is_array($selling_points) && count($selling_points) > 1): ?>
function changeSellingPoint(id) {
    if (!id || isNaN(id)) return;
    const year = <?= json_encode(isset($year_now) ? $year_now : date('Y')) ?>;
    window.location.href = "<?= base_url('admin/dashboard/index') ?>?sp=" + id;
}
<?php endif; ?>

// Sample Charts (replace with actual data)
<?php if ($this->ion_auth->is_admin()): ?>
// Sales Chart
var ctx = document.getElementById("salesChart");
if (ctx) {
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Ιαν", "Φεβ", "Μαρ", "Απρ", "Μαϊ", "Ιουν", "Ιουλ", "Αυγ", "Σεπ", "Οκτ", "Νοε", "Δεκ"],
            datasets: [{
                label: "Πωλήσεις",
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                data: [0, 5, 3, 8, 6, 12, 8, 15, 12, 18, 14, 22],
            }],
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Products Chart
var ctx2 = document.getElementById("productsChart");
if (ctx2) {
    var productsChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ["Ακουστικά", "Επισκευές", "Αξεσουάρ"],
            datasets: [{
                data: [60, 25, 15],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
            }],
        },
        options: {
            maintainAspectRatio: false,
        },
    });
}
<?php endif; ?>
</script>