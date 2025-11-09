<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>
                Δημιουργία Task
                <a href="<?= base_url('admin/tasks') ?>" class="btn btn-warning">Πίσω στη λίστα Tasks</a>
            </h2>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Εισαγωγή Στοιχείων Task
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
                        <div class="col-lg-8">
                            <form role="form" method="POST" action="<?= base_url('admin/tasks/create') ?>">
                                <?php if (isset($preset_customer_id) && $preset_customer_id): ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> 
                                    Δημιουργία task για τον πελάτη: <strong><?= $preset_customer->name ?? 'Άγνωστος' ?></strong>
                                    <?php if (isset($preset_acoustic_id) && $preset_acoustic_id): ?>
                                    <br>Ακουστικό: <strong><?= $preset_acoustic->serial ?? 'Άγνωστο' ?></strong>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                
                                <div class="form-group">
                                    <label>Client</label>
                                    <select class="form-control" id="client" name="client" <?= (isset($preset_customer_id) && $preset_customer_id) ? 'readonly' : '' ?>>
                                        <?php if (count($clients)): ?>
                                            <?php foreach ($clients as $client): ?>
                                                <option value="<?= $client['id'] ?>" 
                                                    <?= (isset($preset_customer_id) && $preset_customer_id == $client['id']) ? 'selected' : '' ?>>
                                                    <?= $client['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Ακουστικό #1 (Προαιρετικό)</label>
                                    <select class="form-control" id="acoustic_id" name="acoustic_id">
                                        <option value="">-- Επιλέξτε Ακουστικό --</option>
                                        <?php if (isset($acoustics) && count($acoustics)): ?>
                                            <?php foreach ($acoustics as $acoustic): ?>
                                                <option value="<?= $acoustic['id'] ?>" 
                                                    <?= (isset($preset_acoustic_id) && $preset_acoustic_id == $acoustic['id']) ? 'selected' : '' ?>>
                                                    <?= $acoustic['serial'] ?> - <?= $acoustic['manufacturer'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Ακουστικό #2 (Προαιρετικό)</label>
                                    <select class="form-control" id="acoustic_id_2" name="acoustic_id_2">
                                        <option value="">-- Επιλέξτε Δεύτερο Ακουστικό --</option>
                                        <?php if (isset($acoustics) && count($acoustics)): ?>
                                            <?php foreach ($acoustics as $acoustic): ?>
                                                <option value="<?= $acoustic['id'] ?>">
                                                    <?= $acoustic['serial'] ?> - <?= $acoustic['manufacturer'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Scan</label>
                                    <input type="checkbox" id="scan" name="scan" value="1">
                                </div>

                                <div class="form-group">
                                    <label>Order Date</label>
                                    <input type="date" class="form-control" id="order" name="order">
                                </div>

                                <div class="form-group">
                                    <label>Γνωμάτευση</label>
                                    <input type="checkbox" id="gnomateusi" name="gnomateusi" value="1">
                                </div>

                                <div class="form-group">
                                    <label>Παραλαβή</label>
                                    <input type="checkbox" id="receive" name="receive" value="1">
                                </div>

                                <div class="form-group">
                                    <label>Τηλεφωνικό Ραντεβού</label>
                                    <input type="checkbox" id="tel_rdv" name="tel_rdv" value="1">
                                </div>

                                <div class="form-group">
                                    <label>Εκτέλεση</label>
                                    <input type="checkbox" id="ektelesi" name="ektelesi" value="1">
                                </div>

                                <div class="form-group">
                                    <label>Παράδοση</label>
                                    <input type="checkbox" id="paradosi" name="paradosi" value="1">
                                </div>

                                <div class="form-group">
                                    <label>Υπογραφές</label>
                                    <input type="checkbox" id="signatures" name="signatures" value="1">
                                </div>

                                <div class="form-group">
                                    <label>Απόδειξη</label>
                                    <input type="checkbox" id="receipt" name="receipt" value="1">
                                </div>

                                <div class="form-group">
                                    <label>Αρχείο</label>
                                    <input type="checkbox" id="arxeio" name="arxeio" value="1">
                                </div>

                                <div class="form-group">
                                    <label>Σχόλια/Παρατηρήσεις</label>
                                    <textarea class="form-control" id="comments" name="comments" rows="3" placeholder="Προσθέστε σχόλια ή παρατηρήσεις για το task..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Αποθήκευση Task</button>
                                <button type="reset" class="btn btn-default">Αρχικοποίηση</button>
                            </form>
                        </div>
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /#page-wrapper -->
