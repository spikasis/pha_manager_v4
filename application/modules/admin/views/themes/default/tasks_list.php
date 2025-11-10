<style>
/* Enhanced Task Management Styles */
.progress {
    background-color: #f5f5f5;
    border-radius: 4px;
    box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
}

.progress-bar {
    transition: width 0.6s ease;
}

.panel-heading h4 {
    margin: 0;
    color: #333;
}

.checkbox label {
    display: flex;
    align-items: center;
    gap: 8px;
    padding-left: 0;
}

.checkbox input[type="checkbox"] {
    margin: 0;
}

.form-group {
    margin-bottom: 15px;
}

.modal-dialog {
    width: 90%;
    max-width: 800px;
}

.progress-indicator {
    border-radius: 6px;
    margin-bottom: 15px;
}

.alert-dismissible {
    border-radius: 4px;
}

/* Status color indicators */
.text-danger { color: #d9534f !important; }
.text-warning { color: #f0ad4e !important; }
.text-info { color: #5bc0de !important; }
.text-primary { color: #337ab7 !important; }
.text-success { color: #5cb85c !important; }

/* Enhanced table styling */
.table-striped > tbody > tr:hover {
    background-color: #f5f5f5;
}

.fa {
    margin-right: 5px;
}
</style>

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
                                <td>
                                    <button class="btn btn-info viewCommentsBtn" data-comments="<?= htmlspecialchars($task['comments']); ?>">Σχόλια</button>
                                </td>
                                                    
                                
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
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar progress-bar-<?= $task['status_class'] ?>" 
                                             role="progressbar" 
                                             style="width: <?= $task['progress']; ?>%;" 
                                             aria-valuenow="<?= $task['progress']; ?>" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"
                                             title="<?= $task['status_text'] ?>">
                                            <strong><?= round($task['progress']) ?>%</strong>
                                            <?php if ($task['progress'] > 20): ?>
                                                <small class="d-block"><?= round($task['progress'] / 100 * 7) ?>/7 βήματα</small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <small class="text-muted"><?= $task['status_text'] ?></small>
                                </td>
                                
                            </tr>
                            
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php //echo json_encode($vendors_stats); ?>
            
         <div class="container mt-5">
    <h2 class="text-center text-primary mb-4">Μέσος Χρόνος Παράδοσης ανά Προμηθευτή</h2>
    <table class="table table-striped table-responsive table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Προμηθευτής</th>
                <th>Μ.Ο. Order ➔ Receive (μέρες)</th>
                <th>Μ.Ο. Receive ➔ Παράδοση (μέρες)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendors_stats as $vendor): ?>
                <tr class="vendor-row">
                    <td><?php echo htmlspecialchars($vendor->vendor_name); ?></td>
                    <td class="<?php echo $vendor->avg_order_to_receive_days == 0 ? 'text-danger' : 'text-success'; ?>">
                        <?php echo $vendor->avg_order_to_receive_days ? number_format($vendor->avg_order_to_receive_days, 2) : 'Δεν υπάρχουν δεδομένα'; ?>
                    </td>
                    <td class="<?php echo $vendor->avg_receive_to_delivery_days == 0 ? 'text-danger' : 'text-success'; ?>">
                        <?php echo $vendor->avg_receive_to_delivery_days ? number_format($vendor->avg_receive_to_delivery_days, 2) : 'Δεν υπάρχουν δεδομένα'; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
    /* Background colors for alternating rows */
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-striped tbody tr:nth-of-type(even) {
        background-color: #e9ecef;
    }

    /* Highlight the rows on hover */
    .table-hover tbody tr:hover {
        background-color: #d1ecf1;
    }

    /* Styling the headings */
    .thead-dark {
        background-color: #343a40;
        color: #fff;
    }

    /* Adding custom styles for the text colors */
    .text-success {
        color: #28a745 !important;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .text-center {
        text-align: center;
    }

    /* Styling the title */
    h2.text-primary {
        font-size: 1.75rem;
        font-weight: bold;
    }

    /* Adding some shadow to the table for depth */
    table {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
</style>

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
                    <!-- Hidden field για task ID -->
                    <input type="hidden" id="taskId" name="id">
                    
                    <!-- Progress indicator για το modal -->
                    <div class="progress-indicator" style="margin-bottom: 15px; display: none;">
                        <div class="alert alert-info">
                            <strong>Πρόοδος Εργασίας:</strong>
                            <div class="progress" style="margin-top: 5px;">
                                <div class="progress-bar" id="modalProgressBar" role="progressbar" style="width: 0%;">
                                    <span id="modalProgressText">0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                                        
                    <!-- Dropdown for selecting customer -->
                    <div class="form-group">
                        <label for="taskClient" class="control-label">
                            Πελάτης: <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" id="taskClient" name="client" required>
                            <option value="">Επιλέξτε Πελάτη</option>
                            <?php foreach ($clients as $client): ?>
                                <option value="<?= $client['id']; ?>"><?= htmlspecialchars($client['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            Παρακαλώ επιλέξτε έναν πελάτη.
                        </div>
                    </div>

                    <!-- Acoustic Selection Section -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Ακουστικά</h4>
                        </div>
                        <div class="panel-body">
                            <!-- Dropdown for selecting Right Acoustic -->
                            <div class="form-group">
                                <label for="taskAcoustic" class="control-label">
                                    <i class="fa fa-volume-up"></i> Ακουστικό Δεξί (R):
                                </label>
                                <select class="form-control" id="taskAcoustic" name="acoustic_id">
                                    <option value="">Επιλέξτε Ακουστικό Δεξί</option>
                                    <?php foreach ($acoustics as $acoustic): ?>
                                        <option value="<?= $acoustic['id']; ?>" <?= isset($task['acoustic_id']) && $task['acoustic_id'] == $acoustic['id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($acoustic['serial']) ?> 
                                            (<?= htmlspecialchars($acoustic['ha_model']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <!-- Dropdown for selecting Left Acoustic -->
                            <div class="form-group">
                                <label for="taskAcoustic2" class="control-label">
                                    <i class="fa fa-volume-up"></i> Ακουστικό Αριστερό (L):
                                </label>
                                <select class="form-control" id="taskAcoustic2" name="acoustic_id_2">
                                    <option value="">Επιλέξτε Ακουστικό Αριστερό</option>
                                    <?php foreach ($acoustics as $acoustic): ?>
                                        <option value="<?= $acoustic['id']; ?>" <?= isset($task['acoustic_id_2']) && $task['acoustic_id_2'] == $acoustic['id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($acoustic['serial']) ?> 
                                            (<?= htmlspecialchars($acoustic['ha_model']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <!-- Buttons για acoustic management -->
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-info" onclick="loadAcoustics()">
                                    <i class="fa fa-refresh"></i> Ανανέωση Λίστας
                                </button>
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addAcousticModal">
                                    <i class="fa fa-plus"></i> Προσθήκη Νέου
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- Task Progress Steps -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Βήματα Εργασίας (7/7)</h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Checkbox for Scan -->
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label for="taskScan">
                                                <input type="checkbox" id="taskScan" name="scan" value="1" onchange="updateModalProgress()">
                                                <i class="fa fa-search"></i> Scan
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Checkbox for Gnomateusi -->
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label for="taskGnomateusi">
                                                <input type="checkbox" id="taskGnomateusi" name="gnomateusi" value="1" onchange="updateModalProgress()">
                                                <i class="fa fa-stethoscope"></i> Γνωμάτευση
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Checkbox for Tel Rdv -->
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label for="taskTelRdv">
                                                <input type="checkbox" id="taskTelRdv" name="tel_rdv" value="1" onchange="updateModalProgress()">
                                                <i class="fa fa-phone"></i> Τηλ Ραντεβού
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Checkbox for Ektelesi -->
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label for="taskEktelesi">
                                                <input type="checkbox" id="taskEktelesi" name="ektelesi" value="1" onchange="updateModalProgress()">
                                                <i class="fa fa-cogs"></i> Εκτέλεση
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <!-- Date for Order -->
                                    <div class="form-group">
                                        <label for="taskOrder" class="control-label">
                                            <i class="fa fa-calendar"></i> Ημ/νία Παραγγελίας:
                                        </label>
                                        <input type="date" class="form-control" id="taskOrder" name="order" onchange="updateModalProgress()">
                                    </div>

                                    <!-- Checkbox for Signatures -->
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label for="taskSignatures">
                                                <input type="checkbox" id="taskSignatures" name="signatures" value="1" onchange="updateModalProgress()">
                                                <i class="fa fa-edit"></i> Υπογραφές
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Checkbox for Receipt -->
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label for="taskReceipt">
                                                <input type="checkbox" id="taskReceipt" name="receipt" value="1" onchange="updateModalProgress()">
                                                <i class="fa fa-file-text"></i> Απόδειξη
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Checkbox for Arxeio -->
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label for="taskArxeio">
                                                <input type="checkbox" id="taskArxeio" name="arxeio" value="1" onchange="updateModalProgress()">
                                                <i class="fa fa-archive"></i> Αρχείο
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
<!--modal for comments -->
<div class="modal fade" id="commentsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Comments</h4>
            </div>
            <div class="modal-body">
                <p id="modalCommentsContent"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                
                // Update progress bar in real-time
                updateTaskProgress(taskId);
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Σφάλμα κατά την ενημέρωση της βάσης δεδομένων.');
            }
        });
    });

    // Function to calculate and update progress bar
    function updateTaskProgress(taskId) {
        var totalSteps = 7;
        var completedSteps = 0;
        
        // Count completed checkboxes for this task
        $('input[data-id="' + taskId + '"]').each(function() {
            var field = $(this).data('field');
            
            if (field === 'order') {
                // For date fields, check if value is not empty and not '0000-00-00'
                var value = $(this).val();
                if (value && value !== '0000-00-00') {
                    completedSteps++;
                }
            } else if ($(this).is(':checkbox') && $(this).is(':checked')) {
                // For checkboxes, check if they are checked
                completedSteps++;
            }
        });
        
        var progress = Math.round((completedSteps / totalSteps) * 100);
        
        // Update progress bar
        var progressBar = $('tr').find('input[data-id="' + taskId + '"]').first().closest('tr').find('.progress-bar');
        progressBar.css('width', progress + '%');
        progressBar.attr('aria-valuenow', progress);
        progressBar.find('strong').text(progress + '%');
        
        // Update steps indicator
        if (progress > 20) {
            progressBar.find('small').text(completedSteps + '/7 βήματα');
        }
        
        // Update progress bar color based on progress
        progressBar.removeClass('progress-bar-danger progress-bar-warning progress-bar-info progress-bar-primary progress-bar-success');
        if (progress == 0) {
            progressBar.addClass('progress-bar-danger');
        } else if (progress < 30) {
            progressBar.addClass('progress-bar-warning');
        } else if (progress < 70) {
            progressBar.addClass('progress-bar-info');
        } else if (progress < 100) {
            progressBar.addClass('progress-bar-primary');
        } else {
            progressBar.addClass('progress-bar-success');
        }
    }

    // Update date fields (e.g., order date)
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
                
                // Update background color based on date value
                var backgroundColor = (dateValue && dateValue !== '0000-00-00') ? '#d4edda' : '#f8d7da';
                $('input[data-id="' + taskId + '"][data-field="' + field + '"]').closest('td').css('background-color', backgroundColor);
                
                // Update progress bar for date fields that count towards progress
                if (field === 'order') {
                    updateTaskProgress(taskId);
                }
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


$(document).ready(function() {
    $('.viewCommentsBtn').on('click', function() {
        var comments = $(this).data('comments'); // Get comments from data attribute
        $('#modalCommentsContent').text(comments); // Set comments in modal
        $('#commentsModal').modal('show'); // Show the modal
    });
});

// Function to update modal progress in real-time
function updateModalProgress() {
    var completedSteps = 0;
    var totalSteps = 7;
    
    // Count completed checkboxes
    $('#taskForm input[type="checkbox"]:checked').each(function() {
        completedSteps++;
    });
    
    // Check if order date is filled
    var orderDate = $('#taskOrder').val();
    if (orderDate && orderDate !== '0000-00-00') {
        completedSteps++;
    }
    
    var progress = Math.round((completedSteps / totalSteps) * 100);
    
    // Update progress bar in modal
    $('#modalProgressBar').css('width', progress + '%');
    $('#modalProgressBar').attr('aria-valuenow', progress);
    $('#modalProgressText').text(progress + '% (' + completedSteps + '/' + totalSteps + ' βήματα)');
    
    // Update progress bar color
    $('#modalProgressBar').removeClass('progress-bar-danger progress-bar-warning progress-bar-info progress-bar-primary progress-bar-success');
    if (progress == 0) {
        $('#modalProgressBar').addClass('progress-bar-danger');
    } else if (progress < 30) {
        $('#modalProgressBar').addClass('progress-bar-warning');
    } else if (progress < 70) {
        $('#modalProgressBar').addClass('progress-bar-info');
    } else if (progress < 100) {
        $('#modalProgressBar').addClass('progress-bar-primary');
    } else {
        $('#modalProgressBar').addClass('progress-bar-success');
    }
    
    // Show/hide progress indicator
    if (progress > 0) {
        $('.progress-indicator').show();
    }
}

// Function to load/refresh acoustics
function loadAcoustics() {
    $.ajax({
        url: '<?= base_url('admin/tasks/get_acoustics') ?>',
        method: 'GET',
        success: function(response) {
            var acoustics = JSON.parse(response);
            var options = '<option value="">Επιλέξτε Ακουστικό</option>';
            
            acoustics.forEach(function(acoustic) {
                options += '<option value="' + acoustic.id + '">' + 
                          acoustic.serial + ' (' + acoustic.ha_model + ')</option>';
            });
            
            $('#taskAcoustic, #taskAcoustic2').html(options);
            
            // Show success message
            $('<div class="alert alert-success alert-dismissible" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">' +
              '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
              '<strong>Επιτυχία!</strong> Η λίστα ακουστικών ανανεώθηκε.' +
              '</div>').appendTo('body').delay(3000).fadeOut();
        },
        error: function() {
            alert('Σφάλμα κατά την ανανέωση της λίστας ακουστικών.');
        }
    });
}

</script>