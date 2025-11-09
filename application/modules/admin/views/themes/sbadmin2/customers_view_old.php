<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Print Header (visible only when printing) -->
    <div class="d-print-block d-none mb-4 text-center">
        <div class="row">
            <div class="col-4">
                <img src="<?= base_url('images/logo_pha.png') ?>" style="height: 80px" alt="PHA Logo">
            </div>
            <div class="col-8">
                <h2 class="text-primary font-weight-bold">ΚΑΡΤΕΛΑ ΠΕΛΑΤΗ</h2>
                <h4 class="text-secondary"><?= $customer->name ?></h4>
            </div>
        </div>
        <hr>
    </div>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 d-print-none">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-circle text-primary"></i> Καρτέλα Πελάτη: <?= $customer->name ?>
        </h1>
        <div>
            <a href="<?= base_url('admin/tasks/create?customer_id=' . $customer->id) ?>" class="btn btn-primary shadow-sm mr-2">
                <i class="fas fa-tasks fa-sm text-white-50"></i> New Task
            </a>
            <a href="<?= base_url('admin/pays/create_specific/' . $customer->id) ?>" class="btn btn-info shadow-sm mr-2">
                <i class="fas fa-money-bill-wave fa-sm text-white-50"></i> Νέα Πληρωμή
            </a>
            <a href="<?= base_url('admin/pays?customer_id=' . $customer->id) ?>" class="btn btn-outline-info shadow-sm mr-2">
                <i class="fas fa-history fa-sm"></i> Ιστορικό Πληρωμών
            </a>
            <button onclick="window.print()" class="btn btn-success shadow-sm mr-2">
                <i class="fas fa-print fa-sm text-white-50"></i> Εκτύπωση
            </button>
            <a href="<?= base_url('admin/customers/edit/' . $customer->id) ?>" class="btn btn-warning shadow-sm mr-2">
                <i class="fas fa-edit fa-sm text-white-50"></i> Επεξεργασία
            </a>
            <a href="<?= base_url('admin/customers') ?>" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Επιστροφή στη Λίστα
            </a>
        </div>
    </div>

    <!-- Customer Info Summary Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-id-card"></i> Στοιχεία Πελάτη (ID: <?= $customer->id ?>)
            </h6>
            <div class="dropdown no-arrow d-print-none">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow">
                    <a class="dropdown-item" href="<?= base_url('admin/tasks/create?customer_id=' . $customer->id) ?>">
                        <i class="fas fa-tasks fa-sm fa-fw mr-2 text-primary"></i> Δημιουργία Task
                    </a>
                    <a class="dropdown-item" href="<?= base_url('admin/tasks?customer_filter=' . $customer->id) ?>">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-info"></i> Προβολή Tasks
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= base_url('admin/pays/create_specific/' . $customer->id) ?>">
                        <i class="fas fa-money-bill-wave fa-sm fa-fw mr-2 text-success"></i> Νέα Πληρωμή
                    </a>
                    <a class="dropdown-item" href="<?= base_url('admin/pays?customer_id=' . $customer->id) ?>">
                        <i class="fas fa-history fa-sm fa-fw mr-2 text-warning"></i> Ιστορικό Πληρωμών
                    </a>
                    <a class="dropdown-item" href="<?= base_url('admin/pays/debt_list?customer_id=' . $customer->id) ?>">
                        <i class="fas fa-exclamation-triangle fa-sm fa-fw mr-2 text-danger"></i> Χρέη Πελάτη
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= base_url('admin/customers/edit/' . $customer->id) ?>">
                        <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i> Επεξεργασία
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="window.print()">
                        <i class="fas fa-print fa-sm fa-fw mr-2 text-gray-400"></i> Εκτύπωση
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <table class="table table-borderless table-sm">
                        <tbody>
                            <tr>
                                <td class="font-weight-bold text-primary"><i class="fas fa-user"></i> Ονοματεπώνυμο:</td>
                                <td><?= $customer->name ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-primary"><i class="fas fa-birthday-cake"></i> Ημ/νια Γέννησης:</td>
                                <td><?= $customer->birthday ?: '-' ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-primary"><i class="fas fa-id-card"></i> ΑΜΚΑ:</td>
                                <td><?= $customer->amka ?: '-' ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-primary"><i class="fas fa-briefcase"></i> Επάγγελμα:</td>
                                <td><?= $customer->profession ?: '-' ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-primary"><i class="fas fa-home"></i> Διεύθυνση:</td>
                                <td><?= $customer->address ?: '-' ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-primary"><i class="fas fa-map-marker-alt"></i> Πόλη:</td>
                                <td><?= $customer->city ?: '-' ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Right Column -->
                <div class="col-md-6">
                    <table class="table table-borderless table-sm">
                        <tbody>
                            <tr>
                                <td class="font-weight-bold text-success"><i class="fas fa-phone"></i> Σταθερό:</td>
                                <td><?= $customer->phone_home ?: '-' ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-success"><i class="fas fa-mobile-alt"></i> Κινητό:</td>
                                <td><?= $customer->phone_mobile ?: '-' ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-info"><i class="fas fa-shield-alt"></i> Ασφάλεια:</td>
                                <td><?= $insurance->name ?? '-' ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-warning"><i class="fas fa-store"></i> Υποκατάστημα:</td>
                                <td><?= $selling_points->city ?? '-' ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-secondary"><i class="fas fa-user-md"></i> Γιατρός:</td>
                                <td><?= $doctor->doc_name ?? '-' ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-danger"><i class="fas fa-calendar-check"></i> Πρώτη Επίσκεψη:</td>
                                <td><?= $customer->first_visit ?: '-' ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Status Row -->
            <div class="row">
                <div class="col-12">
                    <hr>
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="mr-4 mb-2">
                            <span class="text-primary font-weight-bold">Κατάσταση:</span>
                            <span class="badge badge-<?= ($customer_status->status == 'Ενεργός') ? 'success' : 'secondary' ?> ml-2">
                                <?= $customer_status->status ?? 'Άγνωστη' ?>
                            </span>
                        </div>
                        
                        <?php if ($customer->pending == 'pending'): ?>
                        <div class="mr-4 mb-2">
                            <span class="badge badge-warning">
                                <i class="fas fa-clock"></i> Σε Εκκρεμότητα
                            </span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($customer->old_user == '1'): ?>
                        <div class="mr-4 mb-2">
                            <span class="badge badge-info">
                                <i class="fas fa-history"></i> Παλιός Χρήστης
                            </span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($customer->customer_id): ?>
                        <div class="mr-4 mb-2">
                            <span class="text-secondary font-weight-bold">Κωδικός:</span>
                            <span class="badge badge-light ml-2"><?= $customer->customer_id ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($customer->comments): ?>
                    <div class="mt-3 d-print-none">
                        <span class="text-secondary font-weight-bold"><i class="fas fa-comment-alt"></i> Σχόλια:</span>
                        <div class="bg-light p-2 rounded mt-1">
                            <?= nl2br(htmlspecialchars($customer->comments)) ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="card shadow mb-4 d-print-none">
        <div class="card-header p-0">
            <ul class="nav nav-tabs card-header-tabs" id="customerTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="stocks-tab" data-toggle="tab" href="#stocks" role="tab">
                        <i class="fas fa-headphones"></i> Ακουστικά & Εξοπλισμός 
                        <span class="badge badge-primary ml-1"><?= count($stocks) ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="earlabs-tab" data-toggle="tab" href="#earlabs" role="tab">
                        <i class="fas fa-cogs"></i> Κατασκευές & Εργαστήρια
                        <span class="badge badge-success ml-1"><?= count($earlabs) ?></span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="card-body">
            <div class="tab-content" id="customerTabContent">
                
                <!-- Stocks Tab -->
                <div class="tab-pane fade show active" id="stocks" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="stocksTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Κατασκευαστής</th>
                                    <th>Μοντέλο</th>
                                    <th>Τύπος</th>
                                    <th>Ημ/νια Πώλησης</th>
                                    <th>Λήξη Εγγύησης</th>
                                    <th>Σχόλια</th>
                                    <th class="d-print-none">Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stocks as $key => $stock): ?>
                                    <?php
                                    // Load models for stock details
                                    $this->load->model(array('admin/manufacturer', 'admin/model', 'admin/serie', 'admin/ha_type'));
                                    
                                    $ha = $this->model->get($stock['ha_model']);                                     
                                    $series = $this->serie->get($ha->series ?? 0);
                                    $type = $this->ha_type->get($ha->ha_type ?? 0);
                                    $manufacturer = $this->manufacturer->get($series->brand ?? 0);
                                    ?>
                                    <tr>
                                        <td><span class="badge badge-info"><?= $stock['serial'] ?></span></td>
                                        <td><?= $manufacturer->name ?? '-' ?></td>
                                        <td><?= $ha->model ?? '-' ?></td>
                                        <td><?= $type->type ?? '-' ?></td>
                                        <td><?= $stock['day_out'] ?: '-' ?></td>
                                        <td><?= $stock['guarantee_end'] ?: '-' ?></td>
                                        <td><?= $stock['comments'] ?: '-' ?></td>
                                        <td class="d-print-none">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" 
                                                        data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-cog"></i> Ενέργειες
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="<?= base_url('admin/tasks/create?customer_id=' . $customer->id . '&acoustic_id=' . $stock['id']) ?>">
                                                        <i class="fas fa-tasks text-primary"></i> Δημιουργία Task
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="<?= base_url('admin/stocks/edit/' . $stock['id']) ?>">
                                                        <i class="fas fa-edit"></i> Επεξεργασία
                                                    </a>
                                                    <a class="dropdown-item" href="<?= base_url('admin/stocks/view/' . $stock['id']) ?>">
                                                        <i class="fas fa-eye"></i> Προβολή
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="<?= base_url('admin/stocks/pays/' . $stock['id']) ?>">
                                                        <i class="fas fa-euro-sign"></i> Χρέη
                                                    </a>
                                                    <a class="dropdown-item" href="<?= base_url('admin/stocks/eggyisi_doc/' . $stock['id']) ?>" target="_blank">
                                                        <i class="fas fa-certificate"></i> Εγγύηση
                                                    </a>
                                                    <a class="dropdown-item" href="<?= base_url('admin/customers/export_customer/' . $stock['id']) ?>" target="_blank">
                                                        <i class="fas fa-file-pdf"></i> Καρτέλα PDF
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Earlabs Tab -->
                <div class="tab-pane fade" id="earlabs" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="earlabsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Τύπος</th>
                                    <th>Πλευρά</th>
                                    <th>Ημ/νια Λήψης</th>
                                    <th>Ημ/νια Παράδοσης</th>
                                    <th>Vent</th>
                                    <th>Εργαστήριο</th>
                                    <th>Κόστος</th>
                                    <th class="d-print-none">Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($earlabs as $key => $earlab): ?>
                                    <tr>
                                        <td><?= $earlab['type_name'] ?></td>
                                        <td>
                                            <span class="badge badge-<?= ($earlab['side'] == 'Δεξί') ? 'primary' : 'success' ?>">
                                                <?= $earlab['side'] ?>
                                            </span>
                                        </td>
                                        <td><?= $earlab['date_order'] ?: '-' ?></td>
                                        <td><?= $earlab['date_delivery'] ?: '-' ?></td>
                                        <td><?= $earlab['vent'] ?></td>
                                        <td><?= $earlab['vendor_name'] ?></td>
                                        <td><span class="text-success font-weight-bold">€<?= number_format($earlab['cost'], 2) ?></span></td>
                                        <td class="d-print-none">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-success dropdown-toggle" 
                                                        data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-cog"></i> Ενέργειες
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="<?= base_url('admin/earlabs/edit/' . $earlab['id']) ?>">
                                                        <i class="fas fa-edit"></i> Επεξεργασία
                                                    </a>
                                                    <a class="dropdown-item" href="<?= base_url('admin/earlabs/service_doc/' . $earlab['id']) ?>" target="_blank">
                                                        <i class="fas fa-file-alt"></i> Δελτίο Κατασκευής
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Version - All Data -->
    <div class="d-none d-print-block">
        <div class="row">
            <div class="col-12">
                <h4 class="text-primary border-bottom pb-2 mb-3">
                    <i class="fas fa-headphones"></i> Ακουστικά & Εξοπλισμός
                </h4>
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>Serial</th>
                            <th>Κατασκευαστής</th>
                            <th>Μοντέλο</th>
                            <th>Τύπος</th>
                            <th>Πώληση</th>
                            <th>Εγγύηση</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stocks as $stock): ?>
                            <?php
                            $ha = $this->model->get($stock['ha_model']);                                     
                            $series = $this->serie->get($ha->series ?? 0);
                            $type = $this->ha_type->get($ha->ha_type ?? 0);
                            $manufacturer = $this->manufacturer->get($series->brand ?? 0);
                            ?>
                            <tr>
                                <td><?= $stock['serial'] ?></td>
                                <td><?= $manufacturer->name ?? '-' ?></td>
                                <td><?= $ha->model ?? '-' ?></td>
                                <td><?= $type->type ?? '-' ?></td>
                                <td><?= $stock['day_out'] ?: '-' ?></td>
                                <td><?= $stock['guarantee_end'] ?: '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <h4 class="text-primary border-bottom pb-2 mb-3 mt-4">
                    <i class="fas fa-cogs"></i> Κατασκευές & Εργαστήρια
                </h4>
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>Τύπος</th>
                            <th>Πλευρά</th>
                            <th>Λήψη</th>
                            <th>Παράδοση</th>
                            <th>Εργαστήριο</th>
                            <th>Κόστος</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($earlabs as $earlab): ?>
                            <tr>
                                <td><?= $earlab['type_name'] ?></td>
                                <td><?= $earlab['side'] ?></td>
                                <td><?= $earlab['date_order'] ?: '-' ?></td>
                                <td><?= $earlab['date_delivery'] ?: '-' ?></td>
                                <td><?= $earlab['vendor_name'] ?></td>
                                <td>€<?= number_format($earlab['cost'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- End Page Content -->

<!-- DataTables Scripts -->
<script>
$(document).ready(function() {
    // Initialize DataTables for both tables
    if (typeof $.fn.DataTable !== 'undefined') {
        // Stocks DataTable
        $('#stocksTable').DataTable({
            'responsive': true,
            'pageLength': 10,
            'lengthMenu': [[5, 10, 25, -1], [5, 10, 25, 'Όλα']],
            'searching': true,
            'ordering': true,
            'paging': true,
            'info': true,
            'language': {
                'search': 'Αναζήτηση ακουστικών:',
                'lengthMenu': 'Εμφάνιση _MENU_ εγγραφών',
                'info': 'Εμφάνιση _START_ έως _END_ από _TOTAL_ ακουστικά',
                'infoEmpty': 'Δεν υπάρχουν ακουστικά',
                'infoFiltered': '(φιλτράρισμα από _MAX_ συνολικά)',
                'paginate': {
                    'first': 'Πρώτη',
                    'last': 'Τελευταία', 
                    'next': 'Επόμενη',
                    'previous': 'Προηγούμενη'
                },
                'emptyTable': 'Δεν υπάρχουν ακουστικά για αυτόν τον πελάτη'
            },
            'columnDefs': [
                { 'orderable': false, 'targets': [7] }
            ]
        });
        
        // Earlabs DataTable
        $('#earlabsTable').DataTable({
            'responsive': true,
            'pageLength': 10,
            'lengthMenu': [[5, 10, 25, -1], [5, 10, 25, 'Όλα']],
            'searching': true,
            'ordering': true,
            'paging': true,
            'info': true,
            'language': {
                'search': 'Αναζήτηση κατασκευών:',
                'lengthMenu': 'Εμφάνιση _MENU_ εγγραφών',
                'info': 'Εμφάνιση _START_ έως _END_ από _TOTAL_ κατασκευές',
                'infoEmpty': 'Δεν υπάρχουν κατασκευές',
                'infoFiltered': '(φιλτράρισμα από _MAX_ συνολικά)',
                'paginate': {
                    'first': 'Πρώτη',
                    'last': 'Τελευταία', 
                    'next': 'Επόμενη',
                    'previous': 'Προηγούμενη'
                },
                'emptyTable': 'Δεν υπάρχουν κατασκευές για αυτόν τον πελάτη'
            },
            'columnDefs': [
                { 'orderable': false, 'targets': [7] }
            ]
        });
        
        console.log('Customer view DataTables initialized');
    }
});
</script>
