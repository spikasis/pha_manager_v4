<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-cog me-2"></i>
            Γενικές Ρυθμίσεις Συστήματος
        </h6>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Οι ρυθμίσεις θα εφαρμοστούν σε όλο το σύστημα και θα επηρεάσουν όλους τους χρήστες.
        </div>

        <?= form_open('settings/general', ['class' => 'user']) ?>
        
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-primary mb-3">Βασικές Ρυθμίσεις</h5>
                
                <div class="form-group mb-3">
                    <label for="company_name" class="form-label">Όνομα Εταιρείας</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" 
                           value="Pikas Hearing Aid Center" required>
                </div>

                <div class="form-group mb-3">
                    <label for="company_address" class="form-label">Διεύθυνση Εταιρείας</label>
                    <textarea class="form-control" id="company_address" name="company_address" rows="3">Θήβα, Βοιωτία</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="company_phone" class="form-label">Τηλέφωνο Εταιρείας</label>
                    <input type="text" class="form-control" id="company_phone" name="company_phone" 
                           value="22620-12345">
                </div>

                <div class="form-group mb-3">
                    <label for="company_email" class="form-label">Email Εταιρείας</label>
                    <input type="email" class="form-control" id="company_email" name="company_email" 
                           value="info@pikasishearing.gr">
                </div>
            </div>

            <div class="col-md-6">
                <h5 class="text-primary mb-3">Ρυθμίσεις Συστήματος</h5>
                
                <div class="form-group mb-3">
                    <label for="default_language" class="form-label">Προεπιλεγμένη Γλώσσα</label>
                    <select class="form-control" id="default_language" name="default_language">
                        <option value="el" selected>Ελληνικά</option>
                        <option value="en">English</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="timezone" class="form-label">Ζώνη Ώρας</label>
                    <select class="form-control" id="timezone" name="timezone">
                        <option value="Europe/Athens" selected>Europe/Athens (UTC+2)</option>
                        <option value="UTC">UTC</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="date_format" class="form-label">Μορφή Ημερομηνίας</label>
                    <select class="form-control" id="date_format" name="date_format">
                        <option value="d/m/Y" selected>dd/mm/yyyy</option>
                        <option value="Y-m-d">yyyy-mm-dd</option>
                        <option value="m/d/Y">mm/dd/yyyy</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="records_per_page" class="form-label">Εγγραφές ανά Σελίδα</label>
                    <select class="form-control" id="records_per_page" name="records_per_page">
                        <option value="10">10</option>
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>

        <hr>

        <h5 class="text-primary mb-3">Ρυθμίσεις Email</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="smtp_host" class="form-label">SMTP Host</label>
                    <input type="text" class="form-control" id="smtp_host" name="smtp_host" 
                           value="smtp.gmail.com">
                </div>

                <div class="form-group mb-3">
                    <label for="smtp_port" class="form-label">SMTP Port</label>
                    <input type="number" class="form-control" id="smtp_port" name="smtp_port" 
                           value="587">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="smtp_user" class="form-label">SMTP Username</label>
                    <input type="text" class="form-control" id="smtp_user" name="smtp_user" 
                           placeholder="email@example.com">
                </div>

                <div class="form-group mb-3">
                    <label for="smtp_encryption" class="form-label">Κρυπτογράφηση</label>
                    <select class="form-control" id="smtp_encryption" name="smtp_encryption">
                        <option value="tls" selected>TLS</option>
                        <option value="ssl">SSL</option>
                        <option value="">Καμία</option>
                    </select>
                </div>
            </div>
        </div>

        <hr>

        <h5 class="text-primary mb-3">Ρυθμίσεις Αποθήκης</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="low_stock_threshold" class="form-label">Όριο Χαμηλού Αποθέματος</label>
                    <input type="number" class="form-control" id="low_stock_threshold" name="low_stock_threshold" 
                           value="5" min="0">
                    <small class="form-text text-muted">Προϊόντα κάτω από αυτό το όριο θα εμφανίζονται ως χαμηλό απόθεμα</small>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="auto_calculate_profit" name="auto_calculate_profit" checked>
                    <label class="form-check-label" for="auto_calculate_profit">
                        Αυτόματος Υπολογισμός Κέρδους
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="default_profit_margin" class="form-label">Προεπιλεγμένο Ποσοστό Κέρδους (%)</label>
                    <input type="number" class="form-control" id="default_profit_margin" name="default_profit_margin" 
                           value="25" min="0" max="100" step="0.1">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="enable_barcode" name="enable_barcode" checked>
                    <label class="form-check-label" for="enable_barcode">
                        Ενεργοποίηση Barcode Scanner
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>
                Αποθήκευση Ρυθμίσεων
            </button>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Επιστροφή
            </a>
        </div>

        <?= form_close() ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Form validation and preview
    $('form').on('submit', function(e) {
        var isValid = true;
        
        // Check required fields
        $(this).find('[required]').each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Παρακαλώ συμπληρώστε όλα τα απαιτούμενα πεδία.');
        }
    });
    
    // Real-time validation
    $('[required]').on('blur', function() {
        if ($(this).val().trim() === '') {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
});
</script>
<?= $this->endSection() ?>