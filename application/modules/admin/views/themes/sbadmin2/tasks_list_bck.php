<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2><?php echo $title ?></h2>
            <button id="addTaskBtn" class="btn btn-success" style="float: right">Προσθήκη Εργασίας</button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Λίστα Εργασιών</div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                
                                <th>Ημερομηνία Έναρξης</th>
                                <th>Γιατρος</th>
                                <th>Πελάτης</th>
                                <th>Ακουστικά</th>
                                <th>Scan</th>
                                <th>Παραγγελία</th>
                                <th>Γνωμάτευση</th>
                                <th>Παραλαβή</th>
                                <th>Τηλ Ραντεβού</th>
                                <th>Εκτέλεση</th>
                                <th>Παράδοση</th>
                                <th>Υπογραφές</th>
                                <th>Απόδειξη</th>
                                <th>Αρχείο</th>   
                                <th>Σχόλια</th>
                                <th>Ενέργειες</th> 
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($tasks as $task): ?>
                            <tr>
                                
                                            
                                <!-- Entry Date -->
                                <td><?= $task['entry_date']; ?></td>
                                <!--<td><?= $task['doctor_name']; ?></td>-->
                                <td><?= $task['doctor_name']; ?></td>
                                
                                <!-- Customer -->
                                <td>
                                    <a href="javascript:void(0);" class="viewCustomerBtn" data-id="<?= $task['client']; ?>">
                                    <?= $task['customer_name']; ?>
                                    </a>
                                </td>
                                
                                <td style="white-space: nowrap;">
                                    1: <a href="javascript:void(0);" class="viewAcousticBtn" data-id="<?= $task['acoustic_id']; ?>">
                                       <?= !empty($task['acoustic_serial']) ? $task['acoustic_serial'] : 'No h/a Assigned'; ?>
                                    </a>
                                    <br>
                                    2: <a href="javascript:void(0);" class="viewAcousticBtn" data-id="<?= $task['acoustic_id_2']; ?>">
                                        <?= !empty($task['acoustic_serial_2']) ? $task['acoustic_serial_2'] : 'No h/a Assigned'; ?>
                                    </a>
                                    
                                </td>
                                
                                <!-- Scan Checkbox -->
                                <td style="background-color: <?= $task['scan'] ? '#d4edda' : '#f8d7da'; ?>;">
                                    <input type="checkbox" class="updateCheckbox" data-id="<?= $task['id']; ?>" data-field="scan" <?= $task['scan'] ? 'checked' : ''; ?>>
                                </td>
                                
                                <!-- Order Date -->
                                <td style="background-color: <?= !empty($task['order']) && $task['order'] !== '0000-00-00' ? '#d4edda' : '#f8d7da'; ?>;">
                                    <input type="date" class="updateDate" data-id="<?= $task['id']; ?>" data-field="order" value="<?= $task['order'] ?: ''; ?>">
                                </td>
                                
                                <!-- Gnomateysi Checkbox -->
                                <td style="background-color: <?= $task['gnomateusi'] ? '#d4edda' : '#f8d7da'; ?>;">
                                    <input type="checkbox" class="updateCheckbox" data-id="<?= $task['id']; ?>" data-field="gnomateusi" <?= $task['gnomateusi'] ? 'checked' : ''; ?>>
                                </td>
                                
                                <!-- Receive Date -->
                                <td style="background-color: <?= !empty($task['receive']) && $task['receive'] !== '0000-00-00' ? '#d4edda' : '#f8d7da'; ?>;">
                                    <?= !empty($task['receive']) && $task['receive'] !== '0000-00-00' ? $task['receive'] : 'No Date Available'; ?>
                                </td>
                                
                                <!-- Tel RDV Checkbox -->
                                <td style="background-color: <?= $task['tel_rdv'] ? '#d4edda' : '#f8d7da'; ?>;">
                                    <input type="hidden" id="taskTelRdvTimestamp" name="tel_rdv_timestamp">
                                    <input type="checkbox" class="updateCheckbox" data-id="<?= $task['id']; ?>" data-field="tel_rdv" <?= $task['tel_rdv'] ? 'checked' : ''; ?>>
                                        <?php if ($task['tel_rdv']): ?>
                                    <span><?= date('d/m/Y', strtotime($task['tel_rdv_timestamp'])); ?></span> <!-- Εμφάνιση μόνο της ημερομηνίας -->
                                        <?php endif; ?>
                                </td>
                                
                                <!-- Ektelesi Checkbox -->
                                <td style="background-color: <?= $task['ektelesi'] ? '#d4edda' : '#f8d7da'; ?>;">
                                    <input type="checkbox" class="updateCheckbox" data-id="<?= $task['id']; ?>" data-field="ektelesi" <?= $task['ektelesi'] ? 'checked' : ''; ?>>
                                </td>
                                
                                <!-- Paradosi Date -->
                                <td style="background-color: <?= !empty($task['paradosi']) && $task['paradosi'] !== '0000-00-00' ? '#d4edda' : '#f8d7da'; ?>;">
                                    <?= !empty($task['paradosi']) && $task['paradosi'] !== '0000-00-00' ? $task['paradosi'] : 'No Date Available'; ?>
                                </td>
                                
                                <!-- Signatures Checkbox -->
                                <td style="background-color: <?= $task['signatures'] ? '#d4edda' : '#f8d7da'; ?>;">
                                    <input type="checkbox" class="updateCheckbox" data-id="<?= $task['id']; ?>" data-field="signatures" <?= $task['signatures'] ? 'checked' : ''; ?>>
                                </td>
                                
                                <!-- Receipt Checkbox -->
                                <td style="background-color: <?= $task['receipt'] ? '#d4edda' : '#f8d7da'; ?>;">
                                    <input type="checkbox" class="updateCheckbox" data-id="<?= $task['id']; ?>" data-field="receipt" <?= $task['receipt'] ? 'checked' : ''; ?>>
                                </td>
                                
                                <!-- Arxeio Checkbox -->
                                <td style="background-color: <?= $task['arxeio'] ? '#d4edda' : '#f8d7da'; ?>;">
                                    <input type="checkbox" class="updateCheckbox" data-id="<?= $task['id']; ?>" data-field="arxeio" <?= $task['arxeio'] ? 'checked' : ''; ?>>
                                </td>
                                
                                <!-- Comments -->
                                <td><?= $task['comments']; ?></td>
                                                    
                                
                                <!-- Actions Dropdown -->
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                            Ενέργειες
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="javascript:void(0);" class="editTaskBtn" data-id="<?= $task['id']; ?>">Edit</a></li>

                                            <li><a href="javascript:void(0);" class="deleteTaskBtn" data-id="<?= $task['id']; ?>">Delete</a></li>
                                            <!--<li><a href="<?= base_url('admin/stocks/create?customer_id=' . $task['client']); ?>">Προσθήκη Ακουστικού</a></li>-->
                                            <!-- Button for adding acoustic 
                                            <button class="btn btn-link addAcousticBtn" 
                                                    data-task-id="<?= $task['id']; ?>" 
                                                    data-customer-id="<?= $task['client']; ?>"
                                                    data-toggle="tooltip" 
                                                    title="Προσθήκη Ακουστικού στον πελάτη" 
                                                    style="padding: 0; margin-left: 5px;">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>-->
                                        </ul>
                                    </div>
                                </td>
                                <!-- Πρόοδος -->
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: <?= $task['progress']; ?>%;" aria-valuenow="<?= $task['progress']; ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?= round($task['progress']) ?>%
                                        </div>
                                    </div>
                                </td>
                                
                            </tr>
                            
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for viewing customer information -->
<div class="modal fade" id="customerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Πληροφορίες Πελάτη</h4>
                <!-- View button -->
                <button type="button" class="btn btn-link pull-right" title="Προβολή Πελάτη" id="viewCustomerBtn">
                    <i class="fas fa-eye" aria-hidden="true"></i>
                </button>
                <!-- Edit button -->
                <button type="button" class="btn btn-link pull-right" title="Επεξεργασία Πελάτη" id="editCustomerBtn">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Όνομα:</strong> <span id="customerName"></span></p>
                <p><strong>Τηλέφωνο Σταθερό:</strong> <span id="customerPhoneHome"></span></p>
                <p><strong>Τηλέφωνο Κινητό:</strong> <span id="customerPhoneMobile"></span></p>
                <p><strong>Διεύθυνση:</strong> <span id="customerAddress"></span></p>
                <p><strong>Πόλη:</strong> <span id="customerCity"></span></p>
                <p><strong>AMKA:</strong> <span id="customerAmka"></span></p> <!-- Πρόσθεσε αυτό το πεδίο -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for viewing acoustic information -->
<div class="modal fade" id="acousticModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Πληροφορίες Ακουστικού</h4>
                <!-- view button -->
                <button type="button" class="btn btn-link pull-right" title="Προβολή Ακουστικού" id="viewAcousticBtn">
                    <i class="fas fa-eye" aria-hidden="true"></i>
                </button>
                <!-- Edit button -->
                <button type="button" class="btn btn-link pull-right" title="Επεξεργασία Ακουστικού" id="editAcousticBtn">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Serial Number:</strong> <span id="acousticSerialNumber"></span></p>
                <p><strong>Σειρά:</strong> <span id="acousticSeries"></span></p>
                <p><strong>Μοντέλο:</strong> <span id="acousticModel"></span></p>
                <p><strong>Κατασκευαστής:</strong> <span id="acousticManufacturer"></span></p>
                <p><strong>Barcode Εκτέλεσης:</strong> <span id="acousticEkaptyCode"></span></p> <!-- Πρόσθεσε αυτό το πεδίο -->
                <p><strong>Γιατρός:</strong> <span id="acousticDoctor"></span></p> <!-- Πρόσθεσε αυτό το πεδίο -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal for adding/editing task -->
<div class="modal fade" id="taskModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="taskModalLabel">Διαχείριση Εργασίας</h4>
            </div>
            <div class="modal-body">
                <form id="taskForm" method="POST">
                                        
                    <!-- Dropdown for selecting customer -->
                    <div class="form-group">
                        <label for="taskClient" class="control-label">Πελάτης:</label>
                        <select class="form-control" id="taskClient" name="client">
                            <option value="">Επιλέξτε Πελάτη</option>
                            <?php foreach ($clients as $client): ?>
                                <option value="<?= $client['id']; ?>"><?= $client['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Dropdown for selecting Acoustic -->
                    <div class="form-group">
                        <label for="taskAcoustic" class="control-label">Ακουστικό R:</label>
                        <select class="form-control" id="taskAcoustic" name="acoustic_id">
                            <option value="">Επιλέξτε Ακουστικό</option>
                               <?php foreach ($acoustics as $acoustic): ?>
                            <option value="<?= $acoustic['id']; ?>" <?= $task['acoustic_id'] == $acoustic['id'] ? 'selected' : ''; ?>><?= $acoustic['serial'] . ' (' . $acoustic['ha_model'] . ')'; ?></option>
                               <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Dropdown for selecting Second Acoustic -->
                    <div class="form-group">
                        <label for="taskAcoustic2" class="control-label">Ακουστικό L:</label>
                        <select class="form-control" id="taskAcoustic2" name="acoustic_id_2">
                            <option value="">Επιλέξτε Δεύτερο Ακουστικό</option>
                               <?php foreach ($acoustics as $acoustic): ?>
                            <option value="<?= $acoustic['id']; ?>" <?= $task['acoustic_id_2'] == $acoustic['id'] ? 'selected' : ''; ?>><?= $acoustic['serial'] . ' (' . $acoustic['ha_model'] . ')'; ?></option>
                               <?php endforeach; ?>
                        </select>
                    </div>


                    <!-- Checkbox for Scan -->
                    <div class="form-group">
                        <label for="taskScan" class="control-label">Scan:</label>
                        <input type="checkbox" id="taskScan" name="scan" value="1">
                    </div>

                    <!-- Date for Order -->
                    <div class="form-group">
                        <label for="taskOrder" class="control-label">Παραγγελία:</label>
                        <input type="date" class="form-control" id="taskOrder" name="order">
                    </div>

                    <!-- Checkbox for Gnomateusi -->
                    <div class="form-group">
                        <label for="taskGnomateusi" class="control-label">Γνωμάτευση:</label>
                        <input type="checkbox" id="taskGnomateusi" name="gnomateusi" value="1">
                    </div>

                    <!-- Checkbox for Tel Rdv -->
                    <div class="form-group">
                        <label for="taskTelRdv" class="control-label">Τηλ Ραντεβού:</label>
                        <input type="checkbox" id="taskTelRdv" name="tel_rdv" value="1">
                    </div>

                    <!-- Checkbox for Ektelesi -->
                    <div class="form-group">
                        <label for="taskEktelesi" class="control-label">Εκτέλεση:</label>
                        <input type="checkbox" id="taskEktelesi" name="ektelesi" value="1">
                    </div>
                    

                    <!-- Checkbox for Signatures -->
                    <div class="form-group">
                        <label for="taskSignatures" class="control-label">Υπογραφές:</label>
                        <input type="checkbox" id="taskSignatures" name="signatures" value="1">
                    </div>

                    <!-- Checkbox for Receipt -->
                    <div class="form-group">
                        <label for="taskReceipt" class="control-label">Απόδειξη:</label>
                        <input type="checkbox" id="taskReceipt" name="receipt" value="1">
                    </div>

                    <!-- Checkbox for Arxeio -->
                    <div class="form-group">
                        <label for="taskArxeio" class="control-label">Αρχείο:</label>
                        <input type="checkbox" id="taskArxeio" name="arxeio" value="1">
                    </div>
                    
                    <!-- Comments -->
                    <div class="form-group">
                        <label for="taskComments" class="control-label">Σχόλια:</label>
                        <textarea class="form-control" id="taskComments" name="comments" rows="3"></textarea>
                    </div>

                    <!-- Hidden field for Task ID -->
                    <input type="hidden" id="taskId" name="id">

                    <button type="submit" class="btn btn-success">Αποθήκευση</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for adding acoustic -->
<div class="modal fade" id="acousticModalAdd" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Προσθήκη Ακουστικού</h4>
            </div>
            <div class="modal-body">
                <form id="acousticForm" method="POST" action="<?= base_url('admin/stocks/create_modal') ?>">
                    <!-- Κρυφό πεδίο για το customer_id -->
                    <input type="hidden" id="customerId" name="customer_id" value="">

                    <!-- Serial Number -->
                    <div class="form-group">
                        <label for="acousticSerial" class="control-label">Serial Number:</label>
                        <input type="text" class="form-control" id="acousticSerial" name="serial" required>
                    </div>

                    <!-- Dropdown for selecting Acoustic -->
                    <div class="form-group">
                        <label for="taskModel" class="control-label">Μοντέλο:</label>
                        <select class="form-control" id="taskModel" name="ha_model">
                            <option value="">Επιλέξτε Μοντέλο</option>
                            <!-- Τα μοντέλα θα προστεθούν εδώ μέσω JavaScript -->
                        </select>
                    </div>

                    <!-- Additional fields -->
                    <div class="form-group">
                        <label for="acousticDayIn" class="control-label">Ημερομηνία Εισόδου:</label>
                        <input type="date" class="form-control" id="acousticDayIn" name="day_in">
                    </div>

                    <div class="form-group">
                        <label for="acousticDayOut" class="control-label">Ημερομηνία Εξόδου:</label>
                        <input type="date" class="form-control" id="acousticDayOut" name="day_out">
                    </div>                   

                    <div class="form-group">
                        <label for="acousticStatus" class="control-label">Κατάσταση:</label>
                        <input type="text" class="form-control" id="acousticStatus" name="status">
                    </div>

                    <div class="form-group">
                        <label for="acousticComments" class="control-label">Σχόλια:</label>
                        <textarea class="form-control" id="acousticComments" name="comments" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="acousticEkaptyCode" class="control-label">Barcode Εκτέλεσης:</label>
                        <input type="text" class="form-control" id="acousticEkaptyCode" name="ekapty_code">
                    </div>

                    <button type="submit" class="btn btn-success">Προσθήκη</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!--END OF MODALS -->

<script>
$(document).ready(function() {
    // Modal for creating a new task
    $('#addTaskBtn').on('click', function() {
        $('#taskModalLabel').text('Προσθήκη Νέας Εργασίας');
        $('#taskForm')[0].reset();  // Clear form data
        $('#taskId').val('');  // Clear the hidden task ID field
        $('#taskComments').val('');  // Clear specific fields
        $('#taskReceive').val('');

        $('#taskModal').modal('show');  // Show the modal
    });

    // When a customer is selected, load their acoustics
    $('#taskClient').on('change', function() {
        var clientId = $(this).val();
        if (!clientId) {
            $('#taskAcoustic, #taskAcoustic2').html('<option value="">Επιλέξτε Ακουστικό</option>');
            return;
        }

        // AJAX call to fetch customer's acoustics
        $.ajax({
            url: '<?= base_url('admin/stocks/get_by_customer') ?>/' + clientId,
            method: 'GET',
            success: function(data) {
                var acoustics = JSON.parse(data);
                var options = '<option value="">Επιλέξτε Ακουστικό</option>';

                acoustics.forEach(function(acoustic) {
                    options += '<option value="' + acoustic.id + '">' + acoustic.serial + ' (' + acoustic.ha_model + ')</option>';
                });

                $('#taskAcoustic').html(options);
                $('#taskAcoustic2').html(options);
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Σφάλμα κατά τη φόρτωση των ακουστικών.');
            }
        });
    });

    // Submit task form (create or update task)
    $('#taskForm').on('submit', function(e) {
    e.preventDefault();  // Prevent default form submission

        var formData = $(this).serialize();  // Collect form data
        console.log("Form Data sent:", formData);  // Debugging: Εδώ εκτυπώνεις τα δεδομένα
        
        var taskId = $('#taskId').val(); // Παίρνεις το ID από το hidden input
    
        // Χρησιμοποίησε το ID της εργασίας για να σχηματίσεις το URL
        var url;
        if (taskId) {
            url = '<?= base_url('admin/tasks/edit/') ?>' + taskId; // Επεξεργασία
            } else {
            url = '<?= base_url('admin/tasks/create') ?>'; // Δημιουργία
        }
        
        // Ελέγξτε αν το checkbox είναι τσεκαρισμένο
        var telRdvChecked = $('#taskTelRdv').is(':checked');

        // Αν το checkbox είναι τσεκαρισμένο, προσθέστε το timestamp στο formData
        if (telRdvChecked) {
            formData += '&tel_rdv_timestamp=' + encodeURIComponent(new Date().toISOString().slice(0, 10)); // Μόνο η ημερομηνία
        }
    
        // AJAX form submission
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            success: function(response) {
                alert('Η εργασία αποθηκεύτηκε επιτυχώς.');
                location.reload();  // Reload page on success
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Σφάλμα κατά την αποθήκευση της εργασίας.');
            }
        });        
    });

    // Load task data for editing
    $('.editTaskBtn').on('click', function() {
        //alert('Edit button clicked'); // Ελέγχει αν το click event εκτελείται
        var taskId = $(this).data('id');
        //alert('Task ID: ' + taskId); // Δες αν το ID είναι σωστό
        

        // AJAX request to get task data
        $.ajax({
            url: '<?= base_url('admin/tasks/get_task') ?>/' + taskId,
            method: 'GET',
            success: function(data) {
                var task = JSON.parse(data);
                
        
            $('#taskId').val(task.id); // Αυτό πρέπει να ρυθμιστεί σωστά
            $('#taskClient').val(task.client).trigger('change'); // Update client dropdown and load acoustics
            $('#taskOrder').val(task.order !== '0000-00-00' ? task.order : ''); // Handle invalid dates
            $('#taskReceive').val(task.receive !== '0000-00-00' ? task.receive : '');
           
            // Set timestamp for tel_rdv
            $('#taskTelRdv').prop('checked', task.tel_rdv == 1);
            $('#taskTelRdvTimestamp').val(task.tel_rdv_timestamp !== '0000-00-00' ? task.tel_rdv_timestamp : ''); // Set the timestamp

            // Set acoustic values
            setTimeout(function() {
                $('#taskAcoustic').val(task.acoustic_id);
                $('#taskAcoustic2').val(task.acoustic_id_2);
            }, 500);

            $('#taskComments').val(task.comments);
            $('#taskScan').prop('checked', task.scan == 1);
            $('#taskGnomateusi').prop('checked', task.gnomateusi == 1);
            $('#taskTelRdv').prop('checked', task.tel_rdv == 1);
            $('#taskEktelesi').prop('checked', task.ektelesi == 1);
            $('#taskSignatures').prop('checked', task.signatures == 1);
            $('#taskReceipt').prop('checked', task.receipt == 1);
            $('#taskArxeio').prop('checked', task.arxeio == 1);

            $('#taskModalLabel').text('Επεξεργασία Εργασίας');
            $('#taskModal').modal('show');  // Show modal
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Σφάλμα κατά τη φόρτωση των δεδομένων της εργασίας.');
        }
    });
});



    // Delete a task
    $('.deleteTaskBtn').on('click', function() {
        var taskId = $(this).data('id');
        if (!confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτή την εργασία;')) {
            return;
        }

        // AJAX request to delete task
        $.ajax({
            url: '<?= base_url('admin/tasks/delete') ?>/' + taskId,
            method: 'POST',
            success: function(response) {
                alert('Η εργασία διαγράφηκε επιτυχώς.');
                location.reload();  // Reload page
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Σφάλμα κατά τη διαγραφή της εργασίας.');
            }
        });
    });

    // View customer details
$('.viewCustomerBtn').on('click', function(e) {
    e.preventDefault();
    var clientId = $(this).data('id');

    // AJAX to get customer data
    $.ajax({
        url: '<?= base_url('admin/customers/get_customer') ?>/' + clientId,
        method: 'GET',
        success: function(data) {
            var customer = JSON.parse(data);
            $('#customerName').text(customer.name);
            $('#customerPhoneHome').text(customer.phone_home);
            $('#customerPhoneMobile').text(customer.phone_mobile);
            $('#customerAddress').text(customer.address);
            $('#customerCity').text(customer.city);
            $('#customerAmka').text(customer.amka); // Ενημέρωση του πεδίου AMKA
            
            // Set the edit button link
            $('#editCustomerBtn').attr('onclick', "window.location.href='<?= base_url('admin/customers/edit/') ?>/" + clientId + "'");
            $('#viewCustomerBtn').attr('onclick', "window.location.href='<?= base_url('admin/customers/view/') ?>/" + clientId + "'");

            $('#customerModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Σφάλμα κατά τη φόρτωση των δεδομένων του πελάτη.');
        }
    });
});


    // View acoustic details
$('.viewAcousticBtn').on('click', function(e) {
    e.preventDefault();
    var acousticId = $(this).data('id');

    // AJAX to get acoustic data
    $.ajax({
        url: '<?= base_url('admin/stocks/get_acoustic') ?>/' + acousticId,
        method: 'GET',
        success: function(data) {
            var acoustic = JSON.parse(data);
            $('#acousticSerialNumber').text(acoustic.serial);
            $('#acousticSeries').text(acoustic.series_name);
            $('#acousticModel').text(acoustic.model_name);
            $('#acousticManufacturer').text(acoustic.manufacturer_name);
            $('#acousticEkaptyCode').text(acoustic.ekapty_code); // Ενημέρωση του πεδίου ekapty_code
            $('#acousticDoctor').text(acoustic.doctor_name); // Ενημέρωση του πεδίου doctor
            
            // Set the edit button link
            $('#editAcousticBtn').attr('onclick', "window.location.href='<?= base_url('admin/stocks/edit/') ?>/" + acousticId + "'");
            $('#viewAcousticBtn').attr('onclick', "window.location.href='<?= base_url('admin/stocks/view/') ?>/" + acousticId + "'");

            $('#acousticModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Σφάλμα κατά τη φόρτωση των δεδομένων του ακουστικού.');
        }
    });
});


    // Update checkbox field values (e.g., scan, signatures, etc.)
    $('.updateCheckbox').on('change', function() {
        var taskId = $(this).data('id');
        var field = $(this).data('field');
        var isChecked = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: '<?= base_url('admin/tasks/update_field') ?>',
            method: 'POST',
            data: {
                id: taskId,
                field: field,
                value: isChecked
            },
            success: function(response) {
                var backgroundColor = isChecked ? '#d4edda' : '#f8d7da';
                $('input[data-id="' + taskId + '"][data-field="' + field + '"]').closest('td').css('background-color', backgroundColor);
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Σφάλμα κατά την ενημέρωση της βάσης δεδομένων.');
            }
        });
    });

    // Update date fields (e.g., day_in, paradosi)
    $('.updateDate').on('change', function() {
        var taskId = $(this).data('id');
        var field = $(this).data('field');
        var dateValue = $(this).val();

        if (!dateValue) {
            dateValue = null;
        }

        $.ajax({
            url: '<?= base_url('admin/tasks/update_field') ?>',
            method: 'POST',
            data: {
                id: taskId,
                field: field,
                value: dateValue
            },
            success: function(response) {
                console.log('Η ημερομηνία ενημερώθηκε επιτυχώς για πεδίο ' + field);
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Σφάλμα κατά την ενημέρωση της βάσης δεδομένων.');
            }
        });
    });
   
    // Update date background colors based on validity
    $('.receive-date').each(function() {
        var dateValue = $(this).text().trim();
        if (dateValue === '0000-00-00' || dateValue === 'No Date Available') {
            $(this).css('background-color', '#f8d7da');  // Light red for invalid or missing dates
            $(this).text('No Date Available');
        } else {
            $(this).css('background-color', '#d4edda');  // Light green for valid dates
        }
    });

    // Update customer pending status
    $('.updatePendingStatus').on('change', function() {
        var checkbox = $(this);
        var customerId = checkbox.data('id');
        var isChecked = checkbox.is(':checked') ? 1 : 0;

        $.ajax({
            url: '<?= base_url('admin/customers/update_pending_status') ?>',
            method: 'POST',
            data: { id: customerId, pending: isChecked },
            success: function(response) {
                console.log('Η κατάσταση αναμονής ενημερώθηκε επιτυχώς.');
            },
            error: function(xhr, status, error) {
                console.error('Σφάλμα κατά την ενημέρωση της κατάστασης αναμονής:', error);
                alert('Σφάλμα κατά την ενημέρωση της κατάστασης αναμονής.');
            }
        });
    });

    // Date field changes and updates for stocks
    $('.updateDate').on('change', function() {
        var taskId = $(this).data('id');
        var field = $(this).data('field');
        var dateValue = $(this).val();

        if (!dateValue) {
            dateValue = null;
        }

        $.ajax({
            url: '<?= base_url('admin/tasks/update_field') ?>',
            method: 'POST',
            data: {
                id: taskId,
                field: field,
                value: dateValue
            },
            success: function(response) {
                console.log('Η ημερομηνία ενημερώθηκε επιτυχώς για πεδίο ' + field);
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Σφάλμα κατά την ενημέρωση της βάσης δεδομένων.');
            }
        });
    });

    // Handle the Edit button click
    $('.editTaskBtn').on('click', function() {
        var taskId = $(this).data('id');
        console.log("Editing task with ID: " + taskId);
        // Your edit functionality here
    });

    // Handle the Delete button click
    $('.deleteTaskBtn').on('click', function() {
        var taskId = $(this).data('id');
        console.log("Deleting task with ID: " + taskId);
        // Your delete functionality here
    });
});

$(document).ready(function() {
    // Modal for adding a new acoustic
    $('.addAcousticBtn').on('click', function() {
        var taskId = $(this).data('task-id'); // Get the task ID
        var customerId = $(this).data('customer-id'); // Get the customer ID

        // Set values in the modal
        $('#taskId').val(taskId); // Set the task ID
        $('#customerId').val(customerId); // Set the customer ID in the hidden field
        
        $('#acousticModel').html('<option value="">Φορτώνει...</option>'); // Placeholder for models
        $('#acousticModalAdd').modal('show'); // Show the modal

        // AJAX call to fetch all models
        $.ajax({
            url: '<?= base_url('admin/models/get_all_models_with_details') ?>', // Adjust the URL to your method
            method: 'GET',
            success: function(data) {
                console.log("Models Data: ", data); // Debugging
                var models = JSON.parse(data);
                var options = '<option value="">Επιλέξτε Μοντέλο</option>'; // Default option

                // Δημιουργία των επιλογών για το dropdown
                models.forEach(function(model) {
                    options += '<option value="' + model.model_id + '">' +
                               model.manufacturer_name + ' - ' +
                               model.series_name + ' - ' +
                               model.model_name + ' - ' +
                               model.ha_type_name + ' - ' +
                               model.battery_type_name + 
                               '</option>';
                });

                $('#taskModel').html(options); // Ενημέρωση του dropdown με τις επιλογές
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Σφάλμα κατά τη φόρτωση των μοντέλων ακουστικών.');
            }
        });
    });

    // Submit acoustic form
    $('#acousticForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        var formData = $(this).serialize(); // Collect form data
        console.log("Form Data sent:", formData); // Debugging: Εδώ εκτυπώνεις τα δεδομένα

        // AJAX form submission
        $.ajax({
            url: '<?= base_url('admin/stocks/create_modal') ?>', // URL for creating acoustic
            method: 'POST',
            data: formData,
            success: function(response) {
                alert('Το ακουστικό προστέθηκε επιτυχώς.');
                $('#acousticModalAdd').modal('hide'); // Close the modal
                location.reload(); // Reload page or update UI as needed
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Σφάλμα κατά την προσθήκη του ακουστικού.');
            }
        });
    });
});



</script>