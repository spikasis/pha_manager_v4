<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header"><h2>Προσθήκη Εργασιών Επισκευής Νο:<?php echo $service->id ?> (<?php echo $customer->name ?>) στις <?php echo $service->day_in ?></h2></div>            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Προσθήκη Εργασίας</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" method="POST" action="<?= base_url('admin/service_tickets/create/' . $ha_ser->id) ?>">
                                <div class="col-lg-1">
                                    <label>ID</label>  
                                    <textarea class="form-control" id="ticket" disabled="1"><?= $service->id ?></textarea>
                                    <input class="form-group" id="ticket" name="ticket" value="<?= $service->id ?>" hidden="0">                         
                                </div>
                                <div class="col-lg-3">
                                    <label>Brand</label>
                                    <textarea class="form-control" id="brand_name" disabled="1"><?= $brands->name ?></textarea>
                                    <input class="form-group" id="brand_name" name="brand_name" value="<?= $ha_ser->manufacturer ?>" hidden="1">                         
                                </div>
                                <div class="col-lg-3">
                                    <label>Ακουστικό Επισκευής</label> 
                                    <textarea class="form-control" id="ha_service_text" disabled="1">Model: <?= $ha_ser->model ?> - s/n:<?= $ha_ser->serial ?></textarea>
                                    <input class="form-group" id="ha_service" name="ha_service" value="<?= $ha_ser->id ?>" hidden="0">                         
                                </div>
                                <div class="col-lg-4">
                                    <label>Εργασία</label>                                                                       
                                    <select class="form-control" id="service_sub" name="service_sub">
                                        <?php if (count($subcategories)): ?>
                                            <?php foreach ($subcategories as $key => $subcategory): ?>
                                                <option value="<?= $subcategory['id'] ?>"><?= $subcategory['subcategory'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                    
                                </div>
                                <div class="col-lg-1">
                                    <label>Add</label>
                                    <button type="submit" class="btn btn-primary">Προσθήκη</button>
                                </div>                                
                            </form>
                        </div>
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <a  href="<?= base_url('admin/services/edit/' . $service->id) ?>" class="btn btn-warning">Πίσω στην επισκευή</a>
</div><!-- /#page-wrapper -->
