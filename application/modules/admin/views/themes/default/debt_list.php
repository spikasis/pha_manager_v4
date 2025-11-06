<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2>Οφειλές</h2>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">Λίστα Oφειλών</div><!-- /.panel-heading --><div><?php echo $sum_of_debt ?></div>
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>                                    
                                    <th>Πελάτης</th>
                                    <th>Ακουστικό</th> 
                                    <th>Οφειλή</th>
                                    <th>Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php                                
                                if (count($debts)):
                                    foreach ($debts as $key => $list):
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?= $list['customer_name'] ?></td>
                                            <td><?= $list['manufacturer'] ?>  <?= $list['ha_series'] ?>-<?= $list['ha_model'] ?></td>                                            
                                            <td><?= $list['debt'] ?></td>                                            
                                            <td style="width: 270px">
                                                <a href="<?= base_url('admin/stocks/view/' . $list['stock_id']) ?>" class="btn btn-info">Προβολη Καρτέλας</a>
                                            </td>
                                        </tr>
                                        <?php $sum_of_debt += $list['debt']; ?>
                                    <?php endforeach; ?>                                
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div><div class="panel-heading">Σύνολο Οφειλών <?php echo $sp->city ?> - €<?php echo $sum_of_debt ?></div>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->        
    </div><!-- /#page-wrapper --

   