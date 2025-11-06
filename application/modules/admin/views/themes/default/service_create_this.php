<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header"><h2>Επισκευές Εργαστηρίου</h2></div>
            <div class="users-header"><a  href="<?= base_url('admin/services/create') ?>" class="btn btn-success">Προσθήκη Νέου</a></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Προσθήκη Επισκευής</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" method="POST" action="<?= base_url('admin/services/create/') ?>">                                               
                                <div class="form-group">
                                    <label>Ακουστικό Επισκευής</label>  
                                    <textarea class="form-control" id="ha_service_text">Model: <?= $ha_ser->model ?> - s/n:<?= $ha_ser->serial ?></textarea>
                                    <input class="form-group" id="ha_service" name="ha_service" value="<?= $ha_ser->id ?>" hidden="1">                              
                                </div>     
                                <div class="form-group">
                                    <label>Ημ/νια Παραλαβής</label>
                                    <input class="form-control" type="date" id="day_in" name="day_in">
                                </div>
                                <div class="form-group">
                                    <label>Ακουστικό Αντικατάστασης</label>                                                                       
                                    <select class="form-control" id="ha_temp" name="ha_temp">
                                        <?php if (count($stock)): ?>
                                            <?php foreach ($stock as $key => $ha_temp) : ?>
                                                <?php if ($ha_temp['status'] == 5):  ?>
                                                <option value="<?= $ha_temp['id'] ?>"><?= $ha_temp['serial'] ?>-<?=  $ha_temp['model'] ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select> 
                                </div>
                                <div class="form-group">
                                    <label>Ενέργεια</label>                                                                       
                                    <select class="form-control" id="action_service" name="action_service">
                                        <?php if (count($status)): ?>
                                            <?php foreach ($status as $key => $status): ?>
                                                <option value="<?= $status['id'] ?>"><?= $status['status'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select> 
                                </div>                                
                                <div class="form-group">
                                    <label>Συμπτώματα</label>
                                    <input class="form-control" placeholder="Εισαγάγετε Στμπτώματα βλάβης" id="malfunction" name="malfunction">
                                </div>
                                <div class="form-group">
                                    <label>Αναφορά Εργαστηρίου</label>
                                    <input class="form-control" placeholder="Αναφορά Εργαστηρίου" id="lab_report" name="lab_report">
                                </div> 
                                <div class="form-group">
                                    <label>Ενεργεια Εργαστηριου - Επισκευή</label>
                                    <select class="form-control" name="lab_service" id="lab_service">                                      
                                        <?php if (count($subcategories)): ?>
                                            <?php foreach ($subcategories as $key => $subcategories): ?>
                                                <option value="<?= $subcategories['id'] ?>"><?= $subcategories['subcategory'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select> 
                                </div>                                 
                                <div class="form-group">
                                    <label>Εργαστήριο Επισκευής</label>                                                                       
                                    <select class="form-control" id="lab_sent" name="lab_sent">
                                        <?php if (count($vendor)): ?>
                                            <?php foreach ($vendor as $key => $vendor): ?>
                                                <option value="<?= $vendor['id'] ?>"><?= $vendor['name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select> 
                                </div>                                
                                <div class="form-group">
                                    <label>Κόστος</label>
                                    <input class="form-control" placeholder="Εισαγάγετε Κόστος Επισκευής" id="price" name="price">
                                </div>
                                <div class="form-group">
                                    <label>Κατάσταση Επισκευής</label>                                                                       
                                    <select class="form-control" id="action_service" name="status">
                                        <?php if (count($ser_condition)): ?>
                                            <?php foreach ($ser_condition as $key => $status): ?>
                                                <option value="<?= $status['id'] ?>"><?= $status['status'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select> 
                                </div>                                

                                <button type="submit" class="btn btn-primary">Εισαγωγή</button>
                                <?php echo $stock->id?>
                            </form>
                        </div>
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <a  href="<?= base_url('admin/services') ?>" class="btn btn-warning">Πίσω στη λίστα κατασκευών</a>
</div><!-- /#page-wrapper -->
