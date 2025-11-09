<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-edit text-warning"></i> Επεξεργασία Πελάτη: <?= $customer->name ?>
        </h1>
        <div>
            <a href="<?= base_url('admin/customers/view/'.$customer->id) ?>" class="btn btn-info shadow-sm mr-2">
                <i class="fas fa-eye fa-sm text-white-50"></i> Προβολή Καρτέλας
            </a>
            <a href="<?= base_url('admin/customers') ?>" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Επιστροφή στη Λίστα
            </a>
        </div>
    </div>

    <form method="POST" action="<?= base_url('admin/customers/edit/'.$customer->id) ?>" class="needs-validation" novalidate>
        
        <!-- Προσωπικά Στοιχεία -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user"></i> Προσωπικά Στοιχεία
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="customer_db_id" class="form-label">
                                <i class="fas fa-hashtag text-secondary"></i> ID Πελάτη
                            </label>
                            <input type="text" class="form-control" id="customer_db_id" 
                                   value="<?= $customer->id ?>" disabled>
                            <small class="text-muted">Αυτόματος κωδικός</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-user-tag text-info"></i> Ονοματεπώνυμο <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?= $customer->name ?>" placeholder="Εισάγετε το πλήρες ονοματεπώνυμο" required>
                            <div class="invalid-feedback">
                                Παρακαλώ εισάγετε το ονοματεπώνυμο.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="birthday" class="form-label">
                                <i class="fas fa-birthday-cake text-warning"></i> Ημερομηνία Γέννησης
                            </label>
                            <input type="date" class="form-control" id="birthday" name="birthday" 
                                   value="<?= $customer->birthday ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="amka" class="form-label">
                                <i class="fas fa-id-card text-success"></i> ΑΜΚΑ
                            </label>
                            <input type="text" class="form-control" id="amka" name="amka" 
                                   value="<?= $customer->amka ?>" placeholder="Αριθμός Μητρώου" maxlength="11">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="profession" class="form-label">
                                <i class="fas fa-briefcase text-secondary"></i> Επάγγελμα
                            </label>
                            <input type="text" class="form-control" id="profession" name="profession" 
                                   value="<?= $customer->profession ?>" placeholder="Εισάγετε το επάγγελμα">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="insurance" class="form-label">
                                <i class="fas fa-shield-alt text-info"></i> Ασφαλιστικός Φορέας
                            </label>
                            <select class="form-control" id="insurance" name="insurance">
                                <option value="">Επιλέξτε ασφαλιστικό φορέα</option>
                                <?php if (count($insurances)): ?>
                                    <?php foreach ($insurances as $key => $insurance): ?>
                                        <option value="<?= $insurance['id'] ?>" <?= ($customer->insurance == $insurance['id']) ? 'selected' : '' ?>>
                                            <?= $insurance['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="old_user" class="form-label">
                                <i class="fas fa-history text-warning"></i> Παλιός Χρήστης
                            </label>
                            <select class="form-control" id="old_user" name="old_user">
                                <option value="0" <?= ($customer->old_user == '0') ? 'selected' : '' ?>>Όχι</option>
                                <option value="1" <?= ($customer->old_user == '1') ? 'selected' : '' ?>>Ναι</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Στοιχεία Επικοινωνίας -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-phone"></i> Στοιχεία Επικοινωνίας
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="phone_home" class="form-label">
                                <i class="fas fa-phone text-primary"></i> Σταθερό Τηλέφωνο
                            </label>
                            <input type="tel" class="form-control" id="phone_home" name="phone_home" 
                                   value="<?= $customer->phone_home ?>" placeholder="π.χ. 2261023456">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="phone_mobile" class="form-label">
                                <i class="fas fa-mobile-alt text-success"></i> Κινητό Τηλέφωνο <span class="text-danger">*</span>
                            </label>
                            <input type="tel" class="form-control" id="phone_mobile" name="phone_mobile" 
                                   value="<?= $customer->phone_mobile ?>" placeholder="π.χ. 6971234567" required>
                            <div class="invalid-feedback">
                                Παρακαλώ εισάγετε κινητό τηλέφωνο.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city" class="form-label">
                                <i class="fas fa-map-marker-alt text-danger"></i> Πόλη
                            </label>
                            <input type="text" class="form-control" id="city" name="city" 
                                   value="<?= $customer->city ?>" placeholder="Εισάγετε την πόλη">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address" class="form-label">
                                <i class="fas fa-home text-info"></i> Διεύθυνση Κατοικίας
                            </label>
                            <input type="text" class="form-control" id="address" name="address" 
                                   value="<?= $customer->address ?>" placeholder="Εισάγετε τη διεύθυνση (οδός, αριθμός, περιοχή)">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Επαγγελματικά Στοιχεία -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-building"></i> Επαγγελματικά Στοιχεία & Παραπομπή
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="selling_point" class="form-label">
                                <i class="fas fa-store text-primary"></i> Σημείο Πώλησης <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="selling_point" name="selling_point" required>
                                <option value="">Επιλέξτε υποκατάστημα</option>
                                <?php if (count($selling_points)): ?>
                                    <?php foreach ($selling_points as $key => $selling_point): ?>
                                        <option value="<?= $selling_point['id'] ?>" <?= ($customer->selling_point == $selling_point['id']) ? 'selected' : '' ?>>
                                            <?= $selling_point['city'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="invalid-feedback">
                                Παρακαλώ επιλέξτε σημείο πώλησης.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="doctor" class="form-label">
                                <i class="fas fa-user-md text-success"></i> Παραπέμπων Ιατρός
                            </label>
                            <select class="form-control" id="doctor" name="doctor">
                                <option value="">Επιλέξτε ιατρό</option>
                                <?php if (count($doctors)): ?>
                                    <?php foreach ($doctors as $key => $doctor): ?>
                                        <option value="<?= $doctor['id'] ?>" <?= ($customer->doctor == $doctor['id']) ? 'selected' : '' ?>>
                                            <?= $doctor['doc_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="first_visit" class="form-label">
                                <i class="fas fa-calendar-check text-warning"></i> Πρώτη Επίσκεψη
                            </label>
                            <input type="date" class="form-control" id="first_visit" name="first_visit" 
                                   value="<?= $customer->first_visit ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Κατάσταση Πελάτη -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-cogs"></i> Κατάσταση & Ρυθμίσεις Πελάτη
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status" class="form-label">
                                <i class="fas fa-flag text-info"></i> Κατάσταση
                            </label>
                            <select class="form-control" id="status" name="status">
                                <?php if (count($customer_status)): ?>
                                    <?php foreach ($customer_status as $key => $status): ?>
                                        <option value="<?= $status['id'] ?>" <?= ($customer->status == $status['id']) ? 'selected' : '' ?>>
                                            <?= $status['status'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="customer_id" class="form-label">
                                <i class="fas fa-hashtag text-secondary"></i> Κωδικός Πελάτη
                            </label>
                            <input type="text" class="form-control" id="customer_id" name="customer_id" 
                                   value="<?= $customer->customer_id ?>" placeholder="Προαιρετικός εξωτερικός κωδικός">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-check mt-4 pt-2">
                                <input type="checkbox" class="form-check-input" id="pending" name="pending" value="pending" 
                                       <?= ($customer->pending == 'pending') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="pending">
                                    <i class="fas fa-clock text-warning"></i> <strong>Εκκρεμότητα</strong>
                                    <br><small class="text-muted">Παραγγελία προς παράδοση</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="comments" class="form-label">
                                <i class="fas fa-comment-alt text-secondary"></i> Σχόλια & Παρατηρήσεις
                            </label>
                            <textarea class="form-control" id="comments" name="comments" rows="3" 
                                      placeholder="Εισάγετε τυχόν σχόλια, παρατηρήσεις ή ειδικές οδηγίες για τον πελάτη..."><?= $customer->comments ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <button type="submit" class="btn btn-success btn-lg mr-3">
                    <i class="fas fa-save"></i> Αποθήκευση Αλλαγών
                </button>
                <button type="reset" class="btn btn-warning btn-lg mr-3">
                    <i class="fas fa-undo"></i> Επαναφορά Αλλαγών
                </button>
                <a href="<?= base_url('admin/customers/view/'.$customer->id) ?>" class="btn btn-info btn-lg mr-3">
                    <i class="fas fa-eye"></i> Προβολή Καρτέλας
                </a>
                <a href="<?= base_url('admin/customers') ?>" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times"></i> Ακύρωση
                </a>
            </div>
        </div>
    </form>

</div>
<!-- End Page Content -->

<!-- Form Validation Script -->
<script>
$(document).ready(function() {
    // Bootstrap form validation (same as create form)
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Auto-format phone numbers (same as create form)
    $('#phone_home, #phone_mobile').on('input', function() {
        var value = $(this).val().replace(/\D/g, '');
        if (value.length > 0) {
            if (value.startsWith('69') && value.length <= 10) {
                if (value.length > 3 && value.length <= 6) {
                    $(this).val(value.replace(/(\d{3})(\d+)/, '$1-$2'));
                } else if (value.length > 6) {
                    $(this).val(value.replace(/(\d{3})(\d{3})(\d+)/, '$1-$2-$3'));
                }
            } else if (value.startsWith('2') && value.length <= 10) {
                if (value.length > 3 && value.length <= 6) {
                    $(this).val(value.replace(/(\d{3})(\d+)/, '$1-$2'));
                } else if (value.length > 6) {
                    $(this).val(value.replace(/(\d{3})(\d{3})(\d+)/, '$1-$2-$3'));
                }
            }
        }
    });

    // AMKA validation (same as create form)
    $('#amka').on('input', function() {
        var amka = $(this).val().replace(/\D/g, '');
        if (amka.length > 11) {
            amka = amka.substr(0, 11);
        }
        $(this).val(amka);
        
        if (amka.length === 11) {
            $(this).removeClass('is-invalid').addClass('is-valid');
        } else if (amka.length > 0) {
            $(this).removeClass('is-valid').addClass('is-invalid');
        } else {
            $(this).removeClass('is-valid is-invalid');
        }
    });
});
</script>
