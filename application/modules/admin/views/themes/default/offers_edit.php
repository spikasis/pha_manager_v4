<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>
                Προσφορές
                <a  href="<?= base_url('admin/offers') ?>" class="btn btn-warning">Πίσω στη λίστα προσφορών</a>
            </h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Δημιουργία Νέας Προσφοράς
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" method="POST" action="<?=base_url('admin/offers/edit')?>">
                                <div class="form-group">
                                    <label>ID Προσφοράς</label>
                                    <input class="form-control" placeholder="Auto generated" disabled="1">
                                </div>
                                <div class="form-group">
                                    <label>Ημερομηνία</label>
                                    <input class="form-control" value="<?=$offers->offer_date?>" type="date" placeholder="Εισαγάγετε Ημερομηνία Προσφοράς" id="offer_date" name="offer_date">
                                </div>
                                <div class="form-group">
                                    <label>Ενδιαφερόμενος</label>
                                    <input class="form-control" value="<?=$offers->customer_id?>" placeholder="Εισαγάγετε Ενδιαφερόμενο" id="customer_id" name="customer_id">
                                </div>
                                <div class="form-group">
                                    <label>Ακουστικό Προσφοράς</label>
                                    <input class="form-control" value="<?=$offers->hearing_aid?>" placeholder="Εισάγετε Ακουστικό Βαρηκοΐας" id="hearing_aid" name="hearing_aid">
                                </div>
                                <div class="form-group">
                                    <label>Ποσότητα</label>
                                    <input class="form-control" value="<?=$offers->quantity?>" placeholder="Εισαγάγετε Ποσότητα" id="quantity" name="quantity">
                                </div>
                                <div class="form-group">
                                    <label>Κόστος Εφαρμογής Ακουστικών</label>
                                    <input class="form-control" value="<?=$offers->price?>" placeholder="Εισαγάγετε Κόστος Εφαρμογής Ακουστικών" id="price" name="price">
                                </div>
                                <div class="form-group">
                                    <label>Συμμετοχή Ασφαλιστικού Φορέα (ΕΟΠΥΥ)</label>
                                    <input class="form-control" value="<?=$offers->eopyy?>" placeholder="Εισαγάγετε Ποσό Συμμετοχής Ασφαλιστικού Φορέα" id="eopyy" name="eopyy">
                                </div>
                                <div class="form-group">
                                    <label>Τελικό Κόστος Εφαρμογής Ακουστικών</label>
                                    <input class="form-control" value="<?=$offers->final_price?>" placeholder="Εισαγάγετε Τελικό Κόστος Εφαρμογής Ακουστικών" id="final_price" name="final_price">
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
