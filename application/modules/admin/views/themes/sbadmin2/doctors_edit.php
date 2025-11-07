<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>
                Ιατροί
                <a  href="<?= base_url('admin/doctors') ?>" class="btn btn-warning">Πίσω στη λίστα ιατρών</a>
            </h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Δημιουργία Νέου Ιατρού
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" method="POST" action="<?=base_url('admin/doctors/edit')?>">
                                <div class="form-group">
                                    <label>Doctors ID</label>
                                    <input class="form-control" placeholder="Auto generated" disabled="1">
                                </div>
                                <div class="form-group">
                                    <label>Ονοματεπώνυμο</label>
                                    <input class="form-control" value="<?=$doctors->doc_name?>" placeholder="Εισαγάγετε Ονοματεπώνυμο Ιατρού" id="doc_name" name="doc_name">
                                </div>
                                <div class="form-group">
                                    <label>Διεύθυνση</label>
                                    <input class="form-control" value="<?=$doctors->doc_address?>" placeholder="Εισαγάγετε Διεύθυνση" id="doc_address" name="doc_address">
                                </div>
                                <div class="form-group">
                                    <label>Πόλη</label>
                                    <input class="form-control" value="<?=$doctors->doc_city?>" placeholder="Πόλη" id="doc_city" name="doc_city">
                                </div>
                                <div class="form-group">
                                    <label>Κινητό Τηλέφωνο</label>
                                    <input class="form-control" value="<?=$doctors->doc_phone_mobile?>" placeholder="Εισαγάγετε Κινητό Τηλέφωνο" id="doc_phone_mobile" name="doc_phone_mobile">
                                </div>
                                <div class="form-group">
                                    <label>Σταθερό Τηλέφωνο</label>
                                    <input class="form-control" value="<?=$doctors->doc_phone_work?>" placeholder="Εισαγάγετε Τηλέφωνο Σταθερό" id="doc_phone_work" name="doc_phone_work">
                                </div>
                                <div class="form-group">
                                    <label>Τιμή</label>
                                    <input class="form-control" value="<?=$doctors->doc_price?>" placeholder="Εισαγάγετε Τιμή" id="doc_price" name="doc_price">
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
