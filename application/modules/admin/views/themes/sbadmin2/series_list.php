<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2>
                    <?php echo $title ?>
                    <a  href="<?= base_url('admin/series/create') ?>" class="btn btn-success" style="float: right">Προσθήκη Νέας Σειράς</a>
                </h2>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Λίστα Σειρών Ακουστικών</div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Κατασκευαστής</th>
                                    <th>Σειρά(Οικογένεια)</th>
                                    <th>Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody>                               
                                <?php if (count($series)): ?>
                                    <?php foreach ($series as $key => $list): ?>
                                    <?php $brand = $this->manufacturer->get($list['brand']); ?>
                                        <tr class="odd gradeX">
                                            <td><?=$list['id']?></td>
                                            <td><?=$brand->name?></td>
                                            <td><?=$list['series']?></td>                                            
                                            <td>                                                
                                                <a href="<?= base_url('admin/series/edit/'.$list['id']) ?>" class="btn btn-info hidden-print">Επεξεργασία</a> 
                                                <a href="<?= base_url('admin/series/delete/'.$list['id']) ?>" class="btn btn-danger hidden-print">Διαγραφή</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <tr class="even gradeC">
                                    <td>No data</td>
                                    <td>No data</td>
                                    <td>No data</td>                                    
                                    <td>
                                        <a href="#" class="btn btn-info">Επεξεργασία</a>  
                                        <a href="#" class="btn btn-danger">Διαγραφή</a>
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
