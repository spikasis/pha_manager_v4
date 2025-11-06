
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Γενικά Στοιχεία</h1>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
        <div class="row">
        <!--flash data message start -->
            <?php if ($this->session->flashdata('message')): ?>
            <div class="col-lg-12 col-md-12">
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $this->session->flashdata('message') ?>
                </div>
            </div>
        <?php endif; ?>
        <!--endof flashdata message -->    
        <?php //echo json_encode($year_financial_stats ) ?>
        <!--yearly financial data (pure no's) -->   
        <?php foreach ($year_financial_stats as $key => $list ): ?>
        <div class="col-lg-3 col-md-6">
            <div class="
                 <?php if($list['s_p'] == 1):
                     echo 'panel panel-primary';
                 else:
                     echo 'panel panel-yellow';
                 endif;
                 ?>
                 
                 
                 ">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Στατιστικά Έτους <?php echo $list['year']?> - <?php echo $list['s_p']?>
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-check-square fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo json_encode($list['pcs']) ?></div>
                            <div class="huge"><?php echo json_encode($list['sum_price']) ?></div>
                            <div class="huge"><?php echo json_encode($list['sum_price']) ?></div>
                            <div class="huge"><?php echo json_encode($list['sum_price']) ?></div>
                            <div><?php //echo $list['title'] ?></div>
                        </div>
                    </div>
                </div>                
            </div>
        </div><?php endforeach ?> 
        </div>
            
        <!--endof yearly financial data (pure no's) -->

        <!--start of graphs ---------------->    



<!--endof graphs section------------------------------------------------------->
    <div class="row">
        
     </div>
</div><!-- /#page-wrapper -->
