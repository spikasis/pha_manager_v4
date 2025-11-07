<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>Επισκευές</h2>
        </div>
        <!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Επεξεργασία Επισκευής</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <form role="form" method="POST" action="<?=base_url('admin/services/edit/'.$service->id)?>">
                                <!--OLD-->
                                <div class="col-lg-6">
                                    <label>Ακουστικό Επισκευής</label>
                                    <select class="form-control" id="ha_service" name="ha_service">
                                        <?php if (count($stock)): ?>
                                            <?php foreach ($stock as $key => $ha_service): ?>
                                                <option value="<?= $ha_service['id'] ?>" <?= ($service->ha_service == $ha_service['id']) ? 'selected="selected"' : '' ?>> <?= $ha_service['serial'] ?>-<?= $ha_service['model'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                    
                                </div> 
                                <div class="col-lg-4">
                                    <label>Ημ/νια Παραλαβής</label>
                                    <input class="form-control" type="date" value="<?=$service->day_in?>" id="day_in" name="day_in">
                                </div>
                                <div class="col-lg-6">
                                    <label>Ακουστικό Αντικατάστασης</label>
                                    <select class="form-control" id="ha_temp" name="ha_temp">
                                        <?php if (count($stock)): ?>                                 
                                            <?php foreach ($stock as $key => $ha_temp): ?>
                                                <?php if ($ha_temp['status'] == 5):  ?>
                                                <option value="<?= $ha_temp['id'] ?>" <?= ($service->ha_temp == $ha_temp['id']) ? 'selected="selected"' : '' ?>> <?= $ha_temp['serial'] ?>-<?= $ha_temp['model'] ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                    
                                </div>
                                 <div class="col-lg-6">
                                    <label>Συμπτώματα</label>
                                    <input class="form-control" value="<?=$service->malfunction?>" placeholder="Εισαγάγετε Συμπτωματα" id="malfunction" name="malfunction">
                                </div>
                                <div class="col-lg-6">
                                    <label>Ενέργεια</label>                                                                       
                                    <select class="form-control" id="action_service" name="action_service">
                                        <?php if (count($status)): ?>
                                            <?php foreach ($status as $key => $status): ?>
                                                <option value="<?= $status['id'] ?>" <?= ($service->action_service == $status['id']) ? 'selected="selected"' : '' ?>><?= $status['status'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select> 
                                </div> 
                                <div class="col-lg-6">
                                    <label>Αναφορά Εργαστηρίου</label>
                                    <input class="form-control" value="<?=$service->lab_report?>" placeholder="Αναφορά Εργαστηρίου" id="lab_report" name="lab_report">
                                </div>
                                <div class="col-lg-6">
                                    <label>Εργαστήριο Επισκευής</label>                                                                       
                                    <select class="form-control" id="lab_sent" name="lab_sent">
                                        <?php if (count($vendor)): ?>
                                            <?php foreach ($vendor as $key => $vendor): ?>
                                                <option value="<?= $vendor['id'] ?>" <?= ($vendor['id'] == $service->lab_sent) ? 'selected="selected"' : '' ?>><?= $vendor['name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select> 
                                </div>
                                <div class="col-lg-6">
                                    <label>Κόστος</label>
                                    <input class="form-control" value="<?=$service->price ?>" placeholder="Εισαγάγετε Κόστος Επισκευής" id="price" name="price">
                                </div>                                
                                <div class="col-lg-6">
                                    <label>Κατάσταση Επισκευής</label>                                                                       
                                    <select class="form-control" id="action_service" name="status">
                                        <?php if (count($ser_condition)): ?>
                                            <?php foreach ($ser_condition as $key => $status): ?>
                                                <option value="<?= $status['id'] ?>" <?= ($service->action_service == $status['id']) ? 'selected="selected"' : '' ?>><?= $status['status'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select> 
                                </div> <p></p>
                                    <div class="row panel panel-body">                                        
                                        <div class="col-lg-6 float-center">
                                            <label>Εργασίες που έγιναν</label>
                                            <div class="panel panel-default float-center">
                                                <div class="panel-heading float-left"><a  href="<?= base_url('admin/services/service_tickets/' . $service->id) ?>" class="btn btn-warning float-right">Προσθήκη Εργασιών</a>   </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">                                      
                                                            <div class="table" >
                                                                <?php if (count($tickets)):
                                                                    foreach ($tickets as $key => $ticket): ?>
                                                                <div class="col-lg-6" >
                                                                    <?php    $job = $this->service_subcategory->get($ticket['service_sub']); ?>
                                                                    <?php echo $job->subcategory; ?></div>
                                                                <div class="col-lg-6" ><a href="<?= base_url('admin/service_tickets/delete/' . $ticket['id']) ?>" class="btn btn-warning float-right">Διαγραφη</a></div>
                                                                    <?php endforeach; ?>
                                                                    <?php endif; ?> 
                                                            </div>                                    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <p><button type="submit" class="btn btn-primary">Εισαγωγή</button></p>                                
                            </form>                           
                        </div>
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
    <a  href="<?= base_url('admin/services') ?>" class="btn btn-warning">Πίσω στη λίστα επισκευων</a>   
</div><!-- /#page-wrapper -->

