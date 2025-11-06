<div id="page-wrapper">
    <div class="row" style="width: 100%; overflow: hidden;">
        <div class='col-lg-8' style="width: 300px; float: left;"><img src="<?= base_url('images/logo_pha.png') ?>" style="height: 100px"/></div>        
        <div class="col-lg-4" style="margin-left: 450px"><h3><?php //echo $customer->id ?></h3></div>
    </div><!-- /.row -->
    <div class="row"><h1><?php echo $customer->name ?>   <a href="<?= base_url('admin/customers/view/' . $customer->id) ?>" class="btn btn-info hidden-print">Προβολή</a></h1></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Προβολή Ακουστικών</strong></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table table-striped table-bordered table-hover" >
                                <tbody>
                                        <tr>
                                            <td colspan="4">Serial No: <?php echo $stock->serial ?></td>
                                            <td><a href="<?= base_url('admin/stocks/edit/' . $stock->id) ?>" class="btn btn-info hidden-print">Επεξεργασία</a></td>
                                        </tr>
                                        <tr>                                            
                                            <td>Κατασκευαστικός Οίκος</td>
                                            <td>Μοντέλο</td>
                                            <td>Τύπος</td>
                                            <td>Ημ/νια Πώλησης</td>
                                            <td>Λήξη Εγγύησης</td>
                                        </tr>
                                        <tr>                                            
                                            <td><?php //echo $man->name ?></td>
                                            <td><?php echo $stock->model ?></td>
                                            <td><?php echo $stock->type ?></td>
                                            <td><?php echo $stock->day_out ?></td>
                                            <td><?php echo $stock->guarantee_end ?></td>
                                        </tr>
                                        <tr>
                                            <td>Σχόλια: </td><td colspan="5"><?php echo $stock->comments ?></td>
                                        </tr>
                                    </tbody> 
                            </table>
                        </div>
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->                        
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Προβολή Δόσεων   </strong></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table table-striped table-bordered table-hover" >                                
                                <?php foreach ($pay as $key => $list): ?>                                    
                                    <tbody>                                       
                                       <tr>                                            
                                            <td><?php echo $list['date'] ?></td>
                                            <td>€ <?php echo $list['pay'] ?></td>
                                            <td><a href="<?= base_url('admin/pays/edit/' . $list['id']) ?>" class="btn btn-info hidden-print">Επεξεργασία</a>
                                            <a href="<?= base_url('admin/pays/delete/' . $list['id']) ?>" class="btn btn-danger hidden-print">Διαγραφή</a></td>
                                        </tr>                                        
                                    </tbody>                                      
                                <?php endforeach; ?>   
                            </table>
                        </div>
                    </div><!-- /.row (nested) -->                    
                </div><!-- /.panel-body -->               
                <div class="panel-footer">
                    <table>
                        <tbody>
                            <tr>
                                <td><strong>Υπόλοιπο Πελάτη: € <?php echo $balance[0]['balance'] ?> </strong></td>
                                <td><a style="float: right; align-self: center" href="<?= base_url('admin/pays/create_specific_ha/' . $stock->id) ?>" class="btn btn-success hidden-print">Προσθήκη Πληρωμής</a></td>
                            </tr>
                        </tbody> 
                    </table>               
                </div>
             </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->

    <div class="no-print"><a  href="<?= base_url('admin/customers') ?>" class="btn btn-warning hidden-print">Πίσω στη λίστα πελατών</a></div>
</div>
<!-- /#page-wrapper -->
