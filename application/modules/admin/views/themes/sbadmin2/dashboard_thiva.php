<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Στατιστικά Θήβας</h1>
            <?php //echo json_encode($statistics) ?>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <?php if ($this->session->flashdata('message')): ?>
            <div class="col-lg-12 col-md-12">
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $this->session->flashdata('message') ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-check-square fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $current_sales_thiva['sales'] ?></div>
                            <div>Πωλήσεις Θήβα</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/customers/get_sold') ?>">
                    <div class="panel-footer">
                        <span class="pull-left">Λεπτομέρειες</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $on_hold ?></div>
                            <div>Εκκρεμείς Παραγγελίες</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/customers/get_onhold') ?>">
                    <div class="panel-footer">
                        <span class="pull-left">Λεπτομέρειες</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-bomb fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $in_debt_customers; //$current_sales['nosales'] ?></div>
                            <div>Οφειλέτες</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/customers/get_all_pays') ?>">
                    <div class="panel-footer">
                        <span class="pull-left">Λεπτομέρειες</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-barcode fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $stock_available ?></div>
                            <div>Διαθέσιμα Αποθήκης</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/stocks/get_onstock') ?>">
                    <div class="panel-footer">
                        <span class="pull-left">Λεπτομέρειες</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $current_sales['nosales'] ?></div>
<!--                        <div class="huge"><?php echo $current_sales_thiva['sales'] ?></div>  -->
                            <div>Ενδιαφερόμενοι</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/stocks/get_nosales') ?>">
                    <div class="panel-footer">
                        <span class="pull-left">Λεπτομέρειες</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-euro fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $eopyy_now ?></div>
                            <div>Οφειλές ΕΟΠΥΥ</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/customers/get_all_pays') ?>">
                    <div class="panel-footer">
                        <span class="pull-left">Λεπτομέρειες</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>        
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-bank fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">€ <?php echo array_sum($sum_debt) ?></div>
                            <div>Οφειλές Πελατών</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/stocks/get_all_pays') ?>">
                    <div class="panel-footer">
                        <span class="pull-left">Λεπτομέρειες</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div> 
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-euro fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $avg_price ?></div>
                            <div>Μέση Τιμή</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/stocks/get_onstock') ?>">
                    <div class="panel-footer">
                        <span class="pull-left">Λεπτομέρειες</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div> 
    </div>
<!--start of graphs ---------------->    
    <div class="row">        
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Ετήσια Στατιστικά Πωλήσεων 
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Actions
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="<?php $stats = 'chart-year' ?>">Λιβαδειά</a></li>
                                <li><a href="<?php //$stats = 'chart-year2' ?>">Θήβα</a></li>
                            </ul>
                        </div>
                    </div>
                </div><!-- /.panel-heading -->
                <div id="panel-body">
                    <div id="<?php echo $stats ?>"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Πωλήσεις Τρέχοντος Έτους
                    <div class="pull-right">
                        <div class="btn-group">
                           <!-- <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Actions
                                <span class="caret"></span>
                            </button> -->
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#">Πόλη</a>
                                </li>
                                <li><a href="#">Λιβαδειά</a>
                                </li>
                                <li><a href="#">Θήβα</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- /.panel-heading -->
                <div id="panel-body">
                    <div id="chart-this-year"><?php //echo $this_year ?></div>
                </div>
            </div>
        </div>        
    </div>
<!--endof graphs section------------------------------------------------------->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> Βιβλιάρια σε εκκρεμότητα
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <?php foreach ($on_hold_names as $key => $list): ?>
                        <?php  
                                $this->load->model(array('admin/doctor'));
                                $doc_id = $this->doctor->get($list['doctor']);?>
                        <a href="<?= base_url('admin/customers/view/' . $list['id']) ?>" class="list-group-item">
                            <i class="fa fa-tasks fa-fw"></i> <?php echo $list['name'] ?>
                            <span class="pull-right text-muted small"><em><?php echo $doc_id->doc_name ?></em></span>
                        </a>
                        <?php endforeach; ?>                        
                    </div><!-- /.list-group -->
                    <a href="<?= base_url('admin/customers/get_onhold') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->   
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> Εκκρεμότητες Δόσεων      <span class="pull-right"><strong>€ <?php echo array_sum($sum_debt) ?></strong></span>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <?php foreach ($stock_debt as $key => $list): ?>
                        <?php  
                                $this->load->model(array('admin/customer'));
                                $name = $this->customer->get($list['customer_id']);?>
                        <a href="<?= base_url('admin/stocks/pays/' . $list['id']) ?>" class="list-group-item">
                            <i class="fa fa-tasks fa-fw"></i> <?php echo $name->name ?>
                            <span class="pull-right text-muted small"><em>€<?php echo $list['debt'] ?></em></span>
                        </a>                        
                        <?php endforeach; ?>                        
                    </div><!-- /.list-group -->
                    <a href="<?= base_url('admin/customers/get_all_pays') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->   
        </div>
    </div>  
</div><!-- /#page-wrapper -->
<script>
    new Morris.Bar({
        element: 'chart-year',
        data: <?php echo json_encode($statistics_thiva) ?>,       
        xkey: 'year',
        ykeys: ['sales', 'nosales'],
        labels: ['Sales', 'Missed Sales'],
        xLabels: ['year']
    });
    new Morris.Bar({
        element: 'chart-this-year',
        data: <?php echo $this_year ?> ,
        xkey: 'month',
        ykeys: ['data'],
        labels: ['Μηνιαίες Πωλήσεις']
    });  
</script>