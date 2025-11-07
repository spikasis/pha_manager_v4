<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2>Προσφορές προς Πελάτες<a  href="<?= base_url('admin/offers/create') ?>" class="btn btn-success" style="float: right">Προσθήκη Προσφοράς</a>
</h2>
            </div>
        </div><!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Λίστα Λογαριασμών
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ημερομηνία</th>
                                    <th>Ενδιαφερόμενος</th>
                                    <th>Ακουστικό Βαρηκοΐας</th>
                                    <th>Ποσότητα</th>
                                    <th>Τιμή Προσφοράς</th>
                                    <th>Συμμετοχή ΕΟΠΥΥ</th>
                                    <th>Τελική Προσφορά</th>
                                    <th>Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($offers)): ?>
                                    <?php foreach ($offers as $key => $list): 
                                    $this->load->model(array('admin/customer'));
                                    $customer_id = $this->customer->get($list['customer_id']);
                                    ?>
                                        <tr class="odd gradeX">
                                            <td><?=$list['id']?></td>
                                            <td><?=$list['offer_date']?></td>
                                            <td><?=$customer_id->name?></td>
                                            <td><?=$list['hearing_aid']?></td>
                                            <td><?=$list['quantity']?></td>
                                            <td><?=$list['price']?></td>
                                            <td><?=$list['eopyy']?></td>
                                            <td><?=$list['final_price']?></td>
                                            <td>                       
                                                <a href="<?= base_url('admin/offers/view/'.$list['id']) ?>" class="btn btn-info" target="_blank">Εκτύπωση</a> 
                                                <a href="<?= base_url('admin/offers/edit/'.$list['id']) ?>" class="btn btn-info">Επεξεργασία</a>  
                                                <a href="<?= base_url('admin/offers/delete/'.$list['id']) ?>" class="btn btn-danger">Διαγραφή</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="even gradeC">
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>
                                            <a href="#" class="btn btn-info">edit</a>  
                                            <a href="#" class="btn btn-danger">delete</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfooter>
                                <tr>
                                    <th>ID</th>
                                    <th>Ημερομηνία</th>
                                    <th>Ενδιαφερόμενος</th>
                                    <th>Ακουστικό Βαρηκοΐας</th>
                                    <th>Ποσότητα</th>
                                    <th>Τιμή Προσφοράς</th>
                                    <th>Συμμετοχή ΕΟΠΥΥ</th>
                                    <th>Τελική Προσφορά</th>
                                    <th>Ενέργειες</th>
                                </tr>
                            </tfooter>
                        </table>
                    </div>
                </div> <!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div>
</div><!-- /#page-wrapper -->