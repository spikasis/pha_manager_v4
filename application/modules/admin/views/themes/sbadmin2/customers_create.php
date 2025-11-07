<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>Προσθήκη νέου πελάτη</h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default panel-green">
                <div class="panel-heading">
                    Δημιουργία Νέου Πελάτη
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form" method="POST" action="<?=base_url('admin/customers/create')?>">
                                <fieldset>
                                    <legend>Στοιχεία Ασθενούς:</legend>
                                    <div class="form-group col-lg-12">
                                        <div class="col-lg-2">
                                             <label>Customer ID</label>
                                        <input class="form-control" placeholder="Auto generated" disabled="1">
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <label>Ονοματεπώνυμο</label>
                                            <input class="form-control" placeholder="Εισαγάγετε Ονοματεπώνυμο Πελάτη" id="name" name="name">
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <label>Ημ/νια Γέννησης</label>
                                            <input class="form-control" type="date" placeholder="Εισαγάγετε Ημερομηνία Γέννησης" id="birthday" name="birthday">
                                        </div>
                                        
                                        <div class="col-lg-2">
                                            <label>ΑΜΚΑ</label>
                                            <input class="form-control" placeholder="ΑΜΚΑ" id="amka" name="amka">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <div class="form-group">
                                            <div class="form-group col-lg-4">
                                                <label>Σταθερό Τηλέφωνο</label>
                                                <input class="form-control" placeholder="Σταθερό Τηλέφωνο" id="phone_home" name="phone_home">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>Κινητό Τηλέφωνο</label>
                                                <input class="form-control" placeholder="Εισαγάγετε Κινητό Τηλέφωνο" id="phone_mobile" name="phone_mobile">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>Διεύθυνση Κατοικίας</label>
                                                <input class="form-control" placeholder="Εισαγάγετε Διεύθυνση Κατοικίας" id="address" name="address">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>Πόλη</label>
                                                <input class="form-control" placeholder="Εισαγάγετε Πόλη" id="city" name="city">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>Ασφαλιστικός Φορέας</label>
                                                <select class="form-control" id="insurance" name="insurance">
                                        <?php if (count($insurances)): ?>
                                            <?php foreach ($insurances as $key => $insurance): ?>
                                                    <option value="<?= $insurance['id'] ?>"><?= $insurance['name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                                </select>                                    
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>Παλιός Χρήστης</label>
                                                <input class="form-control" placeholder="Παλιός Χρήστης" id="old_user" name="old_user">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>Επάγγελμα</label>
                                                <input class="form-control" placeholder="Εισαγάγετε Επάγγελμα Πελάτη" id="profession" name="profession">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>Σημείο Πώλησης</label>
                                                <select class="form-control" id="selling_point" name="selling_point">
                                        <?php if (count($selling_points)): ?>
                                            <?php foreach ($selling_points as $key => $selling_point): ?>
                                                    <option value="<?= $selling_point['id'] ?>"><?= $selling_point['city'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>Ιατρός</label>
                                                <select class="form-control" id="doctor" name="doctor">
                                        <?php if (count($doctors)): ?>
                                            <?php foreach ($doctors as $key => $doctor): ?>
                                                    <option value="<?= $doctor['id'] ?>"><?= $doctor['doc_name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                                </select>                                    
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>Πρώτη Επίσκεψη</label>
                                                <input class="form-control" type="date" placeholder="Εισαγάγετε Πρώτη Επίσκεψη Πελάτη" id="first_visit" name="first_visit">
                                            </div>                                            
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Επιλέξτε κατασταση πελατη:</legend>
                                    <div class="form-group" >
                                        <div class="form-group col-lg-4">
                                            <label for="scales">Εκκρεμοτητα (παραγγελία - προς παράδοση)</label>
                                            <input type="checkbox" id="pending" name="pending" value="pending" checked />                                            
                                        </div> 
                                        <div class="form-group col-lg-4">
                                            <label>Κατάσταση</label>
                                            <select class="form-control" id="status" name="status">
                                        <?php if (count($customer_status)): ?>
                                            <?php foreach ($customer_status as $key => $status): ?>
                                                <option value="<?= $status['id'] ?>"><?= $status['status'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                            </select>
                                        </div>                                        
                                        <div class="form-group col-lg-4">
                                            <label>Κωδικός Πελάτη</label>
                                            <input class="form-control" placeholder="Εισαγάγετε Κωδικό Πελάτη" id="customer_id" name="customer_id">
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-group">
                                    <label>Σχόλια</label>
                                    <textarea class="form-control" placeholder="Εισαγάγετε Σχόλια" id="comments" name="comments"></textarea>
                                </div> 
                                <button type="submit" class="btn btn-primary">Υποβολή</button>
                                <button type="reset" class="btn btn-default">Επαναφορά</button>
                            </form>                            
                        </div>                        
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->                
            </div><!-- /.panel -->
            <a  href="<?= base_url('admin/customers') ?>" class="btn btn-warning">Πίσω στη λίστα πελατών</a>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /#page-wrapper -->
