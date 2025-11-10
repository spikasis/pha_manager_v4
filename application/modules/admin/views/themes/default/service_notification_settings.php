<?php
/**
 * System Settings View - Ρυθμίσεις Συστήματος για Notifications
 */
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <i class="fa fa-cogs fa-fw"></i> Ρυθμίσεις Notifications Επισκευών
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> Ρυθμίσεις Ειδοποιήσεων
                </div>
                <div class="panel-body">
                    <form role="form" method="POST" id="settings-form">
                        
                        <!-- Enable/Disable Notifications -->
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="enable_notifications" id="enable_notifications" 
                                           <?= ($settings['enable_service_notifications'] ?? '1') == '1' ? 'checked' : '' ?>>
                                    Ενεργοποίηση ειδοποιήσεων για καθυστερημένες επισκευές
                                </label>
                            </div>
                            <small class="help-block">Αν απενεργοποιηθεί, δεν θα εμφανίζονται notifications στο topbar</small>
                        </div>

                        <hr>

                        <!-- Delay Warning Settings -->
                        <div class="form-group">
                            <label for="delay_days">
                                <i class="fa fa-clock-o"></i> Ημέρες Καθυστέρησης για Ειδοποίηση
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="delay_days" 
                                       name="delay_days" min="1" max="30" 
                                       value="<?= $settings['service_delay_notification_days'] ?? '7' ?>">
                                <span class="input-group-addon">ημέρες</span>
                            </div>
                            <small class="help-block">
                                Μετά από πόσες ημέρες στο εργαστήριο θα θεωρείται καθυστερημένη μια επισκευή
                            </small>
                        </div>

                        <!-- Critical Delay Settings -->
                        <div class="form-group">
                            <label for="critical_delay_days">
                                <i class="fa fa-exclamation-triangle text-danger"></i> Ημέρες Κρίσιμης Καθυστέρησης
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="critical_delay_days" 
                                       name="critical_delay_days" min="1" max="60" 
                                       value="<?= $settings['service_critical_delay_days'] ?? '14' ?>">
                                <span class="input-group-addon">ημέρες</span>
                            </div>
                            <small class="help-block">
                                Μετά από πόσες ημέρες θα θεωρείται κρίσιμα καθυστερημένη (κόκκινη ειδοποίηση με animation)
                            </small>
                        </div>

                        <!-- Refresh Interval -->
                        <div class="form-group">
                            <label for="refresh_interval">
                                <i class="fa fa-refresh"></i> Διάστημα Ανανέωσης Ειδοποιήσεων
                            </label>
                            <select class="form-control" id="refresh_interval" name="refresh_interval">
                                <?php 
                                $current_interval = $settings['notification_refresh_interval'] ?? '300000';
                                $intervals = [
                                    '60000' => '1 λεπτό',
                                    '120000' => '2 λεπτά',
                                    '300000' => '5 λεπτά',
                                    '600000' => '10 λεπτά',
                                    '1800000' => '30 λεπτά'
                                ];
                                
                                foreach ($intervals as $value => $label):
                                ?>
                                    <option value="<?= $value ?>" <?= $current_interval == $value ? 'selected' : '' ?>>
                                        <?= $label ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="help-block">
                                Πόσο συχνά θα ανανεώνονται οι ειδοποιήσεις αυτόματα
                            </small>
                        </div>

                        <hr>

                        <!-- Test Notification -->
                        <div class="form-group">
                            <button type="button" class="btn btn-info" id="test-notification">
                                <i class="fa fa-bell"></i> Δοκιμή Ειδοποίησης
                            </button>
                            <small class="help-block">
                                Δοκιμάστε την εμφάνιση ειδοποιήσεων με τις τρέχουσες ρυθμίσεις
                            </small>
                        </div>

                        <!-- Save Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-save"></i> Αποθήκευση Ρυθμίσεων
                            </button>
                            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-default btn-lg">
                                <i class="fa fa-arrow-left"></i> Επιστροφή
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Live Preview -->
        <div class="col-lg-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-eye fa-fw"></i> Προεπισκόπηση Ειδοποιήσεων
                </div>
                <div class="panel-body">
                    <h5>Τρέχουσες Καθυστερημένες Επισκευές:</h5>
                    <div id="current-delayed-services">
                        <p class="text-muted">Φόρτωση...</p>
                    </div>
                    
                    <hr>
                    
                    <h5>Επόμενη Ανανέωση:</h5>
                    <p id="next-refresh-time" class="text-info">
                        <i class="fa fa-clock-o"></i> Υπολογισμός...
                    </p>
                    
                    <button class="btn btn-sm btn-success" id="refresh-preview">
                        <i class="fa fa-refresh"></i> Ανανέωση Τώρα
                    </button>
                </div>
            </div>

            <!-- Settings Info -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i> Πληροφορίες
                </div>
                <div class="panel-body">
                    <h6>Πώς λειτουργούν οι ειδοποιήσεις:</h6>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-check text-success"></i> Εμφάνιση στο topbar</li>
                        <li><i class="fa fa-check text-success"></i> Αυτόματη ανανέωση</li>
                        <li><i class="fa fa-check text-success"></i> Χρωματική κωδικοποίηση</li>
                        <li><i class="fa fa-check text-success"></i> Animation για κρίσιμες</li>
                    </ul>
                    
                    <h6>Χρωματική Κωδικοποίηση:</h6>
                    <ul class="list-unstyled">
                        <li>
                            <span class="badge badge-info">Μπλε</span> 
                            < <?= $settings['service_delay_notification_days'] ?? '7' ?> ημέρες
                        </li>
                        <li>
                            <span class="badge badge-warning">Κίτρινο</span> 
                            <?= $settings['service_delay_notification_days'] ?? '7' ?>-<?= $settings['service_critical_delay_days'] ?? '14' ?> ημέρες
                        </li>
                        <li>
                            <span class="badge badge-danger">Κόκκινο</span> 
                            > <?= $settings['service_critical_delay_days'] ?? '14' ?> ημέρες
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Load current delayed services preview
    loadDelayedServicesPreview();
    
    // Update next refresh time
    updateNextRefreshTime();
    setInterval(updateNextRefreshTime, 1000);
    
    // Form submission
    $('#settings-form').on('submit', function(e) {
        e.preventDefault();
        saveSettings();
    });
    
    // Test notification
    $('#test-notification').on('click', function() {
        testNotification();
    });
    
    // Refresh preview
    $('#refresh-preview').on('click', function() {
        loadDelayedServicesPreview();
    });
    
    // Update preview when settings change
    $('#delay_days, #critical_delay_days').on('change', function() {
        loadDelayedServicesPreview();
    });
});

function loadDelayedServicesPreview() {
    $('#current-delayed-services').html('<p class="text-muted"><i class="fa fa-spinner fa-spin"></i> Φόρτωση...</p>');
    
    $.get('<?= base_url("admin/services/get_delayed_services") ?>', function(data) {
        if (data && data.services) {
            var html = '';
            if (data.services.length > 0) {
                data.services.forEach(function(service, index) {
                    if (index < 3) { // Show only first 3 in preview
                        var badgeClass = service.days_in_lab > 14 ? 'badge-danger' : 
                                       service.days_in_lab > 7 ? 'badge-warning' : 'badge-info';
                        
                        html += '<div class="small" style="margin-bottom: 8px;">' +
                               '<strong>' + service.customer_name + '</strong><br>' +
                               '<span class="text-muted">' + service.device_model + '</span><br>' +
                               '<span class="badge ' + badgeClass + '">' + service.days_in_lab + ' ημέρες</span>' +
                               '</div>';
                    }
                });
                
                if (data.services.length > 3) {
                    html += '<p class="text-muted small">... και ' + (data.services.length - 3) + ' ακόμα</p>';
                }
            } else {
                html = '<p class="text-success"><i class="fa fa-check"></i> Δεν υπάρχουν καθυστερημένες επισκευές!</p>';
            }
            
            $('#current-delayed-services').html(html);
        }
    }).fail(function() {
        $('#current-delayed-services').html('<p class="text-danger">Σφάλμα φόρτωσης</p>');
    });
}

function updateNextRefreshTime() {
    var refreshInterval = parseInt($('#refresh_interval').val()) || 300000;
    var minutes = Math.floor(refreshInterval / 60000);
    var seconds = Math.floor((refreshInterval % 60000) / 1000);
    
    $('#next-refresh-time').html('<i class="fa fa-clock-o"></i> Κάθε ' + minutes + 
                               (seconds > 0 ? ':' + seconds.toString().padStart(2, '0') : '') + 
                               ' λεπτά');
}

function saveSettings() {
    var formData = {
        enable_notifications: $('#enable_notifications').is(':checked') ? '1' : '0',
        delay_days: $('#delay_days').val(),
        critical_delay_days: $('#critical_delay_days').val(),
        refresh_interval: $('#refresh_interval').val()
    };
    
    $.post('<?= base_url("admin/services/save_notification_settings") ?>', formData, function(response) {
        if (response.success) {
            showAlert('success', 'Οι ρυθμίσεις αποθηκεύτηκαν επιτυχώς!');
            
            // Reload the page to apply new settings
            setTimeout(function() {
                location.reload();
            }, 1500);
        } else {
            showAlert('danger', 'Σφάλμα αποθήκευσης: ' + (response.message || 'Άγνωστο σφάλμα'));
        }
    }).fail(function() {
        showAlert('danger', 'Σφάλμα επικοινωνίας με τον server');
    });
}

function testNotification() {
    // Trigger the notification system manually
    if (typeof loadDelayedServicesNotification === 'function') {
        loadDelayedServicesNotification();
        showAlert('info', 'Δοκιμή ειδοποίησης! Ελέγξτε το topbar.');
    } else {
        showAlert('warning', 'Η λειτουργία δοκιμής είναι διαθέσιμη μόνο στο main interface');
    }
}

function showAlert(type, message) {
    var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible" role="alert">' +
                   '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                   message + '</div>';
    
    $('#settings-form').prepend(alertHtml);
    
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}
</script>