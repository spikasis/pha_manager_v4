<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>Ακουστικό</h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default panel-danger">
                <div class="panel-heading">
                    Επεξεργασία Ακουστικού
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form" method="POST" action="<?= base_url('admin/stocks/edit/' . $stock->id) ?>">
                                <div class="col-lg-6">                                    
                                    <div class="form-group">
                                        <label>Hearing Aid ID</label>
                                        <input class="form-control" value="<?= $stock->id ?>" placeholder="Auto generated" disabled="1">
                                    </div>
                                    <div class="form-group">
                                        <label>Serial No</label>
                                        <input class="form-control" value="<?= $stock->serial ?>" placeholder="Εισαγάγετε Σειριακό Αριθμό" id="serial" name="serial">
                                    </div>
                                    <div class="form-group">
                                        <label>Ημ/νια Εισαγωγής</label>
                                        <input class="form-control" type="date" value="<?= $stock->day_in ?>" placeholder="Εισαγάγετε Ημερομηνία Εισαγωγής" id="day_in" name="day_in">
                                    </div>
                                    <div class="form-group">
                                        <label>Ημ/νια Πώλησης</label>
                                        <input class="form-control" type="date" value="<?= $stock->day_out ?>" placeholder="Εισαγάγετε Ημερομηνία Πώλησης" id="day_out" name="day_out">
                                    </div>
                                    <div class="form-group">
                                        <label>Λήξη Εγγύησης</label>
                                        <input class="form-control" type="date" value="<?= $stock->guarantee_end ?>" placeholder="Εισαγάγετε Ημερομηνία Λήξης Εγγύησης" id="guarantee_end" name="guarantee_end">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Μοντέλο</label>
                                        <input list="model_idS" name="ha_model" id="ha_model" class="form-control" value="<?= $stock->ha_model ?>">
                                        <datalist id="model_idS">
                                            <?php if (count($ha_models)): ?>
                                                <?php foreach ($ha_models as $ha_models): ?>
                                                    <?php 
                                                    $type = $this->ha_type->get($ha_models['ha_type']);
                                                    $series = $this->serie->get($ha_models['series']);
                                                    $brand = $this->manufacturer->get($series->brand);
                                                    $battery = $this->battery_type->get($ha_models['battery']);
                                                    ?>
                                                    <option value="<?= $ha_models['id'] ?>" <?= ($stock->ha_model == $ha_models['id']) ? 'selected="selected"' : '' ?>> <?= $brand->name ?> <?= $series->series ?>-<?= $ha_models['model'] ?>-<?= $type->type ?> - Bat. No <?= $battery->type ?> </option>                                                 
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </datalist>
                                    </div>

                                    <div class="form-group">
                                        <label>Ιατρός</label>
                                        <select class="form-control" id="doctor" name="doctor_id">
                                            <option value="" <?= empty($stock->doctor_id) ? 'selected' : '' ?>>Επιλέξτε Ιατρό</option>
                                            <?php if (count($doctors)): ?>
                                                <?php foreach ($doctors as $doctor): ?>
                                                    <option value="<?= $doctor['id'] ?>" <?= ($stock->doctor_id == $doctor['id']) ? 'selected="selected"' : '' ?>> <?= $doctor['doc_name'] ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">                                
                                    <div class="form-group">
                                        <label>Προμηθευτής</label>
                                        <select class="form-control" id="vendor" name="vendor">
                                            <option value="" <?= empty($stock->vendor) ? 'selected' : '' ?>>Επιλέξτε Προμηθευτή</option>
                                            <?php if (count($vendors)): ?>
                                                <?php foreach ($vendors as $vendor): ?>
                                                    <option value="<?= $vendor['id'] ?>" <?= ($stock->vendor == $vendor['id']) ? 'selected="selected"' : '' ?>> <?= $vendor['name'] ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>                                    
                                    </div>
                                    <div class="form-group">
                                        <label>Κατάσταση</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="" <?= empty($stock->status) ? 'selected' : '' ?>>Επιλέξτε Κατάσταση</option>
                                            <?php if (count($stock_status)): ?>
                                                <?php foreach ($stock_status as $status): ?>
                                                    <option value="<?= $status['id'] ?>" <?= ($stock->status == $status['id']) ? 'selected="selected"' : '' ?>> <?= $status['status'] ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>                                    
                                    </div>
                                    <div class="form-group">
                                        <label>Πελάτης</label>
                                        <select class="form-control" id="customer_id" name="customer_id"> 
                                            <option value="" <?= empty($stock->customer_id) ? 'selected' : '' ?>>Επιλέξτε Πελάτη</option>
                                            <?php if (count($customers)): ?>
                                                <?php foreach ($customers as $customer): ?>
                                                    <option value="<?= $customer['id'] ?>" <?= ($stock->customer_id == $customer['id']) ? 'selected="selected"' : '' ?>> <?= $customer['name'] ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>                                   
                                    </div>
                                    <div class="form-group">
                                        <label>Τιμή Πώλησης</label>
                                        <input class="form-control" value="<?= $stock->ha_price ?>" placeholder="Εισαγάγετε Τιμή Πώλησης" id="ha_price" name="ha_price">
                                    </div>
                                    <div class="form-group">
                                        <label>Συμμετοχή Ταμείου</label>
                                        <input class="form-control" value="<?= $stock->eopyy ?>" placeholder="Εισαγάγετε ΕΟΠΥΥ" id="eopyy" name="eopyy">
                                    </div>
                                    <div class="form-group">
                                        <label>Σημείο Πώλησης - Αποθήκη</label>
                                        <select class="form-control" id="selling_point" name="selling_point">
                                            <option value="" <?= empty($stock->selling_point) ? 'selected' : '' ?>>Επιλέξτε Σημείο Πώλησης</option>
                                            <?php if (count($selling_point)): ?>
                                                <?php foreach ($selling_point as $list): ?>
                                                    <option value="<?= $list['id'] ?>" <?= ($stock->selling_point == $list['id']) ? 'selected="selected"' : '' ?>> <?= $list['city'] ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>                                    
                                    </div>
                                    <div class="form-group">
                                        <label>Barcode ΕΟΠΥΥ</label>
                                        <input class="form-control" value="<?= $stock->ekapty_code ?>" placeholder="BARCODE ΕΟΠΥΥ" id="ekapty_code" name="ekapty_code">
                                    </div>
                                    <div class="form-group">
                                        <label>Εκτέλεση ΕΟΠΥΥ</label>
                                        <input class="form-control" value="<?= $stock->ektelesi_eopyy ?>" placeholder="Εκτέλεση ΕΟΠΥΥ" id="ektelesi_eopyy" name="ektelesi_eopyy">
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Σχόλια</label>
                                    <input class="form-control" value="<?= $stock->comments ?>" placeholder="Εισαγάγετε Σχόλια" id="comments" name="comments">
                                </div> 
                                
                                <button type="submit" class="btn btn-primary">Εισαγωγή</button>
                            </form>
                        </div>
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
            <a href="<?= base_url('admin/stocks') ?>" class="btn btn-warning">Πίσω στη λίστα αποθήκης</a>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->    
</div><!-- /#page-wrapper -->
