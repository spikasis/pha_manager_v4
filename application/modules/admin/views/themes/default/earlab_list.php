<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header"><h2>Κατασκευές Εργαστηρίου</h2></div>
            <div class="users-header"><a href="<?= base_url('admin/earlabs/create') ?>" class="btn btn-success">Προσθήκη Νέου</a></div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Λίστα Κατασκευών
                </div>
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>                                        
                                    <th>Vendor</th>
                                    <th>Customer</th>
                                    <th>Type</th>
                                    <th>Vent</th>
                                    <th>Ημ/νια Μέτρα</th>
                                    <th>Παραλαβή</th>
                                    <th>Παράδοση</th>                                    
                                    <th>Σχόλια</th>
                                    <th>Κατάστημα</th>
                                    <th>Κατάσταση</th>
                                    <th>Κόστος</th>
                                    <th>Πλευρά</th>
                                    <th>Επανακατασκευή</th>
                                    <th>Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($earlabs)): ?>
                                    <?php foreach ($earlabs as $earlab): ?>
                                        <?php
                                        $sp = '';
                                        if($earlab->selling_point == 'Λιβαδειά') {
                                            $sp = 'bg-info';
                                        } elseif ($earlab->selling_point == 'Θήβα') {
                                            $sp = 'bg-warning';
                                        }
                                        ?>
                                        <tr class="<?php echo $sp ?>">
                                            <td><?= $earlab->id; ?></td>
                                            <td><?= $earlab['vendor_name']; ?></td>
                                            <td><?= $earlab['customer_name']; ?></td>
                                            <td><?= $earlab['type']; ?></td>
                                            <td><?= $earlab['vent']; ?></td>
                                            <td><?= $earlab['date_order']; ?></td>
                                            <td><?= $earlab['date_delivery']; ?></td>
                                            <td><?= $earlab['date_fit']; ?></td>
                                            <td><?= $earlab['comments']; ?></td>
                                            <td><?= $earlab['selling_point']; ?></td>
                                            <td><?= $earlab['status']; ?></td>
                                            <td><?= $earlab['cost']; ?></td>
                                            <td><?= $earlab['side']; ?></td>
                                            <td><?= $earlab['remake']; ?></td>
                                            <td style="width: 100px">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Ενέργειες
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a href="<?= base_url('admin/earlabs/earlab_doc/' . $earlab->id) ?>" class="btn btn-info">Δελτίο</a>  
                                                        <a href="<?= base_url('admin/earlabs/edit/' . $earlab->id) ?>" class="btn btn-info">Επεξεργασία</a>  
                                                        <a href="<?= base_url('admin/earlabs/delete/' . $earlab->id) ?>" class="btn btn-danger">Διαγραφή</a>
                                                    </div>
                                                </div>
                                            </td>                                            
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="14" class="text-center">Δεν υπάρχουν διαθέσιμα δεδομένα.</td>
                                    </tr>
                                <?php endif; ?> 
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
