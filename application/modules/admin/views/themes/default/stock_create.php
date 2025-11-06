<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>Προσθήκη Ακουστικού</h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default panel-green">
                <div class="panel-heading">Προσθήκη Ακουστικού</div>
                <div class="panel-body">
                    <div class="row">
                        <form role="form" method="POST" action="<?= base_url('admin/stocks/create/') ?>">
                        <div class="col-lg-6">                            
                                <div class="form-group">
                                    <label>Hearing Aid ID</label>
                                    <input class="form-control" placeholder="Auto generated" disabled="1">
                                </div>
                                <div class="form-group">
                                    <label>Serial No</label>
                                    <input class="form-control" placeholder="Εισαγάγετε Σειριακό Αριθμό" id="serial" name="serial">
                                </div>                             
                            <!--<div class="form-group">
                            <label>Τύπος Ακουστικού</label>
                            <select class="form-control" id="type" name="type">
                                        <?php if (count($ha_type)): ?>
                                            <?php foreach ($ha_type as $key => $ha_types): ?>
                            <option value="<?= $ha_types['id'] ?>"><?= $ha_types['type'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                            </select>
                            </div>                                -->
                                <div class="form-group">
                                    <label>Μοντέλο</label>
                                    <!--<select class="form-control" id="ha_model" name="ha_model">-->
                                    <input list="model_id" name="ha_model" id="ha_model" class="form-control" >
                                        <datalist id="model_id">
                                        <?php if (count($ha_models)): ?>
                                            <?php foreach ($ha_models as $key => $ha_models): ?>
                                            <?php 
                                                    $type = $this->ha_type->get($ha_models['ha_type']);
                                                    $series = $this->serie->get($ha_models['series']);
                                                    $brand = $this->manufacturer->get($series->brand);
                                                    $battery = $this->battery_type->get($ha_models['battery']);
                                            ?>
                                                <option value="<?= $ha_models['id']?> <?= $brand->name ?> <?= $series->series ?>-<?= $ha_models['model'] ?> - <?= $type->type ?> - Bat. No <?= $battery->type ?> "></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </datalist>
                                    <!--</select>-->
                                </div>                                
                                <div class="form-group">
                                    <label>Προμηθευτής</label>
                                    <select class="form-control" id="vendor" name="vendor">
                                        <?php if (count($vendors)): ?>
                                            <?php foreach ($vendors as $key => $vendor): ?>
                                                <option value="<?= $vendor['id'] ?>"><?= $vendor['name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                    
                                </div>
                                <div class="form-group">
                                    <label>Κατάσταση</label>
                                    <select class="form-control" id="status" name="status">
                                        <?php if (count($stock_status)): ?>
                                            <?php foreach ($stock_status as $key => $status): ?>
                                                <option value="<?= $status['id'] ?>"><?= $status['status'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                    
                                </div>
                                <div class="form-group">
                                    <label>Πελάτης</label>
                                    <!--    <select class="form-control" id="customer_id" name="customer_id">-->
                                    <input list="customer_idS" name="customer_id" id="customer_id" class="form-control" >
                                      <datalist class="form-group" id="customer_idS">
                                       <?php if (count($customers)): ?>
                                            <?php foreach ($customers as $key => $customer): ?>
                                                <option value="<?= $customer['id'] ?>-<?= $customer['name'] ?> "></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                      </datalist>
                                    <!--</select>  -->                                  
                                </div>                            
                               <div class="form-group">
                                    <label>Barcode ΕΟΠΥΥ</label>
                                    <input class="form-control" placeholder="BARCODE ΕΟΠΥΥ" id="ekapty_code" name="ekapty_code">
                                </div>
                                <div class="form-group">
                                    <label>Εκτέλεση ΕΟΠΥΥ</label>
                                    <input class="form-control" placeholder="Εκτέλεση ΕΟΠΥΥ" id="ektelesi_eopyy" name="ektelesi_eopyy">
                                </div>
                        </div>
                            <div class="col-lg-offset-6">
                                <div class="form-group">
                                    <label>Ημ/νια Εισαγωγής</label>
                                    <input class="form-control" type="date" placeholder="Εισαγάγετε Ημερομηνία Εισαγωγής" id="day_in" name="day_in">
                                </div>
                                <div class="form-group">
                                    <label>Ημ/νια Πώλησης</label>
                                    <input class="form-control" type="date" placeholder="Εισαγάγετε Ημερομηνία Πώλησης" id="day_out" name="day_out">
                                </div>
                                <div class="form-group">
                                    <label>Λήξη Εγγύησης</label>
                                    <input class="form-control" type="date" placeholder="Εισαγάγετε Ημερομηνία Λήξης Εγγύησης" id="guarantee_end" name="guarantee_end">
                                </div>
                            <div class="form-group">
                                    <label>Τιμή Πώλησης</label>
                                    <input class="form-control" placeholder="Εισαγάγετε Τιμή Πώλησης" id="ha_price" name="ha_price">
                                </div>
                                <div class="form-group">
                                    <label>Συμμετοχή Ταμείου</label>
                                    <input class="form-control" placeholder="Εισαγάγετε ΕΟΠΥΥ" id="eopyy" name="eopyy">
                                </div>
                                <div class="form-group">
                                    <label>Σημείο Πώλησης</label>
                                    <select class="form-control" id="selling_point" name="selling_point">
                                        <?php if (count($selling_point)): ?>
                                            <?php foreach ($selling_point as $key => $list): ?>
                                                <option value="<?= $list['id'] ?>"><?= $list['city'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                 
                                </div>
                            <div class="form-group">
                                <label>Σχόλια</label>
                                <textarea class="form-control" placeholder="Εισαγάγετε Σχόλια" id="comments" name="comments"></textarea>
                            </div>
                                <div class="form-group">
                                    <label>Ιατρός</label>
                                    <select class="form-control" id="doctor" name="doctor">
                                        <?php if (count($doctors)): ?>
                                        <?php foreach ($doctors as $key => $doctor): ?>
                                        <option value="<?= $doctor['id']; ?>"<?= ($doctor['id'] == 8) ? 'selected' : ''; ?>><?= $doctor['doc_name']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    
                                    <!--<select class="form-control" id="doctor" name="doctor">
                                        <?php if (count($doctors)): ?>
                                            <?php foreach ($doctors as $key => $doctor): ?>
                                        <option value="<?= $doctor['id']?>"><?= $doctor['doc_name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select> -->  
                                    
                                </div>                            
                            </div>                        
                        <button type="submit" class="btn btn-primary">Εισαγωγή</button>
                        <button type="reset" class="btn btn-default">Επαναφορά</button>
                        </form>
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
            <a  href="<?= base_url('admin/customers') ?>" class="btn btn-warning">Πίσω στη λίστα αποθήκης</a>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div>
<!-- /#page-wrapper -->
