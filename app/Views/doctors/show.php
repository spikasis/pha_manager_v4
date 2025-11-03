<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>
<?= $title ?> - PHA Manager
<?= $this->endSection() ?>

<?= $this->section('page-title') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-md fa-fw mr-2"></i>
        <?= esc($doctor['doc_name']) ?>
    </h1>
    <div class="ml-auto">
        <a href="<?= $listUrl ?>" class="btn btn-secondary btn-sm mr-2">
            <i class="fas fa-arrow-left"></i> Πίσω στη Λίστα
        </a>
        <a href="<?= $editUrl ?>" class="btn btn-warning btn-sm mr-2">
            <i class="fas fa-edit"></i> Επεξεργασία
        </a>
        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete()">
            <i class="fas fa-trash"></i> Διαγραφή
        </button>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <!-- Doctor Information Card -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-md mr-2"></i>
                    Στοιχεία Γιατρού
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">ID:</label>
                            <p class="text-gray-800"><?= esc($doctor['id']) ?></p>
                        </div>
                        
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">Όνομα:</label>
                            <p class="text-gray-800"><?= esc($doctor['doc_name']) ?></p>
                        </div>
                        
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">Διεύθυνση:</label>
                            <p class="text-gray-800"><?= esc($doctor['doc_address'] ?: '-') ?></p>
                        </div>
                        
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">Πόλη:</label>
                            <p class="text-gray-800"><?= esc($doctor['doc_city'] ?: '-') ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">Τηλέφωνο Εργασίας:</label>
                            <p class="text-gray-800">
                                <?php if (!empty($doctor['doc_phone_work'])): ?>
                                    <a href="tel:<?= esc($doctor['doc_phone_work']) ?>" class="text-primary">
                                        <i class="fas fa-phone mr-1"></i>
                                        <?= esc($doctor['doc_phone_work']) ?>
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                        </div>
                        
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">Κινητό Τηλέφωνο:</label>
                            <p class="text-gray-800">
                                <?php if (!empty($doctor['doc_phone_mobile'])): ?>
                                    <a href="tel:<?= esc($doctor['doc_phone_mobile']) ?>" class="text-primary">
                                        <i class="fas fa-mobile-alt mr-1"></i>
                                        <?= esc($doctor['doc_phone_mobile']) ?>
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                        </div>
                        
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">Τιμή:</label>
                            <p class="text-gray-800">
                                <?php if (isset($doctor['doc_price']) && $doctor['doc_price'] !== null): ?>
                                    <span class="badge badge-success font-size-lg">
                                        €<?= number_format($doctor['doc_price'], 2) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Δεν έχει οριστεί</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">Πελάτες:</label>
                            <p class="text-gray-800">
                                <span class="badge badge-info font-size-lg">
                                    <?= $doctor['customer_count'] ?> πελάτες
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats Card -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Γρήγορες Πληροφορίες
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="avatar-lg mx-auto mb-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-user-md"></i>
                        </div>
                    </div>
                    <h5 class="text-gray-800"><?= esc($doctor['doc_name']) ?></h5>
                    <?php if (!empty($doctor['doc_city'])): ?>
                        <p class="text-muted"><i class="fas fa-map-marker-alt mr-1"></i><?= esc($doctor['doc_city']) ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="border-top pt-3">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-right">
                                <h4 class="text-primary"><?= $doctor['customer_count'] ?></h4>
                                <small class="text-muted">Πελάτες</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">
                                <?php if (isset($doctor['doc_price']) && $doctor['doc_price'] > 0): ?>
                                    €<?= number_format($doctor['doc_price'], 0) ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </h4>
                            <small class="text-muted">Τιμή</small>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted">Επίπεδο Πληρότητας</small>
                        <small class="text-muted">
                            <?php 
                            $completeness = 0;
                            if (!empty($doctor['doc_name'])) $completeness += 25;
                            if (!empty($doctor['doc_address'])) $completeness += 20;
                            if (!empty($doctor['doc_phone_work']) || !empty($doctor['doc_phone_mobile'])) $completeness += 25;
                            if (!empty($doctor['doc_city'])) $completeness += 15;
                            if (isset($doctor['doc_price']) && $doctor['doc_price'] > 0) $completeness += 15;
                            echo $completeness . '%';
                            ?>
                        </small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar 
                            <?php if ($completeness >= 80): ?>bg-success
                            <?php elseif ($completeness >= 60): ?>bg-warning
                            <?php else: ?>bg-danger<?php endif; ?>" 
                            style="width: <?= $completeness ?>%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Customers -->
<?php if (!empty($relatedCustomers)): ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-users mr-2"></i>
                            Πελάτες του Γιατρού (<?= count($relatedCustomers) ?><?= count($relatedCustomers) >= 10 ? '+' : '' ?>)
                        </h6>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('customers?doctor_id=' . $doctor['id']) ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> Δες Όλους
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Επώνυμο</th>
                                <th>Όνομα</th>
                                <th>Τηλέφωνο</th>
                                <th>Ενέργειες</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($relatedCustomers as $customer): ?>
                            <tr>
                                <td><?= esc($customer['id']) ?></td>
                                <td><?= esc($customer['surname']) ?></td>
                                <td><?= esc($customer['name']) ?></td>
                                <td>
                                    <?php if (!empty($customer['phone'])): ?>
                                        <a href="tel:<?= esc($customer['phone']) ?>" class="text-primary">
                                            <?= esc($customer['phone']) ?>
                                        </a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('customers/show/' . $customer['id']) ?>" class="btn btn-info btn-sm">
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
    </div>
</div>
<?php else: ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body text-center">
                <div class="py-4">
                    <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">Δεν υπάρχουν πελάτες</h5>
                    <p class="text-gray-500">Αυτός ο γιατρός δεν έχει ακόμη πελάτες.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function confirmDelete() {
    Swal.fire({
        title: 'Είστε σίγουροι;',
        text: "Δεν θα μπορείτε να αναιρέσετε αυτή την ενέργεια!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ναι, διαγραφή!',
        cancelButtonText: 'Ακύρωση'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to delete URL
            window.location.href = '<?= $deleteUrl ?>';
        }
    });
}
</script>
<?= $this->endSection() ?>