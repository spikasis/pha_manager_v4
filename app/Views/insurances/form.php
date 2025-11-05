<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .form-card {
        border-radius: 15px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        border: none;
    }
    
    .form-header {
        background: linear-gradient(45deg, #4e73df, #36b9cc);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 20px;
    }
    
    .form-control {
        border-radius: 10px;
        border: 1px solid #d1d3e2;
        padding: 12px 15px;
    }
    
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    .btn {
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: 600;
    }
    
    .required-field {
        color: #e74a3b;
    }
    
    .form-help {
        color: #858796;
        font-size: 0.875rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card form-card">
            <div class="form-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-1">
                            <i class="fas fa-shield-alt me-2"></i>
                            <?= isset($form_data) ? 'Επεξεργασία Ασφαλιστικού Ταμείου' : 'Νέο Ασφαλιστικό Ταμείο' ?>
                        </h4>
                        <p class="mb-0 opacity-75">
                            <?= isset($form_data) ? 'Επεξεργαστείτε τα στοιχεία του ασφαλιστικού ταμείου' : 'Προσθέστε νέο ασφαλιστικό ταμείο στη βάση δεδομένων' ?>
                        </p>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-medical fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4">
                <?= form_open($form_action, ['method' => $form_method ?? 'POST', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <?= csrf_field() ?>
                
                <?php if (isset($form_method) && $form_method === 'PUT'): ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php endif; ?>
                
                <!-- Name Field -->
                <div class="mb-4">
                    <label for="name" class="form-label">
                        <?= $form_fields['name']['label'] ?>
                        <?php if ($form_fields['name']['required']): ?>
                            <span class="required-field">*</span>
                        <?php endif; ?>
                    </label>
                    
                    <input type="text" 
                           class="form-control <?= isset($validation) && $validation->hasError('name') ? 'is-invalid' : '' ?>" 
                           id="name" 
                           name="name" 
                           value="<?= old('name', $form_data['name'] ?? '') ?>"
                           placeholder="<?= $form_fields['name']['attributes']['placeholder'] ?? '' ?>"
                           maxlength="<?= $form_fields['name']['attributes']['maxlength'] ?? '' ?>"
                           <?= $form_fields['name']['required'] ? 'required' : '' ?>>
                    
                    <?php if (isset($validation) && $validation->hasError('name')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('name') ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($form_fields['name']['help'])): ?>
                        <div class="form-text form-help">
                            <?= $form_fields['name']['help'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Form Actions -->
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>
                            <?= isset($form_data) ? 'Ενημέρωση' : 'Αποθήκευση' ?>
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= $cancel_url ?>" class="btn btn-secondary w-100">
                            <i class="fas fa-times me-2"></i>
                            Άκυρο
                        </a>
                    </div>
                </div>
                
                <?= form_close() ?>
            </div>
        </div>
        
        <!-- Help Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-info-circle"></i> Οδηγίες
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Παραδείγματα Ασφαλιστικών Ταμείων:</h6>
                        <ul class="list-unstyled text-muted">
                            <li><i class="fas fa-check text-success"></i> ΙΚΑ</li>
                            <li><i class="fas fa-check text-success"></i> ΟΑΕΕ</li>
                            <li><i class="fas fa-check text-success"></i> ΟΠΑΔ</li>
                            <li><i class="fas fa-check text-success"></i> ΤΕΒΕ</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Σημεισώσεις:</h6>
                        <ul class="list-unstyled text-muted">
                            <li><i class="fas fa-info text-info"></i> Μέγιστο 25 χαρακτήρες</li>
                            <li><i class="fas fa-info text-info"></i> Μοναδικό όνομα</li>
                            <li><i class="fas fa-info text-info"></i> Χρησιμοποιείται για πελάτες</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Form validation
    const form = document.querySelector('.needs-validation');
    
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        form.classList.add('was-validated');
    });
    
    // Real-time validation for name field
    $('#name').on('input blur', function() {
        const value = $(this).val().trim();
        const field = $(this);
        
        // Clear previous validation
        field.removeClass('is-valid is-invalid');
        field.next('.invalid-feedback').remove();
        
        if (value.length === 0) {
            if ($(this).prop('required')) {
                field.addClass('is-invalid');
                field.after('<div class="invalid-feedback">Το όνομα είναι υποχρεωτικό</div>');
            }
        } else if (value.length < 2) {
            field.addClass('is-invalid');
            field.after('<div class="invalid-feedback">Το όνομα πρέπει να έχει τουλάχιστον 2 χαρακτήρες</div>');
        } else if (value.length > 25) {
            field.addClass('is-invalid');
            field.after('<div class="invalid-feedback">Το όνομα δεν μπορεί να ξεπερνά τους 25 χαρακτήρες</div>');
        } else {
            field.addClass('is-valid');
        }
    });
    
    // Auto-focus first field
    $('#name').focus();
});
</script>
<?= $this->endSection() ?>