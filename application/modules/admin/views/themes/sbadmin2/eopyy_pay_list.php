<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2 style="float: left">Πληρωμές ΕΟΠΥΥ</h2>
                <a style="float: right; align-self: center;"  href="<?= base_url('admin/eopyy_pays/create') ?>" class="btn btn-success">Προσθήκη Νέας Πληρωμής</a>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Λίστα Πληρωμών</div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Ποσο</th>
                                    <th>Ημερομηνία</th> 
                                    <th>Σημειώσεις</th>
                                    <th>Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($eopyy_pay)): ?>
                                    <?php foreach ($eopyy_pay as $key => $list): ?>
                                        <tr class="odd gradeX">
                                            <td><?= $list['id'] ?></td>
                                            <td><?= $list['price'] ?></td>
                                            <td><?= $list['date'] ?></td>
                                            <td><?= $list['comments'] ?></td>
                                            <td style="width: 270px">
                                                <a href="<?= base_url('admin/eopyy_pays/edit/' . $list['id']) ?>" class="btn btn-info">edit</a>  
                                                <a href="<?= base_url('admin/eopyy_pays/delete/' . $list['id']) ?>" class="btn btn-danger">delete</a>
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
                    </div>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div>
</div><!-- /#page-wrapper -->
