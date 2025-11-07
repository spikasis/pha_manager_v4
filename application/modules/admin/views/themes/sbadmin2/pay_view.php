<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>Καρτέλα Πληρωμών Πελάτη</h2>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Ονοματεπώνυμο Πελάτη: <?= $customer->name ?></strong></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" method="POST" action="<?= base_url('admin/pays/edit/' . $pay->id) ?>">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>                                            
                                            <th>Ημερομηνία</th>
                                            <th>Ακουστικό</th>
                                            <th>Ποσό</th>
                                        </tr>
                                        <tr>                                            
                                            <td><?= $pay->id ?></td>                                            
                                            <td><?= $pay->date ?></td>
                                            <td><?= $pay->hearing_aid ?></td>
                                            <td><?= $pay->pay ?></td>
                                        </tr>                              
                                    </tbody> 
                                </table>
                            <a  href="<?= base_url('admin/pays') ?>" class="btn btn-warning">Πίσω</a>                        
                        </div>
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /#page-wrapper -->

