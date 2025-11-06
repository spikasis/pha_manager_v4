<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2>
                    <?php echo $title ?>
                    <a  href="<?= base_url('admin/models/create') ?>" class="btn btn-success" style="float: right">Προσθήκη Νέου Μοντέλου</a>
                </h2>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Λίστα Μοντέλων Ακουστικών</div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Κατασκευαστής</th>
                                    <th>Μοντέλο</th>
                                    <th>Τύπος</th>
                                    <th>Μπαταρία</th>                                    
                                    <th>Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody>                               
                                <?php if (count($models)): ?>
                                    <?php foreach ($models as $key => $list): ?>
                                    <?php 
                                    
                                    $series = $this->serie->get($list['series']);
                                    $brand = $this->manufacturer->get($series->brand);
                                    $ha_type = $this->ha_type->get($list['ha_type']);
                                    $battery = $this->battery_type->get($list['battery']);
                                    ?>
                                        <tr class="odd gradeX">
                                            <td><?=$list['id']?></td>
                                            <td><?=$brand->name?> - <?=$series->series?></td>
                                            <td><?=$list['model']?></td>
                                            <td><?=$ha_type->type?></td>
                                            <td><?=$battery->type?></td> 
                                            <td>                                                
                                                <a href="<?= base_url('admin/models/edit/'.$list['id']) ?>" class="btn btn-info hidden-print">Επεξεργασία</a> 
                                                <a href="<?= base_url('admin/models/delete/'.$list['id']) ?>" class="btn btn-danger hidden-print">Διαγραφή</a>
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
                        </table>
                    </div>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div>
</div><!-- /#page-wrapper -->
