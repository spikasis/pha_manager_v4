<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>Πληρωμή</h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Επεξεργασία Πληρωμής</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" method="POST" action="<?= base_url('admin/eopyy_pays/edit/' . $eopyy_pay->id) ?>">
                                <div class="form-group">
                                    <label>ID</label>
                                    <input class="form-control" value="<?= $eopyy_pay->id ?>" placeholder="Auto generated" disabled="1">
                                </div>
                                <div class="form-group">
                                    <label>Ημερομηνία</label>
                                    <input class="form-control" type="date" value="<?= $eopyy_pay->date ?>" placeholder="Εισαγάγετε Ημερομηνία" id="date" name="date">
                                </div>
                                <div class="form-group">
                                    <label>Ποσό</label>
                                    <input class="form-control" value="<?= $eopyy_pay->price ?>" placeholder="Εισαγάγετε Ποσό" id="price" name="price">
                                </div>                                
                                <div class="form-group">
                                    <label>Σημειώσεις</label>
                                    <input class="form-control" value="<?= $eopyy_pay->comments ?>" placeholder="Εισαγάγετε Σημειώσεις" id="comments" name="comments">
                                </div>                                
                                <button type="submit" class="btn btn-primary">Εισαγωγή</button>
                            </form>                            
                            <a  href="<?= base_url('admin/eopyy_pays') ?>" class="btn btn-warning">Πίσω στη λίστα πληρωμών</a>
                        </div>
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /#page-wrapper -->
