<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">Καρτέλα Ακουστικού</h2>
        </div>
    </div>

    <div class="row">
        <!-- Αριστερή Στήλη με Πληροφορίες Ακουστικού -->
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <strong>Serial No: <?= $stock->serial ?></strong>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Κατασκευαστής</th>
                                <td><?= isset($manufacturer->name) ? $manufacturer->name : 'N/A' ?></td>
                            </tr>
                            <tr>
                                <th>Μοντέλο</th>
                                <td><?= isset($series->series) ? $series->series . ' - ' . $ha_model->model : 'N/A' ?></td>
                            </tr>
                            <tr>
                                <th>Τύπος</th>
                                <td><?= isset($ha_type->type) ? $ha_type->type : 'N/A' ?></td>
                            </tr>
                            <tr>
                                <th>Ημ/νια Εισαγωγής</th>
                                <td><?= $stock->day_in ?></td>
                            </tr>
                            <tr>
                                <th>Ημ/νια Πώλησης</th>
                                <td><?= $stock->day_out ?></td>
                            </tr>
                            <tr>
                                <th>Λήξη Εγγύησης</th>
                                <td><?= $stock->guarantee_end ?></td>
                            </tr>
                            <tr>
                                <th>Προμηθευτής</th>
                                <td><?= isset($vendor->name) ? $vendor->name : 'N/A' ?></td>
                            </tr>
                            <tr>
                                <th>Κατάσταση</th>
                                <td><?= isset($status->status) ? $status->status : 'N/A' ?></td>
                            </tr>
                            <tr>
                                <th>Πελάτης</th>
                                <td><?= isset($customer->name) ? $customer->name : 'N/A' ?></td>
                            </tr>
                            <tr>
                                <th>Barcode ΕΟΠΥΥ</th>
                                <td><?= $stock->ekapty_code ?></td>
                            </tr>
                            <tr>
                                <th>Εκτέλεση ΕΟΠΥΥ</th>
                                <td><?= $stock->ektelesi_eopyy ?></td>
                            </tr>
                            <tr>
                                <th>Σχόλια</th>
                                <td><?= $stock->comments ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="<?= base_url('admin/stocks/edit/' . $stock->id) ?>" class="btn btn-success btn-block">Επεξεργασία Ακουστικού</a>
                </div>
            </div>
        </div>

        <!-- Δεξιά Στήλη με τα Tabs για Επισκευές και Πληρωμές -->
        <div class="col-xs-12 col-md-6">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#repairs">Επισκευές</a></li>
                <li><a data-toggle="tab" href="#payments">Πληρωμές</a></li>
            </ul>

            <div class="tab-content">
                <!-- Επισκευές -->
                <div id="repairs" class="tab-pane fade in active">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>Προβολή Επισκευών</strong>
                        </div>
                        <div class="panel-body table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ημερομηνία</th>
                                        <th>Συμπτώματα</th>
                                        <th>Ενέργειες</th>
                                        <th>Εργαστήριο Επισκευής</th>
                                        <th>Αναφορά Εργαστηρίου</th>
                                        <th>Κόστος</th>
                                        <th>Ενέργειες</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $this->load->model(['admin/service', 'admin/service_status', 'admin/stock', 'admin/model']); ?>
                                    <?php foreach ($services as $service): ?>
                                        <tr>
                                            <td><?= $service['day_in'] ?></td>
                                            <td><?= $service['malfunction'] ?></td>
                                            <td><?= $this->service_status->get($service['action_service'])->status ?></td>
                                            <td><?= $this->vendor->get($service['lab_sent'])->name ?></td>
                                            <td><?= $service['lab_report'] ?></td>
                                            <td>€ <?= $service['price'] ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/services/edit/' . $service['id']) ?>" class="btn btn-info btn-block">Επεξεργασία</a>
                                                <a href="<?= base_url('admin/stocks/eggyisi_doc/' . $service['id']) ?>" class="btn btn-success btn-block">Εγγύηση</a>
                                                <a href="<?= base_url('admin/services/service_doc/' . $service['id']) ?>" class="btn btn-info btn-block">Δελτίο Επισκευής</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <a href="<?= base_url('admin/services/create_this/' . $stock->id) ?>" class="btn btn-info btn-block">Νέα Επισκευή</a>
                        </div>
                    </div>
                </div>

                <!-- Πληρωμές -->
                <div id="payments" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>Προβολή Πληρωμών</strong>
                        </div>
                        <div class="panel-body table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ημερομηνία</th>
                                        <th>Ποσό</th>
                                        <th>Ενέργειες</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pays as $pay): ?>
                                        <tr>
                                            <td><?= $pay['date'] ?></td>
                                            <td>€ <?= number_format($pay['pay'], 2) ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/pays/edit/' . $pay['id']) ?>" class="btn btn-info btn-block">Επεξεργασία</a>
                                                <a href="<?= base_url('admin/pays/delete/' . $pay['id']) ?>" class="btn btn-danger btn-block" onclick="return confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτή την πληρωμή;');">Διαγραφή</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <strong>Υπόλοιπο Πελάτη: € <?= number_format($sum_pays[0]['balance'], 2) ?></strong>
                            <a href="<?= base_url('admin/pays/create_specific_ha/' . $stock->id) ?>" class="btn btn-success btn-block">Προσθήκη Πληρωμής</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Επιστροφή στην Καρτέλα Πελάτη -->
    <a href="<?= base_url('admin/customers/view/' . $customer->id) ?>" class="btn btn-warning btn-block">Πίσω στην Καρτέλα Πελάτη</a>
</div>
