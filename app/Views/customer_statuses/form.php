<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="<?= $entity_config['icon'] ?>"></i>
                <?= $title ?>
            </h1>
            <p class="mb-0 text-gray-600"><?= $subtitle ?></p>
        </div>
        
        <a href="<?= $cancel_url ?>" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> 
            Επιστροφή
        </a>
    </div>

    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <?php foreach ($breadcrumbs as $name => $url): ?>
                <?php if ($url): ?>
                    <li class="breadcrumb-item">
                        <a href="<?= $url ?>" class="text-decoration-none"><?= $name ?></a>
                    </li>
                <?php else: ?>
                    <li class="breadcrumb-item active" aria-current="page"><?= $name ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ol>
    </nav>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Σφάλματα επικύρωσης:</strong>
            <ul class="mb-0 mt-2">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8 col-md-10">
            <!-- Main Form Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-<?= $is_edit ? 'edit' : 'plus' ?>"></i>
                        <?= $is_edit ? 'Επεξεργασία' : 'Δημιουργία' ?> Κατάστασης Πελάτη
                    </h6>
                </div>
                
                <div class="card-body">
                    <?= form_open($form_action, ['id' => 'customerStatusForm', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                    
                        <?php foreach ($form_fields as $field_name => $field_config): ?>
                            <div class="mb-3">
                                <label for="<?= $field_name ?>" class="form-label">
                                    <?= $field_config['label'] ?>
                                    <?php if ($field_config['required']): ?>
                                        <span class="text-danger">*</span>
                                    <?php endif; ?>
                                </label>
                                
                                <?php 
                                // Get field value from form_data or use default
                                $field_value = $form_data[$field_name] ?? $field_config['attributes']['value'] ?? '';
                                $validation_errors = session()->getFlashdata('errors') ?? [];
                                $has_error = isset($validation_errors[$field_name]);
                                ?>
                                
                                <?php if ($field_config['type'] === 'text'): ?>
                                    <input type="text" 
                                           class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                           id="<?= $field_name ?>" 
                                           name="<?= $field_name ?>" 
                                           value="<?= esc($field_value) ?>"
                                           <?php if ($field_config['required']): ?>required<?php endif; ?>
                                           <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                               <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                           <?php endforeach; ?>>
                                
                                <?php elseif ($field_config['type'] === 'textarea'): ?>
                                    <textarea class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                              id="<?= $field_name ?>" 
                                              name="<?= $field_name ?>"
                                              <?php if ($field_config['required']): ?>required<?php endif; ?>
                                              <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                                  <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                              <?php endforeach; ?>><?= esc($field_value) ?></textarea>
                                
                                <?php elseif ($field_config['type'] === 'select'): ?>
                                    <select class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                            id="<?= $field_name ?>" 
                                            name="<?= $field_name ?>"
                                            <?php if ($field_config['required']): ?>required<?php endif; ?>
                                            <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                                <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                            <?php endforeach; ?>>
                                        <?php foreach ($field_config['options'] as $option_value => $option_label): ?>
                                            <option value="<?= esc($option_value) ?>" 
                                                    <?= $field_value == $option_value ? 'selected' : '' ?>>
                                                <?= esc($option_label) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                
                                <?php elseif ($field_config['type'] === 'color'): ?>
                                    <div class="input-group">
                                        <input type="color" 
                                               class="form-control form-control-color<?= $has_error ? ' is-invalid' : '' ?>" 
                                               id="<?= $field_name ?>" 
                                               name="<?= $field_name ?>" 
                                               value="<?= esc($field_value ?: '#007bff') ?>"
                                               <?php if ($field_config['required']): ?>required<?php endif; ?>
                                               <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                                   <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                               <?php endforeach; ?>>
                                        <input type="text" 
                                               class="form-control" 
                                               id="<?= $field_name ?>_text" 
                                               value="<?= esc($field_value ?: '#007bff') ?>"
                                               readonly>
                                    </div>
                                
                                <?php endif; ?>
                                
                                <?php if ($has_error): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation_errors[$field_name] ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($field_config['help'])): ?>
                                    <div class="form-text"><?= $field_config['help'] ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        
                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div class="text-muted small">
                                <i class="fas fa-info-circle"></i>
                                Τα πεδία με <span class="text-danger">*</span> είναι υποχρεωτικά
                            </div>
                            
                            <div>
                                <a href="<?= $cancel_url ?>" class="btn btn-secondary me-2">
                                    <i class="fas fa-times"></i> Ακύρωση
                                </a>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-save"></i> 
                                    <?= $is_edit ? 'Ενημέρωση' : 'Δημιουργία' ?>
                                </button>
                            </div>
                        </div>
                    
                    <?= form_close() ?>
                </div>
            </div>
        </div>
        
        <!-- Info Sidebar -->
        <div class="col-lg-4 col-md-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i>
                        Πληροφορίες
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <h6 class="text-dark">Οδηγίες:</h6>
                        <ul class="mb-3">
                            <li>Δώστε ένα περιγραφικό όνομα για την κατάσταση</li>
                            <li>Η περιγραφή βοηθά στην κατανόηση της χρήσης</li>
                            <li>Το χρώμα χρησιμοποιείται για οπτική διαφοροποίηση</li>
                            <li>Μόνο οι ενεργές καταστάσεις εμφανίζονται στις φόρμες</li>
                        </ul>
                        
                        <h6 class="text-dark">Παραδείγματα:</h6>
                        <div class="mb-2">
                            <span class="badge bg-success">Ενεργός Πελάτης</span>
                        </div>
                        <div class="mb-2">
                            <span class="badge bg-warning">Υποψήφιος</span>
                        </div>
                        <div class="mb-2">
                            <span class="badge bg-secondary">Ανενεργός</span>
                        </div>
                        <div class="mb-2">
                            <span class="badge bg-info">Δοκιμή</span>
                        </div>
                        
                        <?php if ($is_edit): ?>
                        <hr>
                        <h6 class="text-dark">Επεξεργασία:</h6>
                        <p class="mb-0">Οι αλλαγές θα επηρεάσουν όλους τους πελάτες που χρησιμοποιούν αυτήν την κατάσταση.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Form validation
    const form = document.getElementById('customerStatusForm');
    
    // Bootstrap validation
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
    
    // Color picker sync
    $('#color').on('input', function() {
        $('#color_text').val($(this).val());
    });
    
    $('#color_text').on('input', function() {
        const color = $(this).val();
        if (/^#[0-9A-Fa-f]{6}$/.test(color)) {
            $('#color').val(color);
        }
    });
    
    // AJAX form submission
    $('#customerStatusForm').on('submit', function(e) {
        e.preventDefault();
        
        if (!form.checkValidity()) {
            return false;
        }
        
        const $submitBtn = $('#submitBtn');
        const originalText = $submitBtn.html();
        
        // Show loading state
        $submitBtn.prop('disabled', true)
                  .html('<i class="fas fa-spinner fa-spin"></i> Αποθήκευση...');
        
        // Clear previous alerts
        $('.alert').remove();
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showAlert('success', response.message);
                    
                    // Redirect after short delay
                    setTimeout(function() {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            window.location.href = '<?= $cancel_url ?>';
                        }
                    }, 1500);
                } else {
                    // Show error message
                    showAlert('error', response.message || 'Σφάλμα κατά την αποθήκευση');
                    
                    // Handle validation errors
                    if (response.errors) {
                        handleValidationErrors(response.errors);
                    }
                }
            },
            error: function(xhr) {
                let message = 'Σφάλμα κατά την αποθήκευση';
                
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors) {
                        handleValidationErrors(xhr.responseJSON.errors);
                        message = 'Σφάλματα επικύρωσης δεδομένων';
                    }
                }
                
                showAlert('error', message);
            },
            complete: function() {
                // Restore button
                $submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    // Handle validation errors
    function handleValidationErrors(errors) {
        // Clear previous error states
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        
        // Add error states
        $.each(errors, function(field, message) {
            const $field = $('[name="' + field + '"]');
            $field.addClass('is-invalid');
            $field.after('<div class="invalid-feedback">' + message + '</div>');
        });
    }
    
    // Alert function
    function showAlert(type, message) {
        const alertType = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';
        
        const alert = `
            <div class="alert ${alertType} alert-dismissible fade show" role="alert">
                <i class="${icon}"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Add alert at the top of the container
        $('.container-fluid').prepend(alert);
        
        // Scroll to top
        $('html, body').animate({ scrollTop: 0 }, 500);
        
        // Auto hide success messages
        if (type === 'success') {
            setTimeout(function() {
                $('.alert-success').fadeOut();
            }, 3000);
        }
    }
    
    // Auto-resize textarea
    $('textarea').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>

<style>
/* Custom form styling */
.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.form-control.is-invalid:focus {
    border-color: #e74a3b;
    box-shadow: 0 0 0 0.2rem rgba(231, 74, 59, 0.25);
}

/* Color picker styling */
.form-control-color {
    max-width: 60px;
    padding: 0.375rem;
    border-radius: 0.375rem 0 0 0.375rem;
}

.input-group .form-control:last-child {
    border-radius: 0 0.375rem 0.375rem 0;
}

/* Badge examples styling */
.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

/* Button loading state */
.btn:disabled {
    opacity: 0.7;
}

/* Required field indicator */
.text-danger {
    font-weight: 600;
}

/* Info sidebar adjustments */
@media (max-width: 991px) {
    .col-lg-4 {
        margin-top: 1rem;
    }
}

/* Form validation feedback */
.was-validated .form-control:valid {
    border-color: #1cc88a;
}

.was-validated .form-control:valid:focus {
    border-color: #1cc88a;
    box-shadow: 0 0 0 0.2rem rgba(28, 200, 138, 0.25);
}
</style>