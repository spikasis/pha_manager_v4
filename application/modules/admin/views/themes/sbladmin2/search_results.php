<?php
// Search Results View - SB Admin 2
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-search"></i> Αποτελέσματα Αναζήτησης
        </h1>
        <?php if (!empty($query)): ?>
            <span class="text-muted">
                <i class="fas fa-quote-left"></i> <?= htmlspecialchars($query) ?> <i class="fas fa-quote-right"></i>
            </span>
        <?php endif; ?>
    </div>

    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <form method="GET" action="<?= base_url('admin/search') ?>" class="d-flex align-items-center">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control form-control-lg" 
                                   placeholder="Αναζήτηση πελατών, ακουστικών, serial numbers..." 
                                   value="<?= htmlspecialchars($query) ?>" autofocus>
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-lg" type="submit">
                                    <i class="fas fa-search"></i> Αναζήτηση
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <?php if (!empty($query)): ?>
                        <div class="mt-2">
                            <small class="text-muted">
                                Βρέθηκαν <strong><?= $total_results ?></strong> αποτελέσματα
                                <?php if ($total_results > 0): ?>
                                    · <strong><?= count($customers) ?></strong> πελάτες
                                    · <strong><?= count($stocks) ?></strong> ακουστικά
                                <?php endif; ?>
                            </small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($query)): ?>
        
        <?php if ($total_results == 0): ?>
            <!-- No Results -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-search fa-3x text-gray-300 mb-3"></i>
                            <h4 class="text-gray-600">Δεν βρέθηκαν αποτελέσματα</h4>
                            <p class="text-muted mb-4">
                                Δοκιμάστε διαφορετικούς όρους αναζήτησης ή ελέγξτε την ορθογραφία.
                            </p>
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">💡 Συμβουλές αναζήτησης:</h6>
                                            <ul class="list-unstyled mb-0 text-left">
                                                <li>• Δοκιμάστε με λιγότερες λέξεις</li>
                                                <li>• Αναζητήστε με όνομα πελάτη</li>
                                                <li>• Χρησιμοποιήστε serial number</li>
                                                <li>• Δοκιμάστε με τηλέφωνο</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <?php else: ?>
            
            <!-- Results Section -->
            <div class="row">
                
                <!-- Customers Results -->
                <?php if (!empty($customers)): ?>
                <div class="col-xl-6 col-lg-12 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-users"></i> Πελάτες
                            </h6>
                            <span class="badge badge-primary badge-pill">
                                <?= count($customers) ?>
                            </span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-0">Όνομα</th>
                                            <th class="border-0">Τηλέφωνο</th>
                                            <th class="border-0">Πόλη</th>
                                            <th class="border-0">Ενέργεια</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($customers as $customer): ?>
                                        <tr>
                                            <td>
                                                <div class="font-weight-bold text-dark">
                                                    <?= htmlspecialchars($customer['name']) ?>
                                                </div>
                                                <?php if (!empty($customer['first_visit'])): ?>
                                                    <small class="text-muted">
                                                        Πρώτη επίσκεψη: <?= date('d/m/Y', strtotime($customer['first_visit'])) ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div><?= htmlspecialchars($customer['phone_home']) ?></div>
                                                <?php if (!empty($customer['phone_mobile'])): ?>
                                                    <small class="text-muted"><?= htmlspecialchars($customer['phone_mobile']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-light">
                                                    <?= htmlspecialchars($customer['city']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?= $customer['view_url'] ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Προβολή
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Stocks Results -->
                <?php if (!empty($stocks)): ?>
                <div class="col-xl-6 col-lg-12 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-success">
                                <i class="fas fa-box"></i> Ακουστικά
                            </h6>
                            <span class="badge badge-success badge-pill">
                                <?= count($stocks) ?>
                            </span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-0">Serial</th>
                                            <th class="border-0">Πελάτης</th>
                                            <th class="border-0">Μοντέλο</th>
                                            <th class="border-0">Ενέργεια</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($stocks as $stock): ?>
                                        <tr>
                                            <td>
                                                <div class="font-weight-bold text-dark">
                                                    <?= htmlspecialchars($stock['serial']) ?>
                                                </div>
                                                <?php if (!empty($stock['day_in'])): ?>
                                                    <small class="text-muted">
                                                        Παραλαβή: <?= date('d/m/Y', strtotime($stock['day_in'])) ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div><?= htmlspecialchars($stock['customer_name']) ?></div>
                                                <?php if ($stock['status']): ?>
                                                    <small class="badge 
                                                        <?php 
                                                        switch($stock['status']) {
                                                            case 1: echo 'badge-warning'; break;
                                                            case 2: echo 'badge-info'; break;
                                                            case 3: echo 'badge-success'; break;
                                                            case 4: echo 'badge-primary'; break;
                                                            default: echo 'badge-secondary';
                                                        }
                                                        ?>">
                                                        Status <?= $stock['status'] ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="font-weight-bold">
                                                    <?= htmlspecialchars($stock['manufacturer_name']) ?>
                                                </div>
                                                <small class="text-muted">
                                                    <?= htmlspecialchars($stock['model_name']) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <a href="<?= $stock['view_url'] ?>" class="btn btn-sm btn-success">
                                                    <i class="fas fa-eye"></i> Προβολή
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            </div>

        <?php endif; ?>
        
    <?php else: ?>
        
        <!-- Welcome Search Screen -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-search fa-4x text-primary mb-4"></i>
                        <h3 class="text-gray-800 mb-3">Αναζήτηση στη Βάση Δεδομένων</h3>
                        <p class="text-muted mb-4 lead">
                            Βρείτε γρήγορα πελάτες, ακουστικά και άλλες πληροφορίες
                        </p>
                        
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-users fa-2x"></i>
                                                    <div class="ml-3">
                                                        <div class="font-weight-bold">Πελάτες</div>
                                                        <small>Όνομα, τηλέφωνο, διεύθυνση</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-success text-white">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-box fa-2x"></i>
                                                    <div class="ml-3">
                                                        <div class="font-weight-bold">Ακουστικά</div>
                                                        <small>Serial, μοντέλο, κατασκευαστής</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>
<!-- /.container-fluid -->