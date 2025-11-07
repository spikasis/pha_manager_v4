<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2>
                   Επιχείρηση
                   <a  href="<?= base_url('admin/companies/create') ?>" class="btn btn-success" style="float: right">Προσθήκη</a>
                </h2>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Companies listing
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Επωνυμία</th>
                                    <th>Διεύθυνση</th>
                                    <th>Τηλέφωνο</th>
                                    <th>Διαχειριστής</th>
                                    <th>Actions</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($companies)): ?>
                                    <?php foreach ($companies as $key => $list): ?>
                                    <?php    $admin = $this->user->get($list['administrator']); ?>
                                        <tr class="odd gradeX">
                                            <td><?=$list['id']?></td>
                                            <td><?=$list['company_name']?></td>
                                            <td><?=$list['address']?></td>
                                            <td><?=$list['phone']?></td>
                                            <td><?=$admin->last_name?></td>
                                            <td>
                                                <a href="<?= base_url('admin/companies/docs/'. $list['id']) ?>" class="btn btn-info">ΕΚΑΠΤΥ</a>  
                                                <a href="<?= base_url('admin/companies/edit/'. $list['id']) ?>" class="btn btn-info">edit</a>  
                                                <a href="<?= base_url('admin/companies/delete/'. $list['id']) ?>" class="btn btn-danger">delete</a>
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