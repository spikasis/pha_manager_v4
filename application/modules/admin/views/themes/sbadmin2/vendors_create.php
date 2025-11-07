<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>
                Προμηθευτές
                <a  href="<?= base_url('admin/vendors') ?>" class="btn btn-warning">Πίσω στη λίστα Προμηθευτών</a>
            </h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Δημιουργία Νέου Προμηθευτή
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" method="POST" action="<?=base_url('admin/vendors/create')?>">
                                <div class="form-group">
                                    <label>Vendors ID</label>
                                    <input class="form-control" placeholder="Auto generated" disabled="1">
                                </div>
                                <div class="form-group">
                                    <label>Ονοματεπώνυμο</label>
                                    <input class="form-control" placeholder="Εισαγάγετε Ονοματεπώνυμο Ιατρού" id="name" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Διεύθυνση</label>
                                    <input class="form-control" placeholder="Εισαγάγετε Διεύθυνση" id="address" name="address">
                                </div>
                                <div class="form-group">
                                    <label>Πόλη</label>
                                    <input class="form-control" placeholder="Πόλη" id="city" name="city">
                                </div>
                                <div class="form-group">
                                    <label>Σταθερό Τηλέφωνο</label>
                                    <input class="form-control" placeholder="Εισαγάγετε Τηλέφωνο Σταθερό" id="phone" name="phone">
                                </div>
                                <div class="form-group">
                                    <label>Τιμή</label>
                                    <input class="form-control" placeholder="Εισαγάγετε ΑΦΜ" id="vat" name="vat">
                                </div>
    
                                <button type="submit" class="btn btn-primary">Υποβολή</button>
                                <button type="reset" class="btn btn-default">Επαναφορά</button>
                            </form>
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
