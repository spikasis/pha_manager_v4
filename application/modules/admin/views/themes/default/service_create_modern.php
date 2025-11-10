<?php
/**
 * Modern Service Create View - Enhanced SBAdmin2 Layout
 */
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <i class="fa fa-plus fa-fw"></i> Νέα Επισκευή Ακουστικού
                <div class="pull-right">
                    <a href="<?= base_url('admin/services') ?>" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Επιστροφή στη Λίστα
                    </a>
                </div>
            </h1>
        </div>
    </div>

    <!-- Wizard Steps -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-clipboard fa-fw"></i> Βήματα Δημιουργίας Επισκευής</h4>
                </div>
                <div class="panel-body">
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" 
                             style="width: 33.33%" id="form-progress">
                            Βήμα 1 από 3
                        </div>
                    </div>
                    
                    <ul class="nav nav-pills nav-justified" id="service-steps">
                        <li class="active">
                            <a href="#step1" data-toggle="tab">
                                <i class="fa fa-user"></i><br>
                                Επιλογή Πελάτη & Ακουστικού
                            </a>
                        </li>
                        <li class="">
                            <a href="#step2" data-toggle="tab">
                                <i class="fa fa-wrench"></i><br>
                                Στοιχεία Επισκευής
                            </a>
                        </li>
                        <li class="">
                            <a href="#step3" data-toggle="tab">
                                <i class="fa fa-check"></i><br>
                                Επιβεβαίωση & Αποθήκευση
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Content -->
    <div class="row">
        <div class="col-lg-12">
            <form role="form" method="POST" action="<?= base_url('admin/services/create') ?>" id="service-form">
                
                <!-- Step 1: Customer & Device Selection -->
                <div class="tab-content">
                    <div class="tab-pane active" id="step1">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4><i class="fa fa-user fa-fw"></i> Βήμα 1: Επιλογή Πελάτη & Ακουστικού</h4>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <!-- Customer Selection -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_search"><i class="fa fa-user"></i> Αναζήτηση Πελάτη *</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="customer_search" 
                                                       placeholder="Πληκτρολογήστε όνομα ή τηλέφωνο...">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-success" id="new-customer-btn">
                                                        <i class="fa fa-plus"></i> Νέος Πελάτης
                                                    </button>
                                                </span>
                                            </div>
                                            <div id="customer-results" class="list-group" style="margin-top: 10px; display: none;"></div>
                                        </div>
                                        
                                        <!-- Selected Customer Info -->
                                        <div id="selected-customer" style="display: none;">
                                            <div class="alert alert-success">
                                                <h5><i class="fa fa-check-circle"></i> Επιλεγμένος Πελάτης:</h5>
                                                <p id="customer-info"></p>
                                                <input type="hidden" name="customer_id" id="customer_id">
                                                <button type="button" class="btn btn-xs btn-warning" id="change-customer">
                                                    <i class="fa fa-edit"></i> Αλλαγή
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Device Selection -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ha_service"><i class="fa fa-headphones"></i> Ακουστικό για Επισκευή *</label>
                                            <select class="form-control" id="ha_service" name="ha_service" disabled required>
                                                <option value="">Επιλέξτε πρώτα πελάτη...</option>
                                            </select>
                                            <small class="help-block">Θα εμφανιστούν τα ακουστικά του επιλεγμένου πελάτη</small>
                                        </div>
                                        
                                        <!-- Device Info -->
                                        <div id="device-info" style="display: none;">
                                            <div class="well well-sm">
                                                <h6><i class="fa fa-info-circle"></i> Στοιχεία Ακουστικού:</h6>
                                                <div id="device-details"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr>
                                <div class="text-right">
                                    <button type="button" class="btn btn-primary btn-lg" id="next-step1" disabled>
                                        Συνέχεια <i class="fa fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 2: Service Details -->
                    <div class="tab-pane" id="step2">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h4><i class="fa fa-wrench fa-fw"></i> Βήμα 2: Στοιχεία Επισκευής</h4>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="day_in"><i class="fa fa-calendar"></i> Ημερομηνία Παραλαβής *</label>
                                            <input type="date" class="form-control" id="day_in" name="day_in" 
                                                   value="<?= date('Y-m-d') ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="malfunction"><i class="fa fa-exclamation-triangle"></i> Συμπτώματα / Πρόβλημα</label>
                                            <textarea class="form-control" id="malfunction" name="malfunction" 
                                                      rows="4" placeholder="Περιγράψτε το πρόβλημα του ακουστικού..."></textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="lab_sent"><i class="fa fa-building"></i> Εργαστήριο Επισκευής</label>
                                            <select class="form-control" id="lab_sent" name="lab_sent">
                                                <option value="">Δεν ορίστηκε</option>
                                                <?php if (isset($vendor) && count($vendor)): ?>
                                                    <?php foreach ($vendor as $lab): ?>
                                                        <option value="<?= $lab['id'] ?>"><?= $lab['name'] ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ha_temp"><i class="fa fa-exchange"></i> Ακουστικό Αντικατάστασης</label>
                                            <select class="form-control" id="ha_temp" name="ha_temp">
                                                <option value="">Δεν χρειάζεται</option>
                                                <?php if (isset($stock) && count($stock)): ?>
                                                    <?php foreach ($stock as $temp_device): ?>
                                                        <?php if ($temp_device['status'] == 5): ?>
                                                            <option value="<?= $temp_device['id'] ?>">
                                                                <?= $temp_device['serial'] ?> - <?= $temp_device['model'] ?>
                                                            </option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                            <small class="help-block">Επιλέξτε ακουστικό demo για προσωρινή χρήση</small>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="action_service"><i class="fa fa-cogs"></i> Κατάσταση Επισκευής</label>
                                            <select class="form-control" id="action_service" name="action_service">
                                                <?php if (isset($status) && count($status)): ?>
                                                    <?php foreach ($status as $stat): ?>
                                                        <option value="<?= $stat['id'] ?>" <?= ($stat['id'] == 1) ? 'selected' : '' ?>>
                                                            <?= $stat['status'] ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="estimated_cost"><i class="fa fa-euro"></i> Εκτιμώμενο Κόστος (€)</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="estimated_cost" 
                                                       name="price" min="0" step="0.01" placeholder="0.00">
                                                <span class="input-group-addon">€</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Service Condition -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><i class="fa fa-list"></i> Κατάσταση Συσκευής:</label>
                                            <div class="row">
                                                <?php if (isset($ser_condition) && count($ser_condition)): ?>
                                                    <?php foreach ($ser_condition as $condition): ?>
                                                        <div class="col-md-3">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="status" value="<?= $condition['id'] ?>" 
                                                                           <?= ($condition['id'] == 1) ? 'checked' : '' ?>>
                                                                    <?= $condition['status'] ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr>
                                <div class="text-left pull-left">
                                    <button type="button" class="btn btn-default btn-lg" id="prev-step2">
                                        <i class="fa fa-arrow-left"></i> Πίσω
                                    </button>
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-primary btn-lg" id="next-step2">
                                        Συνέχεια <i class="fa fa-arrow-right"></i>
                                    </button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 3: Confirmation -->
                    <div class="tab-pane" id="step3">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h4><i class="fa fa-check fa-fw"></i> Βήμα 3: Επιβεβαίωση & Αποθήκευση</h4>
                            </div>
                            <div class="panel-body">
                                <div class="alert alert-info">
                                    <h5><i class="fa fa-info-circle"></i> Παρακαλώ ελέγξτε τα στοιχεία πριν την αποθήκευση:</h5>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><h6>Στοιχεία Πελάτη & Συσκευής</h6></div>
                                            <div class="panel-body">
                                                <dl class="dl-horizontal">
                                                    <dt>Πελάτης:</dt>
                                                    <dd id="review-customer"></dd>
                                                    <dt>Ακουστικό:</dt>
                                                    <dd id="review-device"></dd>
                                                    <dt>Ημ/νία Παραλαβής:</dt>
                                                    <dd id="review-date"></dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><h6>Στοιχεία Επισκευής</h6></div>
                                            <div class="panel-body">
                                                <dl class="dl-horizontal">
                                                    <dt>Συμπτώματα:</dt>
                                                    <dd id="review-malfunction"></dd>
                                                    <dt>Εργαστήριο:</dt>
                                                    <dd id="review-lab"></dd>
                                                    <dt>Κόστος:</dt>
                                                    <dd id="review-cost"></dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-warning">
                                    <p><i class="fa fa-warning"></i> Μετά την αποθήκευση θα δημιουργηθεί:</p>
                                    <ul>
                                        <li>Εγγραφή επισκευής στο σύστημα</li>
                                        <li>Έντυπο παραλαβής (PDF)</li>
                                        <li>Ενημέρωση κατάστασης ακουστικού</li>
                                    </ul>
                                </div>
                                
                                <hr>
                                <div class="text-left pull-left">
                                    <button type="button" class="btn btn-default btn-lg" id="prev-step3">
                                        <i class="fa fa-arrow-left"></i> Πίσω
                                    </button>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-success btn-lg" id="submit-service">
                                        <i class="fa fa-save"></i> Αποθήκευση Επισκευής
                                    </button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var currentStep = 1;
    
    // Step Navigation
    $('#next-step1').click(function() {
        if (validateStep1()) {
            goToStep(2);
        }
    });
    
    $('#next-step2').click(function() {
        if (validateStep2()) {
            populateReview();
            goToStep(3);
        }
    });
    
    $('#prev-step2').click(function() {
        goToStep(1);
    });
    
    $('#prev-step3').click(function() {
        goToStep(2);
    });
    
    // Customer Search
    $('#customer_search').on('input', function() {
        var query = $(this).val();
        if (query.length >= 2) {
            searchCustomers(query);
        } else {
            $('#customer-results').hide();
        }
    });
    
    // Customer Selection
    $(document).on('click', '.customer-item', function() {
        var customerId = $(this).data('id');
        var customerName = $(this).data('name');
        var customerPhone = $(this).data('phone');
        
        selectCustomer(customerId, customerName, customerPhone);
    });
    
    // Change Customer
    $('#change-customer').click(function() {
        $('#selected-customer').hide();
        $('#customer_search').val('').focus();
        $('#ha_service').prop('disabled', true).empty().append('<option value="">Επιλέξτε πρώτα πελάτη...</option>');
        checkStep1Validity();
    });
    
    // Device Selection
    $('#ha_service').change(function() {
        var deviceId = $(this).val();
        if (deviceId) {
            loadDeviceInfo(deviceId);
        } else {
            $('#device-info').hide();
        }
        checkStep1Validity();
    });
    
    function goToStep(step) {
        currentStep = step;
        
        // Update progress bar
        var percentage = (step / 3) * 100;
        $('#form-progress').css('width', percentage + '%').text('Βήμα ' + step + ' από 3');
        
        // Update pills
        $('#service-steps li').removeClass('active');
        $('#service-steps li:nth-child(' + step + ')').addClass('active');
        
        // Show corresponding tab
        $('.tab-pane').removeClass('active');
        $('#step' + step).addClass('active');
    }
    
    function validateStep1() {
        var customerId = $('#customer_id').val();
        var deviceId = $('#ha_service').val();
        
        if (!customerId) {
            alert('Παρακαλώ επιλέξτε πελάτη');
            return false;
        }
        
        if (!deviceId) {
            alert('Παρακαλώ επιλέξτε ακουστικό');
            return false;
        }
        
        return true;
    }
    
    function validateStep2() {
        var dayIn = $('#day_in').val();
        
        if (!dayIn) {
            alert('Παρακαλώ επιλέξτε ημερομηνία παραλαβής');
            return false;
        }
        
        return true;
    }
    
    function checkStep1Validity() {
        var customerId = $('#customer_id').val();
        var deviceId = $('#ha_service').val();
        
        $('#next-step1').prop('disabled', !(customerId && deviceId));
    }
    
    function searchCustomers(query) {
        $.get('<?= base_url("admin/customers/search") ?>', {q: query}, function(data) {
            var results = $('#customer-results');
            results.empty();
            
            if (data && data.length > 0) {
                data.forEach(function(customer) {
                    var item = $('<a href="#" class="list-group-item customer-item">')
                        .data('id', customer.id)
                        .data('name', customer.name)
                        .data('phone', customer.phone)
                        .html('<strong>' + customer.name + '</strong><br><small>' + customer.phone + '</small>');
                    results.append(item);
                });
                results.show();
            } else {
                results.append('<div class="list-group-item text-muted">Δεν βρέθηκαν πελάτες</div>').show();
            }
        });
    }
    
    function selectCustomer(id, name, phone) {
        $('#customer_id').val(id);
        $('#customer-info').html('<strong>' + name + '</strong><br><small><i class="fa fa-phone"></i> ' + phone + '</small>');
        $('#selected-customer').show();
        $('#customer-results').hide();
        
        // Load customer devices
        loadCustomerDevices(id);
        checkStep1Validity();
    }
    
    function loadCustomerDevices(customerId) {
        $('#ha_service').prop('disabled', true).empty().append('<option value="">Φόρτωση...</option>');
        
        $.get('<?= base_url("admin/customers/get_devices") ?>/' + customerId, function(data) {
            var select = $('#ha_service');
            select.empty().append('<option value="">Επιλέξτε ακουστικό...</option>');
            
            if (data && data.length > 0) {
                data.forEach(function(device) {
                    select.append('<option value="' + device.id + '">' + device.model + ' - S/N: ' + device.serial + '</option>');
                });
            } else {
                select.append('<option value="">Δεν βρέθηκαν ακουστικά</option>');
            }
            
            select.prop('disabled', false);
        });
    }
    
    function loadDeviceInfo(deviceId) {
        $.get('<?= base_url("admin/stocks/get_device_info") ?>/' + deviceId, function(data) {
            if (data) {
                var html = '<strong>Μοντέλο:</strong> ' + data.model + '<br>' +
                          '<strong>Serial:</strong> ' + data.serial + '<br>' +
                          '<strong>Κατασκευαστής:</strong> ' + data.manufacturer;
                $('#device-details').html(html);
                $('#device-info').show();
            }
        });
    }
    
    function populateReview() {
        $('#review-customer').text($('#customer-info').text());
        $('#review-device').text($('#ha_service option:selected').text());
        $('#review-date').text($('#day_in').val());
        $('#review-malfunction').text($('#malfunction').val() || 'Δεν ορίστηκε');
        $('#review-lab').text($('#lab_sent option:selected').text() || 'Δεν ορίστηκε');
        $('#review-cost').text($('#estimated_cost').val() ? '€' + $('#estimated_cost').val() : 'Δεν ορίστηκε');
    }
});
</script>