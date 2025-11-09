<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users text-primary"></i> <?= $title ?>
        </h1>
        <a href="<?= base_url('admin/customers/create') ?>" class="btn btn-success shadow-sm hidden-print">
            <i class="fas fa-user-plus fa-sm text-white-50"></i> Νέος Πελάτης
        </a>
    </div>

    <!-- DataTables Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table"></i> Λίστα Πελατών
            </h6>
        </div>
        <div class="card-body">
                    <div class="table-responsive">
                <table class="table table-bordered table-hover" id="customersTable" width="100%" cellspacing="0">
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
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('admin/customers/view/'.$list['id']) ?>" 
                                                       class="btn btn-sm btn-info" title="Καρτέλα">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/customers/edit/'.$list['id']) ?>" 
                                                       class="btn btn-sm btn-warning" title="Επεξεργασία">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/customers/delete/'.$list['id']) ?>" 
                                                       class="btn btn-sm btn-danger" title="Διαγραφή"
                                                       onclick="return confirm('Είστε σίγουροι για τη διαγραφή;')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                                
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                            Δεν βρέθηκαν πελάτες
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
            </div>
        </div>
    </div>

</div>
<!-- End Page Content -->


</div><!-- /#page-wrapper -->