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
                            <form role="form" method="POST" action="<?=base_url('admin/offers/create')?>">
                                <div class="form-group">
                                    <label>ID</label>
                                    <input class="form-control" placeholder="Auto generated" disabled="1">
                                </div>
                                <div class="form-group">
                                    <label>Ημερομηνία</label>
                                    <input class="form-control" type="date" placeholder="Εισαγάγετε Ημερομηνία Προσφοράς" id="offer_date" name="offer_date">
                                </div>
                                <div class="form-group">
                                    <label>Ενδιαφερόμενος</label>                                    
                                     <input list="customer_idS" name="customer_id" id="customer_id" class="form-control" placeholder="Επιλέξτε Ενδιαφερόμενο" >
                                      <datalist id="customer_idS">
                                       <?php if (count($customers)): ?>
                                            <?php foreach ($customers as $key => $customer): ?>
                                                <option value="<?= $customer['id'] ?>-<?= $customer['name'] ?> "></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                      </datalist>                                    
                                </div>
                                <div class="form-group">
                                    <label>Ακουστικό Βαρηκοΐας</label>
                                    <input class="form-control" placeholder="Ακουστικό" id="hearing_aid" name="hearing_aid">
                                </div>
                                <div class="form-group">
                                    <label>Ποσότητα</label>
                                    <input class="form-control" placeholder="Εισαγάγετε Ποσότητα" id="quantity" name="quantity">
                                </div>
                                <div class="form-group">
                                    <label>Κόστος Εφαρμογής Ακουστικού</label>
                                    <input class="form-control" placeholder="Εισαγάγετε Τιμή" id="price" name="price">
                                </div>
                                <div class="form-group">
                                    <label>Συμμετοχή Ασφαλιστικού Φορέα</label>
                                    <input class="form-control" placeholder="Εισαγάγετε Συμμετοχή ΕΟΠΥΥ" id="eopyy" name="eopyy">
                                </div>
                                <div class="form-group">
                                    <label>Τελικό Κόστος</label>                                    
                                    <input class="form-control" placeholder="Εισαγάγετε Τιμή" id="final_price" name="final_price">
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
