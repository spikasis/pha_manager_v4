<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Αρχική Σελίδα</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Εξαγωγή Αναφοράς
    </a>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Customers Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Συνολικοί Πελάτες</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($total_customers) ? number_format($total_customers) : '0' ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Διαθέσιμα Ακουστικά</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($available_stock) ? number_format($available_stock) : '0' ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-boxes fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Ανοιχτές Επισκευές</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= isset($open_services) ? number_format($open_services) : '0' ?></div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar" 
                                         style="width: <?= isset($services_progress) ? $services_progress : '0' ?>%" 
                                         aria-valuenow="<?= isset($services_progress) ? $services_progress : '0' ?>" 
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wrench fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Μηνιαίος Τζίρος</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">€<?= isset($monthly_revenue) ? number_format($monthly_revenue, 2) : '0.00' ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-euro-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row -->
<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Επισκόπηση Εσόδων</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Επιλογές:</div>
                        <a class="dropdown-item" href="#">Εξαγωγή PDF</a>
                        <a class="dropdown-item" href="#">Εξαγωγή Excel</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Κάτι άλλο εδώ</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Κατανομή Πωλήσεων</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Επιλογές:</div>
                        <a class="dropdown-item" href="#">Εξαγωγή PDF</a>
                        <a class="dropdown-item" href="#">Εξαγωγή Excel</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Κάτι άλλο εδώ</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> Ακουστικά
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Επισκευές
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-info"></i> Αξεσουάρ
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Recent Activity -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Πρόσφατη Δραστηριότητα</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php if (isset($recent_activities) && !empty($recent_activities)): ?>
                        <?php foreach ($recent_activities as $activity): ?>
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><?= $activity['title'] ?></h6>
                                <small><?= $activity['time'] ?></small>
                            </div>
                            <p class="mb-1"><?= $activity['description'] ?></p>
                            <small class="text-muted"><?= $activity['user'] ?></small>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="list-group-item">
                            <p class="mb-1 text-muted">Δεν υπάρχει πρόσφατη δραστηριότητα.</p>
                        </div>
                    <?php endif; ?>
                </div>
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
                        <a href="<?= base_url('admin/reports/daily') ?>" class="btn btn-warning btn-block">
                            <i class="fas fa-chart-line"></i><br>
                            Ημερήσια Αναφορά
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js Scripts will be loaded in footer, charts initialized after DOM ready -->

