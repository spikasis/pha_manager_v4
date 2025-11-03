<?= $this->extend('crud_templates/create') ?>

<?= $this->section('form_fields') ?>
<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Βασικά Στοιχεία</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="doc_name" class="form-label required">Όνομα Γιατρού</label>
                    <input type="text" 
                           class="form-control <?= isset($errors['doc_name']) ? 'is-invalid' : '' ?>" 
                           id="doc_name" 
                           name="doc_name" 
                           value="<?= set_value('doc_name') ?>" 
                           required 
                           maxlength="255"
                           placeholder="π.χ. Κομπότης Κωνσταντίνος">
                    <?php if (isset($errors['doc_name'])): ?>
                        <div class="invalid-feedback"><?= $errors['doc_name'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="doc_address" class="form-label">Διεύθυνση</label>
                    <input type="text" 
                           class="form-control <?= isset($errors['doc_address']) ? 'is-invalid' : '' ?>" 
                           id="doc_address" 
                           name="doc_address" 
                           value="<?= set_value('doc_address') ?>" 
                           maxlength="255"
                           placeholder="π.χ. ΓΕΩΡΓΑΝΤΑ 28">
                    <?php if (isset($errors['doc_address'])): ?>
                        <div class="invalid-feedback"><?= $errors['doc_address'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="doc_city" class="form-label">Πόλη</label>
                    <input type="text" 
                           class="form-control <?= isset($errors['doc_city']) ? 'is-invalid' : '' ?>" 
                           id="doc_city" 
                           name="doc_city" 
                           value="<?= set_value('doc_city') ?>" 
                           maxlength="255"
                           placeholder="π.χ. ΛΙΒΑΔΕΙΑ">
                    <?php if (isset($errors['doc_city'])): ?>
                        <div class="invalid-feedback"><?= $errors['doc_city'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Επικοινωνία & Τιμολόγηση</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="doc_phone_work" class="form-label">Τηλέφωνο Εργασίας</label>
                    <input type="tel" 
                           class="form-control <?= isset($errors['doc_phone_work']) ? 'is-invalid' : '' ?>" 
                           id="doc_phone_work" 
                           name="doc_phone_work" 
                           value="<?= set_value('doc_phone_work') ?>" 
                           maxlength="255"
                           placeholder="π.χ. 2261080444">
                    <?php if (isset($errors['doc_phone_work'])): ?>
                        <div class="invalid-feedback"><?= $errors['doc_phone_work'] ?></div>
                    <?php endif; ?>
                    <small class="form-text text-muted">Μπορείτε να εισάγετε σταθερό τηλέφωνο ή αριθμό επαγγελματικού κινητού</small>
                </div>

                <div class="form-group">
                    <label for="doc_phone_mobile" class="form-label">Κινητό Τηλέφωνο</label>
                    <input type="tel" 
                           class="form-control <?= isset($errors['doc_phone_mobile']) ? 'is-invalid' : '' ?>" 
                           id="doc_phone_mobile" 
                           name="doc_phone_mobile" 
                           value="<?= set_value('doc_phone_mobile') ?>" 
                           maxlength="10"
                           placeholder="π.χ. 6932964813">
                    <?php if (isset($errors['doc_phone_mobile'])): ?>
                        <div class="invalid-feedback"><?= $errors['doc_phone_mobile'] ?></div>
                    <?php endif; ?>
                    <small class="form-text text-muted">Προσωπικό κινητό τηλέφωνο (έως 10 ψηφία)</small>
                </div>

                <div class="form-group">
                    <label for="doc_price" class="form-label">Τιμή (€)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">€</span>
                        </div>
                        <input type="number" 
                               class="form-control <?= isset($errors['doc_price']) ? 'is-invalid' : '' ?>" 
                               id="doc_price" 
                               name="doc_price" 
                               value="<?= set_value('doc_price') ?>" 
                               min="0" 
                               step="0.01"
                               placeholder="π.χ. 200.00">
                        <?php if (isset($errors['doc_price'])): ?>
                            <div class="invalid-feedback"><?= $errors['doc_price'] ?></div>
                        <?php endif; ?>
                    </div>
                    <small class="form-text text-muted">Η τιμή παραμένει προαιρετική</small>
                </div>
            </div>
        </div>
        
        <!-- Quick Tips Card -->
        <div class="card border-left-info shadow mb-4">
            <div class="card-body">
                <h6 class="text-primary mb-3"><i class="fas fa-lightbulb mr-1"></i> Συμβουλές</h6>
                <ul class="mb-0 text-sm">
                    <li>Μόνο το <strong>όνομα γιατρού</strong> είναι υποχρεωτικό</li>
                    <li>Τα τηλέφωνα θα καθαριστούν αυτόματα από ειδικούς χαρακτήρες</li>
                    <li>Τα ονόματα και οι πόλεις θα μορφοποιηθούν αυτόματα</li>
                    <li>Η τιμή μπορεί να οριστεί αργότερα εάν δεν είναι γνωστή</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('additional_scripts') ?>
<script>
$(document).ready(function() {
    // Auto-format phone numbers as user types
    $('#doc_phone_work, #doc_phone_mobile').on('input', function() {
        let value = $(this).val().replace(/[^0-9]/g, '');
        $(this).val(value);
    });
    
    // Capitalize first letter of name and city fields
    $('#doc_name, #doc_city').on('blur', function() {
        let value = $(this).val().trim();
        if (value) {
            $(this).val(value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase()));
        }
    });
    
    // Price validation
    $('#doc_price').on('input', function() {
        let value = parseFloat($(this).val());
        if (value < 0) {
            $(this).val(0);
        }
    });
});
</script>
<?= $this->endSection() ?>