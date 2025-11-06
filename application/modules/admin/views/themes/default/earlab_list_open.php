<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header"><h2>Κατασκευές Εργαστηρίου</h2></div>
            <div class="users-header"><a  href="<?= base_url('admin/earlabs/create') ?>" class="btn btn-success">Προσθήκη Νέου</a></div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>Κατασκευές σε εκκρεμότητα</h2> 
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Πελάτης</th>
                        <th>Πωλητής</th>
                        <th>Σημείο Πώλησης</th>
                        <th>Ημερομηνία Παραγγελίας</th>
                        <th>Σχόλια</th>
                        <th>Ενέργειες</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($earlabs)): ?>
                        <?php foreach ($earlabs as $entry): ?>
                    
                    <?php
                        // Υπολογισμός διαφοράς ημερών
                        $order_date = strtotime($entry['date_order']);
                        $current_date = strtotime(date('Y-m-d'));
                        $datediff = ($current_date - $order_date) / (60 * 60 * 24);
                        
                        // Ορισμός χρώματος για τη γραμμή αν έχουν περάσει πάνω από 7 μέρες
                        $row_class = ($datediff > 7) ? 'bg-danger' : '';
                        ?>
                            <tr class="<?= $row_class ?>">
                                <td><?= $entry['id'] ?></td>
                                <td><?= $entry['customer_name'] ?></td>
                                <td><?= $entry['vendor_name'] ?></td>
                                <td><?= $entry['selling_point'] ?></td>
                                <td><?= $entry['date_order'] ?></td>
                                <td><?= $entry['comments'] ?></td>
                                <td><button><a href="<?= base_url('admin/earlabs/edit/' . $entry['id']) ?>" class="btn btn-info">Επεξεργασία</a></button></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Δεν βρέθηκαν δεδομένα</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
        </div>
    </div>
</div><!-- /#page-wrapper -->
