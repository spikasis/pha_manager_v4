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

    <!-- Restocking Alert -->
    <?php if ($is_edit && isset($needs_restocking) && $needs_restocking): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Ειδοποίηση Χαμηλού Αποθέματος!</strong>
            Αυτό το προϊόν χρειάζεται αναπλήρωση. Η τρέχουσα ποσότητα είναι κάτω από το ελάχιστο όριο.
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
                        <?= $is_edit ? 'Επεξεργασία' : 'Δημιουργία' ?> Προϊόντος Αποθήκης
                    </h6>
                </div>
                
                <div class="card-body">
                    <?= form_open($form_action, ['id' => 'stockForm', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                    
                        <!-- Basic Information Section -->
                        <div class="form-section mb-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-info-circle"></i> Βασικές Πληροφορίες
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Name Field -->
                                    <?php 
                                    $field_name = 'name';
                                    $field_config = $form_fields[$field_name];
                                    $field_value = $form_data[$field_name] ?? '';
                                    $validation_errors = session()->getFlashdata('errors') ?? [];
                                    $has_error = isset($validation_errors[$field_name]);
                                    ?>
                                    <div class="mb-3">
                                        <label for="<?= $field_name ?>" class="form-label">
                                            <?= $field_config['label'] ?>
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                               id="<?= $field_name ?>" 
                                               name="<?= $field_name ?>" 
                                               value="<?= esc($field_value) ?>"
                                               required
                                               <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                                   <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                               <?php endforeach; ?>>
                                        <?php if ($has_error): ?>
                                            <div class="invalid-feedback"><?= $validation_errors[$field_name] ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($field_config['help'])): ?>
                                            <div class="form-text"><?= $field_config['help'] ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <!-- Category Field -->
                                    <?php 
                                    $field_name = 'category';
                                    $field_config = $form_fields[$field_name];
                                    $field_value = $form_data[$field_name] ?? '';
                                    $has_error = isset($validation_errors[$field_name]);
                                    ?>
                                    <div class="mb-3">
                                        <label for="<?= $field_name ?>" class="form-label"><?= $field_config['label'] ?></label>
                                        <select class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                                id="<?= $field_name ?>" 
                                                name="<?= $field_name ?>">
                                            <?php foreach ($field_config['options'] as $option_value => $option_label): ?>
                                                <option value="<?= esc($option_value) ?>" 
                                                        <?= $field_value == $option_value ? 'selected' : '' ?>>
                                                    <?= esc($option_label) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if ($has_error): ?>
                                            <div class="invalid-feedback"><?= $validation_errors[$field_name] ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <?php 
                            $field_name = 'description';
                            $field_config = $form_fields[$field_name];
                            $field_value = $form_data[$field_name] ?? '';
                            $has_error = isset($validation_errors[$field_name]);
                            ?>
                            <div class="mb-3">
                                <label for="<?= $field_name ?>" class="form-label"><?= $field_config['label'] ?></label>
                                <textarea class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                          id="<?= $field_name ?>" 
                                          name="<?= $field_name ?>"
                                          <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                              <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                          <?php endforeach; ?>><?= esc($field_value) ?></textarea>
                                <?php if ($has_error): ?>
                                    <div class="invalid-feedback"><?= $validation_errors[$field_name] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Product Details Section -->
                        <div class="form-section mb-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-barcode"></i> Στοιχεία Προϊόντος
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Manufacturer -->
                                    <?php 
                                    $field_name = 'manufacturer';
                                    $field_config = $form_fields[$field_name];
                                    $field_value = $form_data[$field_name] ?? '';
                                    $has_error = isset($validation_errors[$field_name]);
                                    ?>
                                    <div class="mb-3">
                                        <label for="<?= $field_name ?>" class="form-label"><?= $field_config['label'] ?></label>
                                        <input type="text" 
                                               class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                               id="<?= $field_name ?>" 
                                               name="<?= $field_name ?>" 
                                               value="<?= esc($field_value) ?>"
                                               <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                                   <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                               <?php endforeach; ?>>
                                        <?php if ($has_error): ?>
                                            <div class="invalid-feedback"><?= $validation_errors[$field_name] ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <!-- SKU -->
                                    <?php 
                                    $field_name = 'sku';
                                    $field_config = $form_fields[$field_name];
                                    $field_value = $form_data[$field_name] ?? '';
                                    $has_error = isset($validation_errors[$field_name]);
                                    ?>
                                    <div class="mb-3">
                                        <label for="<?= $field_name ?>" class="form-label"><?= $field_config['label'] ?></label>
                                        <input type="text" 
                                               class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                               id="<?= $field_name ?>" 
                                               name="<?= $field_name ?>" 
                                               value="<?= esc($field_value) ?>"
                                               <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                                   <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                               <?php endforeach; ?>>
                                        <?php if ($has_error): ?>
                                            <div class="invalid-feedback"><?= $validation_errors[$field_name] ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <!-- Barcode -->
                                    <?php 
                                    $field_name = 'barcode';
                                    $field_config = $form_fields[$field_name];
                                    $field_value = $form_data[$field_name] ?? '';
                                    $has_error = isset($validation_errors[$field_name]);
                                    ?>
                                    <div class="mb-3">
                                        <label for="<?= $field_name ?>" class="form-label"><?= $field_config['label'] ?></label>
                                        <input type="text" 
                                               class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                               id="<?= $field_name ?>" 
                                               name="<?= $field_name ?>" 
                                               value="<?= esc($field_value) ?>"
                                               <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                                   <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                               <?php endforeach; ?>>
                                        <?php if ($has_error): ?>
                                            <div class="invalid-feedback"><?= $validation_errors[$field_name] ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Section -->
                        <div class="form-section mb-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-euro-sign"></i> Τιμές
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Cost Price -->
                                    <?php 
                                    $field_name = 'cost_price';
                                    $field_config = $form_fields[$field_name];
                                    $field_value = $form_data[$field_name] ?? '';
                                    $has_error = isset($validation_errors[$field_name]);
                                    ?>
                                    <div class="mb-3">
                                        <label for="<?= $field_name ?>" class="form-label"><?= $field_config['label'] ?></label>
                                        <div class="input-group">
                                            <span class="input-group-text">€</span>
                                            <input type="number" 
                                                   class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                                   id="<?= $field_name ?>" 
                                                   name="<?= $field_name ?>" 
                                                   value="<?= esc($field_value) ?>"
                                                   <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                                       <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                                   <?php endforeach; ?>>
                                        </div>
                                        <?php if ($has_error): ?>
                                            <div class="invalid-feedback"><?= $validation_errors[$field_name] ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <!-- Unit Price -->
                                    <?php 
                                    $field_name = 'unit_price';
                                    $field_config = $form_fields[$field_name];
                                    $field_value = $form_data[$field_name] ?? '';
                                    $has_error = isset($validation_errors[$field_name]);
                                    ?>
                                    <div class="mb-3">
                                        <label for="<?= $field_name ?>" class="form-label"><?= $field_config['label'] ?></label>
                                        <div class="input-group">
                                            <span class="input-group-text">€</span>
                                            <input type="number" 
                                                   class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                                   id="<?= $field_name ?>" 
                                                   name="<?= $field_name ?>" 
                                                   value="<?= esc($field_value) ?>"
                                                   <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                                       <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                                   <?php endforeach; ?>>
                                        </div>
                                        <?php if ($has_error): ?>
                                            <div class="invalid-feedback"><?= $validation_errors[$field_name] ?></div>
                                        <?php endif; ?>
                                        <div id="profit-margin" class="form-text"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Inventory Section -->
                        <div class="form-section mb-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-warehouse"></i> Διαχείριση Αποθέματος
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Quantity -->
                                    <?php 
                                    $field_name = 'quantity';
                                    $field_config = $form_fields[$field_name];
                                    $field_value = $form_data[$field_name] ?? '0';
                                    $has_error = isset($validation_errors[$field_name]);
                                    ?>
                                    <div class="mb-3">
                                        <label for="<?= $field_name ?>" class="form-label">
                                            <?= $field_config['label'] ?>
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" 
                                               class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                               id="<?= $field_name ?>" 
                                               name="<?= $field_name ?>" 
                                               value="<?= esc($field_value) ?>"
                                               required
                                               <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                                   <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                               <?php endforeach; ?>>
                                        <?php if ($has_error): ?>
                                            <div class="invalid-feedback"><?= $validation_errors[$field_name] ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <!-- Min Quantity -->
                                    <?php 
                                    $field_name = 'min_quantity';
                                    $field_config = $form_fields[$field_name];
                                    $field_value = $form_data[$field_name] ?? '';
                                    $has_error = isset($validation_errors[$field_name]);
                                    ?>
                                    <div class="mb-3">
                                        <label for="<?= $field_name ?>" class="form-label"><?= $field_config['label'] ?></label>
                                        <input type="number" 
                                               class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                               id="<?= $field_name ?>" 
                                               name="<?= $field_name ?>" 
                                               value="<?= esc($field_value) ?>"
                                               <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                                   <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                               <?php endforeach; ?>>
                                        <?php if ($has_error): ?>
                                            <div class="invalid-feedback"><?= $validation_errors[$field_name] ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <!-- Max Quantity -->
                                    <?php 
                                    $field_name = 'max_quantity';
                                    $field_config = $form_fields[$field_name];
                                    $field_value = $form_data[$field_name] ?? '';
                                    $has_error = isset($validation_errors[$field_name]);
                                    ?>
                                    <div class="mb-3">
                                        <label for="<?= $field_name ?>" class="form-label"><?= $field_config['label'] ?></label>
                                        <input type="number" 
                                               class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                               id="<?= $field_name ?>" 
                                               name="<?= $field_name ?>" 
                                               value="<?= esc($field_value) ?>"
                                               <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                                   <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                               <?php endforeach; ?>>
                                        <?php if ($has_error): ?>
                                            <div class="invalid-feedback"><?= $validation_errors[$field_name] ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location & Status Section -->
                        <div class="form-section mb-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-map-marker-alt"></i> Τοποθεσία & Κατάσταση
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Location -->
                                    <?php 
                                    $field_name = 'location';
                                    $field_config = $form_fields[$field_name];
                                    $field_value = $form_data[$field_name] ?? '';
                                    $has_error = isset($validation_errors[$field_name]);
                                    ?>
                                    <div class="mb-3">
                                        <label for="<?= $field_name ?>" class="form-label"><?= $field_config['label'] ?></label>
                                        <input type="text" 
                                               class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                               id="<?= $field_name ?>" 
                                               name="<?= $field_name ?>" 
                                               value="<?= esc($field_value) ?>"
                                               <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                                   <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                               <?php endforeach; ?>>
                                        <?php if ($has_error): ?>
                                            <div class="invalid-feedback"><?= $validation_errors[$field_name] ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <!-- Is Active -->
                                    <?php 
                                    $field_name = 'is_active';
                                    $field_config = $form_fields[$field_name];
                                    $field_value = $form_data[$field_name] ?? '1';
                                    $has_error = isset($validation_errors[$field_name]);
                                    ?>
                                    <div class="mb-3">
                                        <label for="<?= $field_name ?>" class="form-label">
                                            <?= $field_config['label'] ?>
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                                id="<?= $field_name ?>" 
                                                name="<?= $field_name ?>"
                                                required>
                                            <?php foreach ($field_config['options'] as $option_value => $option_label): ?>
                                                <option value="<?= esc($option_value) ?>" 
                                                        <?= $field_value == $option_value ? 'selected' : '' ?>>
                                                    <?= esc($option_label) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if ($has_error): ?>
                                            <div class="invalid-feedback"><?= $validation_errors[$field_name] ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes Section -->
                        <div class="form-section mb-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-sticky-note"></i> Σημειώσεις
                            </h6>
                            
                            <!-- Notes -->
                            <?php 
                            $field_name = 'notes';
                            $field_config = $form_fields[$field_name];
                            $field_value = $form_data[$field_name] ?? '';
                            $has_error = isset($validation_errors[$field_name]);
                            ?>
                            <div class="mb-3">
                                <label for="<?= $field_name ?>" class="form-label"><?= $field_config['label'] ?></label>
                                <textarea class="form-control<?= $has_error ? ' is-invalid' : '' ?>" 
                                          id="<?= $field_name ?>" 
                                          name="<?= $field_name ?>"
                                          <?php foreach ($field_config['attributes'] ?? [] as $attr => $val): ?>
                                              <?php if ($attr !== 'value'): ?><?= $attr ?>="<?= esc($val) ?>"<?php endif; ?>
                                          <?php endforeach; ?>><?= esc($field_value) ?></textarea>
                                <?php if ($has_error): ?>
                                    <div class="invalid-feedback"><?= $validation_errors[$field_name] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
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
                        Οδηγίες Inventory
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <h6 class="text-dark">Συμβουλές Διαχείρισης:</h6>
                        <ul class="mb-3">
                            <li><strong>SKU:</strong> Μοναδικός κωδικός για εύκολη αναφορά</li>
                            <li><strong>Ελάχιστη Ποσότητα:</strong> Ορίστε για αυτόματες ειδοποιήσεις</li>
                            <li><strong>Τοποθεσία:</strong> Βοηθά στον εντοπισμό προϊόντων</li>
                            <li><strong>Τιμές:</strong> Κόστος για κερδοφορία, πώληση για πελάτες</li>
                        </ul>
                        
                        <h6 class="text-dark">Κατηγορίες Προϊόντων:</h6>
                        <div class="mb-2"><span class="badge bg-primary">Ακουστικά Βαρηκοΐας</span></div>
                        <div class="mb-2"><span class="badge bg-info">Αξεσουάρ</span></div>
                        <div class="mb-2"><span class="badge bg-warning">Μπαταρίες</span></div>
                        <div class="mb-2"><span class="badge bg-success">Εργαλεία</span></div>
                        
                        <?php if ($is_edit): ?>
                        <hr>
                        <h6 class="text-dark">Πληροφορίες Επεξεργασίας:</h6>
                        <p class="mb-2"><strong>ID:</strong> <?= $record_id ?? 'N/A' ?></p>
                        <?php if (isset($form_data['created_at'])): ?>
                        <p class="mb-0"><strong>Δημιουργήθηκε:</strong><br> 
                            <small><?= date('d/m/Y H:i', strtotime($form_data['created_at'])) ?></small>
                        </p>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Profit Calculation Card -->
            <div class="card shadow mb-4" id="profit-card" style="display: none;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-chart-line"></i>
                        Ανάλυση Κερδοφορίας
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="h4 mb-0 font-weight-bold text-success" id="profit-percentage">0%</div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Περιθώριο Κέρδους</div>
                        <hr>
                        <div class="small">
                            <p class="mb-1"><strong>Κόστος:</strong> €<span id="display-cost">0.00</span></p>
                            <p class="mb-1"><strong>Πώληση:</strong> €<span id="display-price">0.00</span></p>
                            <p class="mb-0"><strong>Κέρδος:</strong> €<span id="display-profit">0.00</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Form validation
    const form = document.getElementById('stockForm');
    
    // Bootstrap validation
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
    
    // Profit calculation
    function calculateProfit() {
        const costPrice = parseFloat($('#cost_price').val()) || 0;
        const unitPrice = parseFloat($('#unit_price').val()) || 0;
        
        if (costPrice > 0 && unitPrice > 0) {
            const profit = unitPrice - costPrice;
            const profitPercentage = ((profit / costPrice) * 100);
            
            $('#display-cost').text(costPrice.toFixed(2));
            $('#display-price').text(unitPrice.toFixed(2));
            $('#display-profit').text(profit.toFixed(2));
            $('#profit-percentage').text(profitPercentage.toFixed(1) + '%');
            
            // Update profit margin text
            $('#profit-margin').html('<i class="fas fa-chart-line"></i> Περιθώριο κέρδους: ' + profitPercentage.toFixed(1) + '%');
            
            // Show profit card
            $('#profit-card').show();
            
            // Color coding
            if (profitPercentage < 10) {
                $('#profit-percentage').removeClass('text-success text-warning').addClass('text-danger');
            } else if (profitPercentage < 25) {
                $('#profit-percentage').removeClass('text-success text-danger').addClass('text-warning');
            } else {
                $('#profit-percentage').removeClass('text-danger text-warning').addClass('text-success');
            }
        } else {
            $('#profit-card').hide();
            $('#profit-margin').text('');
        }
    }
    
    // Bind profit calculation to price changes
    $('#cost_price, #unit_price').on('input change', calculateProfit);
    
    // Initial calculation
    calculateProfit();
    
    // Inventory validation
    $('#quantity, #min_quantity, #max_quantity').on('input', function() {
        const quantity = parseInt($('#quantity').val()) || 0;
        const minQuantity = parseInt($('#min_quantity').val()) || 0;
        const maxQuantity = parseInt($('#max_quantity').val()) || 0;
        
        // Check if quantity is below minimum
        if (minQuantity > 0 && quantity <= minQuantity) {
            $('#quantity').addClass('border-warning');
            $('#quantity').next('.form-text').remove();
            $('#quantity').after('<div class="form-text text-warning"><i class="fas fa-exclamation-triangle"></i> Η ποσότητα είναι κάτω από το ελάχιστο όριο!</div>');
        } else {
            $('#quantity').removeClass('border-warning');
            $('#quantity').next('.text-warning').remove();
        }
        
        // Check if max is less than min
        if (maxQuantity > 0 && minQuantity > 0 && maxQuantity < minQuantity) {
            $('#max_quantity').addClass('border-warning');
            $('#max_quantity').next('.form-text').remove();
            $('#max_quantity').after('<div class="form-text text-warning"><i class="fas fa-exclamation-triangle"></i> Η μέγιστη ποσότητα πρέπει να είναι μεγαλύτερη από την ελάχιστη!</div>');
        } else {
            $('#max_quantity').removeClass('border-warning');
            $('#max_quantity').next('.text-warning').remove();
        }
    });
    
    // AJAX form submission
    $('#stockForm').on('submit', function(e) {
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
    
    // Auto-resize textareas
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
.form-section {
    background-color: #f8f9fc;
    padding: 1rem;
    border-radius: 0.375rem;
    border: 1px solid #e3e6f0;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.form-control.is-invalid:focus {
    border-color: #e74a3b;
    box-shadow: 0 0 0 0.2rem rgba(231, 74, 59, 0.25);
}

/* Input group styling */
.input-group-text {
    background-color: #e9ecef;
    border-color: #ced4da;
}

/* Border warning for inventory alerts */
.border-warning {
    border-color: #f6c23e !important;
}

/* Badge styling */
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

/* Profit card animations */
#profit-card {
    transition: all 0.3s ease;
}

/* Section headers */
.form-section h6 {
    margin-bottom: 1rem;
}

.form-section h6 i {
    margin-right: 0.5rem;
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

/* Responsive form sections */
@media (max-width: 768px) {
    .form-section {
        padding: 0.75rem;
    }
    
    .col-md-3, .col-md-4, .col-md-6, .col-md-8 {
        margin-bottom: 1rem;
    }
}
</style>