<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2>Τραπεζικοί Λογαριασμοί<a  href="<?= base_url('admin/banks/create') ?>" class="btn btn-success" style="float: right">Προσθήκη Τραπεζικού Λογαριασμού</a>
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
                                    <th>Name</th>
                                    <th>IBAN</th>
                                    <th>Type</th>
                                    <th>Owner</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($banks)): ?>
                                    <?php foreach ($banks as $key => $list): ?>
                                        <tr class="odd gradeX">
                                            <td><?=$list['id']?></td>
                                            <td><?=$list['name']?></td>
                                            <td><?=$list['iban']?></td>
                                            <td><?=$list['type']?></td>
                                            <td><?=$list['owner']?></td>
                                            <td>                                                  
                                                <a href="<?= base_url('admin/banks/edit/'.$list['id']) ?>" class="btn btn-info">edit</a>  
                                                <a href="<?= base_url('admin/banks/delete/'.$list['id']) ?>" class="btn btn-danger">delete</a>
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
                                    <th>Name</th>
                                    <th>IBAN</th>
                                    <th>Type</th>
                                    <th>Owner</th>
                                    <th>Action</th>
                                </tr>
                            </tfooter>
                        </table>
                    </div>
                </div> <!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div>
</div><!-- /#page-wrapper -->