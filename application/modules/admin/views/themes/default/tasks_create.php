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
                        <div class="col-lg-6">
                            <form role="form" method="POST" action="<?= base_url('admin/tasks/create') ?>">
                                <div class="form-group">
                                    <label>Client</label>
                                    <select class="form-control" id="client" name="client">
                                        <?php if (count($clients)): ?>
                                            <?php foreach ($clients as $client): ?>
                                                <option value="<?= $client['id'] ?>"><?= $client['name'] ?></option>
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
