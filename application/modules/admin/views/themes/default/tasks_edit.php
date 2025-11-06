<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>
                Επεξεργασία Task
                <a href="<?= base_url('admin/tasks') ?>" class="btn btn-warning">Πίσω στη λίστα Tasks</a>
            </h2>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Επεξεργασία Στοιχείων Task
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php if ($this->session->flashdata('message')): ?>
                        <div class="col-lg-12 col-md-12">
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?= $this->session->flashdata('message') ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-lg-6">
                            <!-- Φόρμα επεξεργασίας -->
                            <form role="form" method="POST" action="<?= base_url('admin/tasks/edit/' . $task->id) ?>">
                                
                                <!-- Client dropdown -->
                                <div class="form-group">
                                    <label>Client</label>
                                    <select class="form-control" id="client" name="client">
                                        <option value="">-- Επιλέξτε πελάτη --</option>
        <?php if (count($clients)): ?>
            <?php foreach ($clients as $client): ?>
                                        <option value="<?= $client->id ?>" <?= $task->client == $client->id ? 'selected' : '' ?>>
                    <?= $client['name'] ?>
                                        </option>
            <?php endforeach; ?>
        <?php endif; ?>
                                    </select>
                                </div>
                                
                                <!-- Include jQuery and Select2 -->
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>                               
                                
                                
                                <!-- Scan checkbox -->
                                <div class="form-group">
                                    <label>Scan</label>
                                    <input type="checkbox" id="scan" name="scan" value="1" <?= isset($task->scan) && $task->scan ? 'checked' : '' ?>>
                                </div>

                                <!-- Order Date input -->
                                <div class="form-group">
                                    <label>Order Date</label>
                                    <input type="date" class="form-control" id="order" name="order" value="<?= isset($task->order) ? $task->order : '' ?>">
                                </div>
                                
                                <!-- Γνωμάτευση checkbox -->
                                <div class="form-group">
                                    <label>Γνωμάτευση</label>
                                    <input type="checkbox" id="gnomateusi" name="gnomateusi" value="1" <?= isset($task->gnomateusi) && $task->gnomateusi ? 'checked' : '' ?>>
                                </div>
                                
                                <!-- Παραλαβή checkbox -->
                                <div class="form-group">
                                    <label>Παραλαβή</label>
                                    <input type="checkbox" id="receive" name="receive" value="1" <?= isset($task->receive) && $task->receive ? 'checked' : '' ?>>
                                </div>
                                
                                <!-- Τηλεφωνικό Ραντεβού checkbox -->
                                <div class="form-group">
                                    <label>Τηλεφωνικό Ραντεβού</label>
                                    <input type="checkbox" id="tel_rdv" name="tel_rdv" value="1" <?= isset($task->tel_rdv) && $task->tel_rdv ? 'checked' : '' ?>>
                                </div>
                                
                                <!-- Εκτέλεση checkbox -->
                                <div class="form-group">
                                    <label>Εκτέλεση</label>
                                    <input type="checkbox" id="ektelesi" name="ektelesi" value="1" <?= isset($task->ektelesi) && $task->ektelesi ? 'checked' : '' ?>>
                                </div>
                                
                                <!-- Παράδοση checkbox -->
                                <div class="form-group">
                                    <label>Παράδοση</label>
                                    <input type="checkbox" id="paradosi" name="paradosi" value="1" <?= isset($task->paradosi) && $task->paradosi ? 'checked' : '' ?>>
                                </div>
                                
                                <!-- Υπογραφές checkbox -->
                                <div class="form-group">
                                    <label>Υπογραφές</label>
                                    <input type="checkbox" id="signatures" name="signatures" value="1" <?= isset($task->signatures) && $task->signatures ? 'checked' : '' ?>>
                                </div>
                                
                                <!-- Απόδειξη checkbox -->
                                <div class="form-group">
                                    <label>Απόδειξη</label>
                                    <input type="checkbox" id="receipt" name="receipt" value="1" <?= isset($task->receipt) && $task->receipt ? 'checked' : '' ?>>
                                </div>
                                
                                <!-- Αρχείο checkbox -->
                                <div class="form-group">
                                    <label>Αρχείο</label>
                                    <input type="checkbox" id="arxeio" name="arxeio" value="1" <?= isset($task->arxeio) && $task->arxeio ? 'checked' : '' ?>>
                                </div>
                                
                                
                                <!-- Save and Cancel buttons -->
                                <button type="submit" class="btn btn-primary">Αποθήκευση Αλλαγών</button>
                                <a href="<?= base_url('admin/tasks') ?>" class="btn btn-default">Ακύρωση</a>
                            </form>
                        </div>
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /#page-wrapper -->
<script>
    $(document).ready(function() {
        $('#client').select2({
            placeholder: "Αναζήτηση πελάτη...",
            allowClear: true
        });
    });
</script>
<!-- Activate Select2 on the client dropdown -->
<script>
    $(document).ready(function() {
        $('#client').select2({
            placeholder: "Αναζήτηση πελάτη...",
            allowClear: true
        });
    });
</script>
