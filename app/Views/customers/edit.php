<?php $this->extend('templates/header') ?>

<?php $this->section('content') ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-edit"></i> Επεξεργασία Πελάτη
    </h1>
    <div>
        <a href="<?= base_url('customers/' . $customer['id']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm mr-2">
            <i class="fas fa-eye fa-sm text-white-50"></i> Προβολή
        </a>
        <a href="<?= base_url('customers') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Επιστροφή
        </a>
    </div>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Customer Form -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-user"></i> Επεξεργασία: <?= esc($customer['name']) ?>
        </h6>
        <span class="badge badge-<?= $customer['status'] ? 'success' : 'secondary' ?>">
            <?= $customer['status'] ? 'Ενεργός' : 'Ανενεργός' ?>
        </span>
    </div>
    <div class="card-body">
        <?= form_open(base_url('customers/' . $customer['id']), ['id' => 'customerForm', 'novalidate' => 'novalidate']) ?>
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        
        <div class="row">
            <!-- Personal Information -->
            <div class="col-md-6">
                <h5 class="text-primary mb-3">
                    <i class="fas fa-user-circle"></i> Προσωπικά Στοιχεία
                </h5>
                
                <div class="form-group">
                    <label for="name" class="required">Ονοματεπώνυμο:</label>
                    <input type="text" 
                           class="form-control <?= isset($validation) && $validation->hasError('name') ? 'is-invalid' : '' ?>" 
                           id="name" 
                           name="name" 
                           value="<?= old('name', $customer['name']) ?>" 
                           required>
                    <?php if (isset($validation) && $validation->hasError('name')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('name') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="father_name">Πατρώνυμο:</label>
                    <input type="text" 
                           class="form-control <?= isset($validation) && $validation->hasError('father_name') ? 'is-invalid' : '' ?>" 
                           id="father_name" 
                           name="father_name" 
                           value="<?= old('father_name', $customer['father_name']) ?>">
                    <?php if (isset($validation) && $validation->hasError('father_name')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('father_name') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="birth_date">Ημερομηνία Γέννησης:</label>
                    <input type="date" 
                           class="form-control <?= isset($validation) && $validation->hasError('birth_date') ? 'is-invalid' : '' ?>" 
                           id="birth_date" 
                           name="birth_date" 
                           value="<?= old('birth_date', $customer['birth_date']) ?>">
                    <?php if (isset($validation) && $validation->hasError('birth_date')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('birth_date') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="amka">ΑΜΚΑ:</label>
                    <input type="text" 
                           class="form-control <?= isset($validation) && $validation->hasError('amka') ? 'is-invalid' : '' ?>" 
                           id="amka" 
                           name="amka" 
                           value="<?= old('amka', $customer['amka']) ?>"
                           maxlength="11"
                           placeholder="12345678901">
                    <?php if (isset($validation) && $validation->hasError('amka')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('amka') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="amka_expire_date">Λήξη ΑΜΚΑ:</label>
                    <input type="date" 
                           class="form-control <?= isset($validation) && $validation->hasError('amka_expire_date') ? 'is-invalid' : '' ?>" 
                           id="amka_expire_date" 
                           name="amka_expire_date" 
                           value="<?= old('amka_expire_date', $customer['amka_expire_date']) ?>">
                    <?php if (isset($validation) && $validation->hasError('amka_expire_date')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('amka_expire_date') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="identity_number">Αριθμός Ταυτότητας:</label>
                    <input type="text" 
                           class="form-control <?= isset($validation) && $validation->hasError('identity_number') ? 'is-invalid' : '' ?>" 
                           id="identity_number" 
                           name="identity_number" 
                           value="<?= old('identity_number', $customer['identity_number']) ?>">
                    <?php if (isset($validation) && $validation->hasError('identity_number')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('identity_number') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="identity_expire_date">Λήξη Ταυτότητας:</label>
                    <input type="date" 
                           class="form-control <?= isset($validation) && $validation->hasError('identity_expire_date') ? 'is-invalid' : '' ?>" 
                           id="identity_expire_date" 
                           name="identity_expire_date" 
                           value="<?= old('identity_expire_date', $customer['identity_expire_date']) ?>">
                    <?php if (isset($validation) && $validation->hasError('identity_expire_date')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('identity_expire_date') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="col-md-6">
                <h5 class="text-primary mb-3">
                    <i class="fas fa-address-book"></i> Στοιχεία Επικοινωνίας
                </h5>

                <div class="form-group">
                    <label for="phone_mobile">Κινητό Τηλέφωνο:</label>
                    <input type="tel" 
                           class="form-control <?= isset($validation) && $validation->hasError('phone_mobile') ? 'is-invalid' : '' ?>" 
                           id="phone_mobile" 
                           name="phone_mobile" 
                           value="<?= old('phone_mobile', $customer['phone_mobile']) ?>"
                           placeholder="69xxxxxxxx">
                    <?php if (isset($validation) && $validation->hasError('phone_mobile')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('phone_mobile') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="phone_landline">Σταθερό Τηλέφωνο:</label>
                    <input type="tel" 
                           class="form-control <?= isset($validation) && $validation->hasError('phone_landline') ? 'is-invalid' : '' ?>" 
                           id="phone_landline" 
                           name="phone_landline" 
                           value="<?= old('phone_landline', $customer['phone_landline']) ?>"
                           placeholder="21xxxxxxxx">
                    <?php if (isset($validation) && $validation->hasError('phone_landline')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('phone_landline') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" 
                           class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>" 
                           id="email" 
                           name="email" 
                           value="<?= old('email', $customer['email']) ?>"
                           placeholder="example@email.com">
                    <?php if (isset($validation) && $validation->hasError('email')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('email') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="address">Διεύθυνση:</label>
                    <textarea class="form-control <?= isset($validation) && $validation->hasError('address') ? 'is-invalid' : '' ?>" 
                              id="address" 
                              name="address" 
                              rows="2"
                              placeholder="Οδός, αριθμός, περιοχή"><?= old('address', $customer['address']) ?></textarea>
                    <?php if (isset($validation) && $validation->hasError('address')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('address') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="city">Πόλη:</label>
                            <input type="text" 
                                   class="form-control <?= isset($validation) && $validation->hasError('city') ? 'is-invalid' : '' ?>" 
                                   id="city" 
                                   name="city" 
                                   value="<?= old('city', $customer['city']) ?>"
                                   placeholder="Αθήνα">
                            <?php if (isset($validation) && $validation->hasError('city')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('city') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="postal_code">Τ.Κ.:</label>
                            <input type="text" 
                                   class="form-control <?= isset($validation) && $validation->hasError('postal_code') ? 'is-invalid' : '' ?>" 
                                   id="postal_code" 
                                   name="postal_code" 
                                   value="<?= old('postal_code', $customer['postal_code']) ?>"
                                   maxlength="5"
                                   placeholder="12345">
                            <?php if (isset($validation) && $validation->hasError('postal_code')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('postal_code') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="doctor_id">Γιατρός:</label>
                    <select class="form-control <?= isset($validation) && $validation->hasError('doctor_id') ? 'is-invalid' : '' ?>" 
                            id="doctor_id" 
                            name="doctor_id">
                        <option value="">Επιλέξτε γιατρό...</option>
                        <?php if (isset($doctors) && !empty($doctors)): ?>
                            <?php foreach ($doctors as $doctor): ?>
                                <option value="<?= $doctor['id'] ?>" 
                                        <?= old('doctor_id', $customer['doctor_id']) == $doctor['id'] ? 'selected' : '' ?>>
                                    <?= esc($doctor['name']) ?>
                                    <?php if (!empty($doctor['doc_city'])): ?>
                                        - <?= esc($doctor['doc_city']) ?>
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('doctor_id')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('doctor_id') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="notes">Σημειώσεις:</label>
                    <textarea class="form-control <?= isset($validation) && $validation->hasError('notes') ? 'is-invalid' : '' ?>" 
                              id="notes" 
                              name="notes" 
                              rows="3"
                              placeholder="Επιπλέον πληροφορίες..."><?= old('notes', $customer['notes']) ?></textarea>
                    <?php if (isset($validation) && $validation->hasError('notes')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('notes') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           id="status" 
                           name="status" 
                           value="1" 
                           <?= old('status', $customer['status']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="status">
                        Ενεργός πελάτης
                    </label>
                </div>
            </div>
        </div>

        <!-- Audit Information -->
        <hr class="mt-4 mb-3">
        <div class="row">
            <div class="col-md-6">
                <small class="text-muted">
                    <i class="fas fa-calendar-plus"></i>
                    Δημιουργία: <?= date('d/m/Y H:i', strtotime($customer['created_at'])) ?>
                </small>
            </div>
            <div class="col-md-6 text-right">
                <?php if (!empty($customer['updated_at'])): ?>
                    <small class="text-muted">
                        <i class="fas fa-calendar-edit"></i>
                        Τελευταία ενημέρωση: <?= date('d/m/Y H:i', strtotime($customer['updated_at'])) ?>
                    </small>
                <?php endif; ?>
            </div>
        </div>

        <!-- Form Actions -->
        <hr class="mt-3 mb-3">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="<?= base_url('customers/' . $customer['id']) ?>" class="btn btn-info">
                            <i class="fas fa-eye"></i> Προβολή
                        </a>
                        <a href="<?= base_url('customers') ?>" class="btn btn-secondary">
                            <i class="fas fa-list"></i> Λίστα Πελατών
                        </a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Ενημέρωση
                        </button>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash"></i> Διαγραφή
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?= form_close() ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle"></i> Επιβεβαίωση Διαγραφής
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Είστε σίγουροι ότι θέλετε να διαγράψετε τον πελάτη:</p>
                <p class="font-weight-bold"><?= esc($customer['name']) ?></p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Προσοχή:</strong> Ο πελάτης θα απενεργοποιηθεί αλλά τα δεδομένα του θα διατηρηθούν.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Άκυρο</button>
                <form id="deleteForm" method="POST" action="<?= base_url('customers/' . $customer['id']) ?>" style="display: inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Απενεργοποίηση
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    $('#deleteModal').modal('show');
}

$(document).ready(function() {
    // Same validation and formatting code as create form
    $('#customerForm').on('submit', function(e) {
        var isValid = true;
        
        $('.required').each(function() {
            var field = $(this).next('input, select, textarea');
            if (!field.val().trim()) {
                field.addClass('is-invalid');
                if (!field.next('.invalid-feedback').length) {
                    field.after('<div class="invalid-feedback">Αυτό το πεδίο είναι υποχρεωτικό</div>');
                }
                isValid = false;
            } else {
                field.removeClass('is-invalid');
            }
        });
        
        var email = $('#email').val();
        if (email && !isValidEmail(email)) {
            $('#email').addClass('is-invalid');
            if (!$('#email').next('.invalid-feedback').length) {
                $('#email').after('<div class="invalid-feedback">Μη έγκυρη διεύθυνση email</div>');
            }
            isValid = false;
        }
        
        var amka = $('#amka').val();
        if (amka && amka.length !== 11) {
            $('#amka').addClass('is-invalid');
            if (!$('#amka').next('.invalid-feedback').length) {
                $('#amka').after('<div class="invalid-feedback">Το ΑΜΚΑ πρέπει να έχει 11 ψηφία</div>');
            }
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
        }
    });
    
    $('.form-control').on('input', function() {
        $(this).removeClass('is-invalid');
        $(this).next('.invalid-feedback').remove();
    });
    
    $('#phone_mobile, #phone_landline').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    $('#amka').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);
    });
    
    $('#postal_code').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 5);
    });
});

function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
</script>

<style>
.required:after {
    content: " *";
    color: red;
}

.form-group label {
    font-weight: 500;
    margin-bottom: 5px;
}

.card-header h6 {
    margin-bottom: 0;
}

.form-check {
    margin-top: 10px;
}

.text-primary {
    color: #4e73df !important;
}
</style>

<?php $this->endSection() ?>