<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle text-success"></i> Προσθήκη Νέου Ακουστικού
        </h1>
        <a href="<?= base_url('admin/stocks') ?>" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Επιστροφή στη Λίστα</span>
        </a>
    </div>

    <form role="form" method="POST" action="<?= base_url('admin/stocks/create/') ?>" id="stockCreateForm">
        <div class="row">
            <!-- Βασικές Πληροφορίες Ακουστικού -->
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle"></i> Βασικές Πληροφορίες
                        </h6>
                    </div>
                    <div class="card-body">                            
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-hashtag text-muted mr-1"></i>Hearing Aid ID</label>
                                    <input class="form-control" placeholder="Αυτόματη δημιουργία" disabled readonly>
                                    <small class="form-text text-muted">Το ID θα δημιουργηθεί αυτόματα</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-barcode text-muted mr-1"></i>Serial No <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Εισαγάγετε σειριακό αριθμό" id="serial" name="serial" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-headphones text-muted mr-1"></i>Μοντέλο Ακουστικού <span class="text-danger">*</span></label>
                            <input list="model_id" name="ha_model" id="ha_model" class="form-control" 
                                   placeholder="Επιλέξτε ή πληκτρολογήστε μοντέλο" required>
                            <datalist id="model_id">
                                <?php if (count($ha_models)): ?>
                                    <?php foreach ($ha_models as $key => $ha_models): ?>
                                    <?php 
                                        $type = $this->ha_type->get($ha_models['ha_type']);
                                        $series = $this->serie->get($ha_models['series']);
                                        $brand = $this->manufacturer->get($series->brand);
                                        $battery = $this->battery_type->get($ha_models['battery']);
                                    ?>
                                        <option value="<?= $ha_models['id'] ?>"><?= $brand->name ?> <?= $series->series ?>-<?= $ha_models['model'] ?> - <?= $type->type ?> - Bat. No <?= $battery->type ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </datalist>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-truck text-muted mr-1"></i>Προμηθευτής</label>
                                    <select class="form-control" id="vendor" name="vendor">
                                        <option value="">-- Επιλέξτε προμηθευτή --</option>
                                        <?php if (count($vendors)): ?>
                                            <?php foreach ($vendors as $key => $vendor): ?>
                                                <option value="<?= $vendor['id'] ?>"><?= $vendor['name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-tag text-muted mr-1"></i>Κατάσταση <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="">-- Επιλέξτε κατάσταση --</option>
                                        <?php if (count($stock_status)): ?>
                                            <?php foreach ($stock_status as $key => $status): ?>
                                                <option value="<?= $status['id'] ?>"><?= $status['status'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                    
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-user text-muted mr-1"></i>Πελάτης</label>
                            <input list="customer_idS" name="customer_id" id="customer_id" class="form-control" 
                                   placeholder="Επιλέξτε ή αναζητήστε πελάτη">
                            <datalist id="customer_idS">
                                <?php if (count($customers)): ?>
                                    <?php foreach ($customers as $key => $customer): ?>
                                        <option value="<?= $customer['id'] ?>"><?= $customer['name'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </datalist>                               
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-qrcode text-muted mr-1"></i>Barcode ΕΟΠΥΥ</label>
                                    <input class="form-control" placeholder="Barcode ΕΟΠΥΥ" id="ekapty_code" name="ekapty_code">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-check-circle text-muted mr-1"></i>Εκτέλεση ΕΟΠΥΥ</label>
                                    <input class="form-control" placeholder="Εκτέλεση ΕΟΠΥΥ" id="ektelesi_eopyy" name="ektelesi_eopyy">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ημερομηνίες και Πληροφορίες Πώλησης -->
            <div class="col-lg-6">
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
                            <input class="form-control" type="date" id="day_in" name="day_in" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-sign-out-alt text-muted mr-1"></i>Ημερομηνία Πώλησης</label>
                            <input class="form-control" type="date" id="day_out" name="day_out">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-shield-alt text-muted mr-1"></i>Λήξη Εγγύησης</label>
                            <input class="form-control" type="date" id="guarantee_end" name="guarantee_end">
                            <small class="form-text text-muted">Συνήθως 2 χρόνια από την ημερομηνία πώλησης</small>
                        </div>
                    </div>
                </div>

                <!-- Οικονομικά Στοιχεία Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-warning">
                            <i class="fas fa-euro-sign"></i> Οικονομικά Στοιχεία
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-money-bill text-muted mr-1"></i>Τιμή Πώλησης (€)</label>
                            <div class="input-group">
                                <input class="form-control" type="number" step="0.01" min="0" 
                                       placeholder="0.00" id="ha_price" name="ha_price">
                                <div class="input-group-append">
                                    <span class="input-group-text">€</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-hand-holding-usd text-muted mr-1"></i>Συμμετοχή Ταμείου (€)</label>
                            <div class="input-group">
                                <input class="form-control" type="number" step="0.01" min="0" 
                                       placeholder="0.00" id="eopyy" name="eopyy">
                                <div class="input-group-append">
                                    <span class="input-group-text">€</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Λοιπά Στοιχεία Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-info">
                            <i class="fas fa-cogs"></i> Λοιπά Στοιχεία
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-store text-muted mr-1"></i>Σημείο Πώλησης</label>
                            <select class="form-control" id="selling_point" name="selling_point">
                                <option value="">-- Επιλέξτε σημείο πώλησης --</option>
                                <?php if (count($selling_point)): ?>
                                    <?php foreach ($selling_point as $key => $list): ?>
                                        <option value="<?= $list['id'] ?>"><?= $list['city'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>                                 
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-user-md text-muted mr-1"></i>Ιατρός</label>
                            <select class="form-control" id="doctor" name="doctor">
                                <option value="">-- Επιλέξτε ιατρό --</option>
                                <?php if (count($doctors)): ?>
                                    <?php foreach ($doctors as $key => $doctor): ?>
                                        <option value="<?= $doctor['id']; ?>" <?= ($doctor['id'] == 8) ? 'selected' : ''; ?>>
                                            <?= $doctor['doc_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-comment text-muted mr-1"></i>Σχόλια</label>
                            <textarea class="form-control" rows="3" placeholder="Εισαγάγετε τυχόν σχόλια..." id="comments" name="comments"></textarea>
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
                        <button type="submit" class="btn btn-success btn-icon-split mr-3">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Δημιουργία Ακουστικού</span>
                        </button>
                        <button type="reset" class="btn btn-secondary btn-icon-split mr-3">
                            <span class="icon text-white-50">
                                <i class="fas fa-undo"></i>
                            </span>
                            <span class="text">Επαναφορά Φόρμας</span>
                        </button>
                        <a href="<?= base_url('admin/stocks') ?>" class="btn btn-light btn-icon-split">
                            <span class="icon text-gray-600">
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
        if (saleDate) {
            // Add 2 years for warranty
            saleDate.setFullYear(saleDate.getFullYear() + 2);
            var warrantyEnd = saleDate.toISOString().split('T')[0];
            $('#guarantee_end').val(warrantyEnd);
        }
    });

    // Form validation
    $('#stockCreateForm').submit(function(e) {
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
    $('input, select').on('input change', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
