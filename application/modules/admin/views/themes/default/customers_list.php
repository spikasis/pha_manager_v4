<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2>
                    <?php echo $title ?>
                    <a  href="<?= base_url('admin/customers/create') ?>" class="btn btn-success  hidden-print" style="float: right">Νέος Πελάτης</a>
                </h2>
            </div>
            <?php //echo $this->db->last_query(); //echo json_encode($customers); ?>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Λίστα Πελατών
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Όνοματεπώνυμο</th>
                                    <th>Διεύθυνση</th>
                                    <th>Πόλη</th>
                                    <th>Τηλέφωνο</th> 
                                    <th>Κινητό</th>
                                    <th>Ημ/νια Επίσκεψης</th>                                    
                                    <th>Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($customers)): ?>
                                    <?php foreach ($customers as $key => $list): ?>
                                        <tr class="odd gradeX">
                                            <td style="width: 50px"><?=$list['name']?></td>
                                            <td><?=$list['address']?></td>
                                            <td><?=$list['city']?></td>                                            
                                            <td><?=$list['phone_home']?></td>  
                                            <td><?=$list['phone_mobile']?></td>
                                            <td><?=$list['first_visit']?></td>
                                            <td style="width: 300px">
                                                <div class="dropdown">
                                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Ενέργειες
                                                    <span class="caret"></span>  <!-- Προσθήκη του caret για Bootstrap 3 -->
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li><a href="<?= base_url('admin/customers/view/'.$list['id']) ?>" class="btn btn-info hidden-print">Καρτέλα</a></li>
                                                    <li><a href="<?= base_url('admin/customers/edit/'.$list['id']) ?>" class="btn btn-warning hidden-print">Edit</a></li>
                                                    <li><a href="<?= base_url('admin/customers/delete/'.$list['id']) ?>" class="btn btn-danger hidden-print">Delete</a></li>
                                                </ul>
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
                                        <td>No data</td><!-- <td>No data</td> -->
                                        <td>No data</td>
                                        <td>
                                            <a href="#" class="btn btn-info">edit</a>  
                                            <a href="#" class="btn btn-danger">delete</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div>
</div><!-- /#page-wrapper -->