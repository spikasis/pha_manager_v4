<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header"><h2>Επισκευές Εργαστηρίου</h2></div>
            <div class="users-header"></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Λίστα Επισκευών
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-bordered table-hover table-responsive" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Πελάτης</th>
                                    <th>Ακουστικό</th>
                                    <th>Παραλαβή</th>
                                    <th>Ακουστικό Αντικατάστασης</th>
                                    <th>Ενέργειες</th>
                                    <th>Συμπτώματα</th>
                                    <th>Αναφορά Εργαστηρίου</th>                                    
                                    <th>Εργαστήριο Επισκευής</th>
                                    <th>Τιμή</th>
                                    <th>Κατάσταση</th>
                                    <th>Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                <?php
                                if (count($service)):
                                    foreach ($service as $key => $list):
                                        $this->load->model(array('admin/customer'));
                                        $this->load->model(array('admin/stock'));
                                        $this->load->model(array('admin/vendor'));
                                        $this->load->model(array('admin/service_status'));
                                        $this->load->model(array('admin/service_category'));
                                        $this->load->model(array('admin/service_subcategory'));
                                        $this->load->model(array('admin/service_condition'));
                                        $this->load->model(array('admin/manufacturer'));

                                        if (isset($list['ha_service'])) {                                            
                                            $hearing_aid = $this->stock->get($list['ha_service']);
                                        }
                                        $cust = $this->customer->get($hearing_aid->customer_id);
                                        if (isset($list['lab_sent'])) {
                                            $lab = $this->vendor->get($list['lab_sent']);
                                        }
                                        $ha_temp = $this->stock->get($list['ha_temp']);                                        
                                        $service_cat = $this->service_subcategory->get($list['lab_service']);
                                        $action = $this->service_status->get($list['action_service']);
                                        $brand = $this->manufacturer->get($hearing_aid->manufacturer);
                                        $ser_condition = $this->service_condition->get($list['status']);    
                                        
                                        if($list['selling_point'] == 1): $sp ='bg-info ';
                                        elseif ($list['selling_point'] == 2):  $sp ='bg-warning ';
                                        else: echo ' ';
                                        endif;
                                        ?>
                                        <?php
                                        // Υπολογισμός διαφοράς ημερών
                                        
                                        $order_date = strtotime($list['day_in']);
                                        $current_date = strtotime(date('Y-m-d'));
                                        $datediff = ($current_date - $order_date) / (60 * 60 * 24);
                                        
                                        // Ορισμός χρώματος για τη γραμμή αν έχουν περάσει πάνω από 7 μέρες
                                        $row_class = ($datediff > 7) ? 'bg-danger' : '';
                                        ?>
                                <tr class="<?= $row_class ?>">
                                    <td><?= $list['id'] ?></td>
                                            <td><?= $cust->name  ?></td>
                                            <td><?= $hearing_aid->serial ?> - <?= $brand->name ?> <?= $hearing_aid->model ?></td>
                                            <td><?= $list['day_in'] ?></td>                                            
                                            <td><?= $ha_temp->serial ?> - <?= $ha_temp->model ?></td>
                                            <td><?= $action->status ?></td>
                                            <td><?= $list['malfunction'] ?></td>
                                            <td><?= $list['lab_report'] ?></td>                                            
                                            <td><?= $lab->name ?></td>
                                            <td>€ <?= $list['price'] ?></td>
                                            <td><?= $ser_condition->status ?></td>                                            
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Ενέργειες
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
                                                        <li><a class="dropdown-item btn btn-info" href="<?= base_url('admin/services/service_doc/' . $list['id']) ?>" target="_blank">Δελτίο</a></li>
                                                        <li><a class="dropdown-item btn btn-info" href="<?= base_url('admin/services/edit/' . $list['id']) ?>">Επεξεργασία</a></li>                                                        
                                                        <div class="dropdown-divider"></div>
                                                        <li> <a class="dropdown-item btn btn-danger" href="<?= base_url('admin/services/delete/' . $list['id']) ?>">Delete</a></li>
                                                    </div>
                                                </div>                                           
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
                        </table>
                        <a  href="<?= base_url('admin/services/create') ?>" class="btn btn-info hidden-print" style="float: left">Προσθήκη Νέου</a>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
<!-- /#page-wrapper -->
