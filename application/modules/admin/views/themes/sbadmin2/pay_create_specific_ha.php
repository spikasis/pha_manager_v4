<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>
                Πληρωμή
            </h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                   Προσθήκη Πληρωμής <?php //echo json_encode($stock->model) ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">                            
                            <form role="form" method="POST" action="<?= base_url('admin/pays/create_specific_ha/' . $stock->id ) ?>">
                                <div class="form-group">
                                    <label>ID</label>
                                    <input class="form-control" placeholder="Auto generated" disabled="1">
                                <div class="form-group">
                                    <label>Πελάτης</label>
                                    <input class="form-control" id="customer" name="customer" placeholder="<?= $customers->name ?>" disabled="1"> 
                                    <option ></option>
                                </div>
                                <div class="form-group">
                                    <label>Ακουστικό</label>
                                    <input class="form-control" id="hearing_aid" name="hearing_aid" placeholder="<?= $stock->model ?>-<?= $stock->serial ?> " disabled="1"> 
                                    <option ></option>
                                    <!--
                                    <select class="form-control" id="hearing_aid" name="hearing_aid">
                                        <?php if (count($stock)): ?>
                                            <?php foreach ($stock as $key => $stocks): ?>
                                                <option value="<?= $stocks['id'] ?>" > <?= $stocks['serial'] ?> - <?= $stocks['model'] ?> - <?= $stocks['type'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select> 
                                    -->
                                </div>
                                    
                                </div>
                                <div class="form-group">
                                    <label>Ημερομηνία</label>
                                    <input class="form-control" type="date" placeholder="Εισαγάγετε Ημερομηνία" id="date" name="date">
                                </div>
                                <div class="form-group">
                                    <label>Ποσό Δόσης</label>
                                    <input class="form-control" placeholder="Εισαγάγετε Ποσό" id="pay" name="pay">
                                </div>
                                <button type="submit" class="btn btn-primary">Εισαγωγή</button>                                
                            </form>
                            <a href="<?= base_url('admin/stocks/view/' . $stock->id) ?>" class="btn btn-warning">Πίσω στην καρτέλα δόσεων</a>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
