<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header"><h2>Δελτία Αποστολής</h2></div>
            <div class="users-header"></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Λίστα ΔΑΠ
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Απο</th>
                                    <th>Προς</th>
                                    <th>Ημερομηνία</th>                                    
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
                                        
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?= $list['id'] ?></td>
                                            <td><?= $list['from']   ?></td>
                                            <td><?= $list['to_customer']  ?> - <?= $vendor->name ?></td>
                                            <td><?= $list['date']  ?></td>             
                                            <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Ενέργειες
                                                </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">                                                
                                              <a href="<?= base_url('admin/invoices_dap/invoice_doc/' . $list['id']) ?>" class="btn btn-info" target="_blank">Δελτίο</a>
                                              <a href="<?= base_url('admin/invoices_dap/edit/' . $list['id']) ?>" class="btn btn-info">edit</a>  
                                              <a href="<?= base_url('admin/invoices_dap/delete/' . $list['id']) ?>" class="btn btn-danger">delete</a>
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
