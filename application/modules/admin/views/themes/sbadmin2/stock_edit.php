<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit text-warning"></i> Επεξεργασία Ακουστικού
            <span class="badge badge-primary ml-2">#<?= $stock->id ?></span>
        </h1>
        <div>
            <a href="<?= base_url('admin/stocks/view/' . $stock->id) ?>" class="btn btn-info btn-icon-split mr-2">
                <span class="icon text-white-50">
                    <i class="fas fa-eye"></i>
                </span>
                <span class="text">Προβολή</span>
            </a>
            <a href="<?= base_url('admin/stocks') ?>" class="btn btn-secondary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Επιστροφή στη Λίστα</span>
            </a>
        </div>
    </div>

    <form role="form" method="POST" action="<?= base_url('admin/stocks/edit/' . $stock->id) ?>" id="stockEditForm">
        <div class="row">
            <!-- Βασικές Πληροφορίες Ακουστικού -->
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle"></i> Βασικές Πληροφορίες
                        </h6>
                        <div class="badge badge-secondary">ID: <?= $stock->id ?></div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-hashtag text-muted mr-1"></i>Hearing Aid ID</label>
                                    <input class="form-control" value="<?= $stock->id ?>" disabled readonly>
                                    <small class="form-text text-muted">Μη επεξεργάσιμο ID</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-barcode text-muted mr-1"></i>Serial No <span class="text-danger">*</span></label>
                                    <input class="form-control" value="<?= $stock->serial ?>" placeholder="Εισαγάγετε σειριακό αριθμό" id="serial" name="serial" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-headphones text-muted mr-1"></i>Μοντέλο Ακουστικού <span class="text-danger">*</span></label>
                            <input list="model_idS" name="ha_model" id="ha_model" class="form-control" 
                                   value="<?= $stock->ha_model ?>" placeholder="Επιλέξτε ή πληκτρολογήστε μοντέλο" required>
                            <datalist id="model_idS">
                                <?php if (count($ha_models)): ?>
                                    <?php foreach ($ha_models as $ha_models): ?>
                                        <?php 
                                        $type = $this->ha_type->get($ha_models['ha_type']);
                                        $series = $this->serie->get($ha_models['series']);
                                        $brand = $this->manufacturer->get($series->brand);
                                        $battery = $this->battery_type->get($ha_models['battery']);
                                        ?>
                                        <option value="<?= $ha_models['id'] ?>"><?= $brand->name ?> <?= $series->series ?>-<?= $ha_models['model'] ?>-<?= $type->type ?> - Bat. No <?= $battery->type ?></option>                                                 
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </datalist>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-user-md text-muted mr-1"></i>Ιατρός</label>
                            <select class="form-control" id="doctor" name="doctor_id">
                                <option value="">-- Επιλέξτε ιατρό --</option>
                                <?php if (count($doctors)): ?>
                                    <?php foreach ($doctors as $doctor): ?>
                                        <option value="<?= $doctor['id'] ?>" <?= ($stock->doctor_id == $doctor['id']) ? 'selected' : '' ?>>
                                            <?= $doctor['doc_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Ημερομηνίες Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-success">
                            <i class="fas fa-calendar-alt"></i> Ημερομηνίες
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-sign-in-alt text-muted mr-1"></i>Ημερομηνία Εισαγωγής</label>
                            <input class="form-control" type="date" value="<?= $stock->day_in ?>" id="day_in" name="day_in">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-sign-out-alt text-muted mr-1"></i>Ημερομηνία Πώλησης</label>
                            <input class="form-control" type="date" value="<?= $stock->day_out ?>" id="day_out" name="day_out">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-shield-alt text-muted mr-1"></i>Λήξη Εγγύησης</label>
                            <input class="form-control" type="date" value="<?= $stock->guarantee_end ?>" id="guarantee_end" name="guarantee_end">
                            <small class="form-text text-muted">Συνήθως 2 χρόνια από την ημερομηνία πώλησης</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Κατάσταση και Πώληση -->
            <div class="col-lg-6">
                <!-- Κατάσταση και Προμηθευτής Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-warning">
                            <i class="fas fa-tags"></i> Κατάσταση & Προμηθευτής
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-tag text-muted mr-1"></i>Κατάσταση <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="">-- Επιλέξτε κατάσταση --</option>
                                        <?php if (count($stock_status)): ?>
                                            <?php foreach ($stock_status as $status): ?>
                                                <option value="<?= $status['id'] ?>" <?= ($stock->status == $status['id']) ? 'selected' : '' ?>>
                                                    <?= $status['status'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-truck text-muted mr-1"></i>Προμηθευτής</label>
                                    <select class="form-control" id="vendor" name="vendor">
                                        <option value="">-- Επιλέξτε προμηθευτή --</option>
                                        <?php if (count($vendors)): ?>
                                            <?php foreach ($vendors as $vendor): ?>
                                                <option value="<?= $vendor['id'] ?>" <?= ($stock->vendor == $vendor['id']) ? 'selected' : '' ?>>
                                                    <?= $vendor['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                    
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-user text-muted mr-1"></i>Πελάτης</label>
                            <select class="form-control" id="customer_id" name="customer_id"> 
                                <option value="">-- Επιλέξτε πελάτη --</option>
                                <?php if (count($customers)): ?>
                                    <?php foreach ($customers as $customer): ?>
                                        <option value="<?= $customer['id'] ?>" <?= ($stock->customer_id == $customer['id']) ? 'selected' : '' ?>>
                                            <?= $customer['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>                                   
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-store text-muted mr-1"></i>Σημείο Πώλησης - Αποθήκη</label>
                            <select class="form-control" id="selling_point" name="selling_point">
                                <option value="">-- Επιλέξτε σημείο πώλησης --</option>
                                <?php if (count($selling_point)): ?>
                                    <?php foreach ($selling_point as $list): ?>
                                        <option value="<?= $list['id'] ?>" <?= ($stock->selling_point == $list['id']) ? 'selected' : '' ?>>
                                            <?= $list['city'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>                                    
                        </div>
                    </div>
                </div>

                <!-- Οικονομικά Στοιχεία Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-success">
                            <i class="fas fa-euro-sign"></i> Οικονομικά Στοιχεία
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-money-bill text-muted mr-1"></i>Τιμή Πώλησης (€)</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" step="0.01" min="0" 
                                               value="<?= $stock->ha_price ?>" placeholder="0.00" id="ha_price" name="ha_price">
                                        <div class="input-group-append">
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-hand-holding-usd text-muted mr-1"></i>Συμμετοχή Ταμείου (€)</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" step="0.01" min="0" 
                                               value="<?= $stock->eopyy ?>" placeholder="0.00" id="eopyy" name="eopyy">
                                        <div class="input-group-append">
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-qrcode text-muted mr-1"></i>Barcode ΕΟΠΥΥ</label>
                                    <input class="form-control" value="<?= $stock->ekapty_code ?>" placeholder="Barcode ΕΟΠΥΥ" id="ekapty_code" name="ekapty_code">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-check-circle text-muted mr-1"></i>Εκτέλεση ΕΟΠΥΥ</label>
                                    <input class="form-control" value="<?= $stock->ektelesi_eopyy ?>" placeholder="Εκτέλεση ΕΟΠΥΥ" id="ektelesi_eopyy" name="ektelesi_eopyy">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Σχόλια Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-info">
                            <i class="fas fa-comment"></i> Σχόλια & Παρατηρήσεις
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-comment text-muted mr-1"></i>Σχόλια</label>
                            <textarea class="form-control" rows="4" placeholder="Εισαγάγετε τυχόν σχόλια..." id="comments" name="comments"><?= $stock->comments ?></textarea>
                        </div>
                    </div>
                </div>
            </div> 
        </div><!-- /.row -->

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-primary btn-icon-split mr-3">
                            <span class="icon text-white-50">
                                <i class="fas fa-save"></i>
                            </span>
                            <span class="text">Αποθήκευση Αλλαγών</span>
                        </button>
                        <a href="<?= base_url('admin/stocks/view/' . $stock->id) ?>" class="btn btn-info btn-icon-split mr-3">
                            <span class="icon text-white-50">
                                <i class="fas fa-eye"></i>
                            </span>
                            <span class="text">Προβολή Ακουστικού</span>
                        </a>
                        <a href="<?= base_url('admin/stocks') ?>" class="btn btn-secondary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-times"></i>
                            </span>
                            <span class="text">Ακύρωση</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<!-- End Page Content -->

<script>
$(document).ready(function() {
    // Auto-calculate warranty end date when sale date is selected
    $('#day_out').change(function() {
        var saleDate = new Date($(this).val());
        if (saleDate && !$('#guarantee_end').val()) {
            // Add 2 years for warranty if guarantee_end is empty
            saleDate.setFullYear(saleDate.getFullYear() + 2);
            var warrantyEnd = saleDate.toISOString().split('T')[0];
            $('#guarantee_end').val(warrantyEnd);
        }
    });

    // Form validation
    $('#stockEditForm').submit(function(e) {
        var required = ['serial', 'ha_model', 'status'];
        var isValid = true;
        
        required.forEach(function(field) {
            var input = $('#' + field);
            if (!input.val()) {
                input.addClass('is-invalid');
                isValid = false;
            } else {
                input.removeClass('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Λάθος!',
                text: 'Παρακαλώ συμπληρώστε όλα τα υποχρεωτικά πεδία.'
            });
        }
    });

    // Remove validation class on input
    $('input, select, textarea').on('input change', function() {
        $(this).removeClass('is-invalid');
    });

    // Show confirmation for successful save
    <?php if(isset($success) && $success): ?>
    Swal.fire({
        icon: 'success',
        title: 'Επιτυχία!',
        text: 'Οι αλλαγές αποθηκεύτηκαν επιτυχώς.',
        timer: 2000,
        showConfirmButton: false
    });
    <?php endif; ?>
});
</script>
