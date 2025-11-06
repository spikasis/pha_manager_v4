<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>
                Κατάστημα
                <a  href="<?= base_url('admin/selling_points') ?>" class="btn btn-warning">Πίσω στη λίστα Καταστημάτων</a>
            </h2>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Εισαγωγή Στοιχείων Καταστήματος
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php if ($this->session->flashdata('message')): ?>
                        <div class="col-lg-12 col-md-12">
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?=$this->session->flashdata('message')?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-lg-6">
                            <form role="form" method="POST" action="<?=base_url('admin/selling_points/create')?>">
                                <div class="form-group">
                                    <label>Id Input</label>
                                    <input class="form-control" placeholder="Auto generated" disabled="1">
                                </div>
                                <div class="form-group">
                                    <label>Επωνυμία</label>
                                    <input class="form-control" placeholder="Enter company name" id="city" name="city">
                                </div>
                                <div class="form-group">
                                    <label>Διεύθυνση</label>
                                    <input class="form-control" placeholder="Enter company country" id="address" name="address">
                                </div>
                                <div class="form-group">
                                    <label>Τηλέφωνο</label>
                                    <input class="form-control" placeholder="Enter company ce mark" id="phone" name="phone">
                                </div>
                                <div class="form-group">
                                    <label>e-mail</label>
                                    <input class="form-control" placeholder="Enter company url" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <label>Διαχειριστής</label>
                                    <select class="form-control" id="administrator" name="administrator">
                                        <?php if (count($users)): ?>
                                            <?php foreach ($users as $key => $user): ?>
                                                <option value="<?= $user['id'] ?>"><?= $user['last_name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                    
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </form>
                        </div>
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /#page-wrapper -->
