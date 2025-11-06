<div id="page-wrapper" id="hidden_div">
    <div class="row">
        <div class="col-lg-12" >
            <h1 class="page-header" >Γενικά Στοιχεία    
                <button type="button" class="btn btn-success  hidden-print" onclick="hideFunction('hidden_div')" style="float: right">Εμφάνιση</button>
                <!--
                <a  href="<?= base_url('admin/customers/create') ?>" class="btn btn-success  hidden-print" style="float: right">Νέος Πελάτης</a>
                <a  href="<?= base_url('admin/stocks/create') ?>" class="btn btn-warning" style="float: right">Νέο Ακουστικό</a>
                <a  href="<?= base_url('admin/services/create') ?>" class="btn btn-info hidden-print" style="float: right">Προσθήκη Επισκευής</a>                
                -->
                </h1>            
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
        <div class="row" id="hidden_div" >
        <?php if ($this->session->flashdata('message')): ?>
            <div class="col-lg-12 col-md-12">
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $this->session->flashdata('message') ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($this->is_admin): ?>     
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-check-square fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo json_encode($current_sales) ?></div>
                            <div>Πωλήσεις Συνολικά</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/stocks/get_sold_thisYear_sp/' . $year) ?>">
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
                            <i class="fa fa-pause fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo count($on_hold) ?></div>
                            <div>Εκκρεμότητες</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/customers/get_onhold_full') ?>">
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
                <a href="<?= base_url('admin/stocks/on_debt') ?>">
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
                            <i class="fa fa-credit-card fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $old_debt['data']//$old_debt_2016['debt']+$old_debt_2015['debt']+$old_debt_2014['debt']+$old_debt_2017['debt'] ?></div>
                            <div>Παλαιά Χρέη (έως <?php echo $year_now -1; ?>)</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/stocks/on_debt_old/' . $year_now) ?>">
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
                            <div class="huge"><?php echo $eopyy_now//(array_sum($sum_eopyy)- array_sum($eopyy_pays)) ?></div>
                            <div>Οφειλές ΕΟΠΥΥ</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/eopyy_pays') ?>">
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
                            <div class="huge">€ <?php echo $sum_debt[0]['data'] ?></div>
                            <div>Οφειλές Πελατών <?php echo $year_now ?></div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/stocks/view_stock_on_debt/' . $year_now . '/' . '1/2')?>">
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
                            <div class="huge"><?php echo $avg_price[0]['data'] ?></div>
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
                    <i class="fa fa-bar-chart-o fa-fw"></i> Ετήσια Στατιστικά Πωλήσεων Σύνολο
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" onclick="hideFunction('panel-body-month')" style="float: right">Εμφάνιση</button>
                            <!--<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Actions
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="<?php $stats = 'chart-year' ?>">Λιβαδειά</a></li>
                                <li><a href="<?php $stats = 'chart-year2' ?>">Θήβα</a></li>
                            </ul>-->
                        </div>
                    </div>
                </div><!-- /.panel-heading -->
                <div id="panel-body-month" >
                    <div id="year-general"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Πωλήσεις Τρέχοντος Έτους ανα Μήνα
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" onclick="hideFunction('panel-body-year')" style="float: right">Εμφάνιση</button>
                            
                           <!-- <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Actions
                                <span class="caret"></span>
                            </button>                             <ul class="dropdown-menu pull-right" role="menu">
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
                           -->

                        </div>
                    </div>
                </div><!-- /.panel-heading -->
                <div id="panel-body-year" >
                    <div id="chart-this-year"></div>
                </div>
            </div>
        </div>        
    </div>
<div class="row">        
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Ετήσια Στατιστικά Λιβαδειάς 
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" onclick="hideFunction('panel-body-levadia')" style="float: right">Εμφάνιση</button>
<!--
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Actions
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="<?php $stats = 'chart-year' ?>">Λιβαδειά</a></li>
                                <li><a href="<?php $stats = 'chart-year2' ?>">Θήβα</a></li>
                            </ul>
-->
                        </div>
                    </div>
                </div><!-- /.panel-heading -->
                <div id="panel-body-levadia" >
                    <div id="year-levadia"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Ετήσια Στατιστικά Θήβα
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" onclick="hideFunction('panel-body-thiva')" style="float: right">Εμφάνιση</button>
                           <!-- <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Actions
                                <span class="caret"></span>
                            </button> 
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
                           -->
                        </div>
                    </div>
                </div><!-- /.panel-heading -->
                <div id="panel-body-thiva" >
                    <div id="year-thiva"></div>
                </div>
            </div>
        </div>        
    </div>
    <?php endif; ?>
<!--endof graphs section------------------------------------------------------->
    <div class="row">
        <div class="col-lg-3">
            <div class="panel panel-default panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> Σε Εκκρεμότητα 
                     <button type="button" class="btn btn-default btn-xs dropdown-toggle" onclick="hideFunction('panel-body-todo-levadia')" style="float: right">Εμφάνιση</button>
                </div><!-- /.panel-heading -->
                <div class="panel-body" id="panel-body-todo-levadia" >
                    <div class="list-group">
                        <?php foreach ($on_hold_names as $key => $list): ?>
                        <?php  
                                $this->load->model(array('admin/doctor'));
                                $doc_id = $this->doctor->get($list['doctor']);?>
                        
                        <a href="<?= base_url('admin/customers/view/' . $list['id']) ?>" class="list-group-item 
                            <?php if ($list['selling_point']== 1): 
                                echo 'list-group-item-info'; 
                                elseif ($list['selling_point']== 2):
                                echo 'list-group-item-warning';
                                else:
                                echo ' ';
                                endif;
                                echo json_encode($list['selling_point']);
                                ?> 
                            ">
                            
                            <i class="fa fa-tasks fa-fw"></i> <?php echo $list['name'] ?>
                            <span class="pull-right text-muted small"><em><?php echo $doc_id->doc_name ?></em></span>
                        </a>
                       
                        <?php endforeach; ?>                        
                    </div><!-- /.list-group -->
                    <a href="<?= base_url('admin/customers/get_onhold_full') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div>
        <?php //endforeach; ?>        
        <div class="col-lg-3">
            <div class="panel panel-default panel-warning">
            <div class="panel-heading">
                <i class="fa fa-bell fa-fw"></i> Κατασκευές Ανοιχτές       <span class="pull-right"><strong><?php echo count($moulds) ?></strong></span>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <?php foreach ($moulds as $key => $list):
                                $this->load->model(array('admin/customer'));
                                $this->load->model(array('admin/stock'));
                                
                                $date_now = time();                                
                                
                                $customer = $this->customer->get($list['customer_id']);
                                
                                
                                $temp_date = $list['date_order'];                                
                                $delay = $date_now -strtotime($temp_date);
                                $days = round($delay / (60 * 60 * 24));
                            ?>                        
                        <a href="<?= base_url('admin/earlabs/edit/' . $list['id']) ?>" class="list-group-item  
                           <?php if ($customer->selling_point == 1): 
                                echo 'list-group-item-info'; 
                                elseif ($customer->selling_point == 2):
                                echo 'list-group-item-warning';
                                else:
                                echo ' ';
                                endif;
                                //echo json_encode($list['selling_point']);
                                ?> 
                            ">
                            <i class="fa fa-tasks fa-fw"></i> 
                                <?php echo $customer->name ?>
                                    <?php if($days > 0 && $days < 10000): ?>
                            <span style="color:blue" class="pull-center text-muted small">
                                <?php    echo 'ON LAB FOR ' . $days . ' DAYS!';    ?>
                            </span>
                                <?php endif; ?>
                            <span class="pull-right text-muted small">
                                <em> απο <?php echo $list['date_order'] ?></em>
                            </span>
                        </a>
                                
                            <?php endforeach;   ?>                        
                    </div><!-- /.list-group -->
                    <a href="<?= base_url('admin/earlabs/list_sp') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->  
            <div class="panel panel-default panel-danger">
            <div class="panel-heading">
                <i class="fa fa-bell fa-fw "></i> Εκκρεμότητες Barcodes       <span class="pull-right"><strong><?php echo count($stock_bc) ?></strong></span>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <?php foreach ($stock_bc as $key => $list):
                                $this->load->model(array('admin/customer'));
                                $this->load->model(array('admin/stock'));
                                $this->load->model(array('admin/vendor'));
                                $this->load->model(array('admin/model'));
                                
                                $date_now = time();                                
                                
                                $vendor = $this->vendor->get($list['vendor']);
                                $model = $this->model->get($list['ha_model']);
                                
                                
                                $temp_date = $list['day_in'];                                
                                $delay = $date_now -strtotime($temp_date);
                                $days = round($delay / (60 * 60 * 24));
                            ?>                        
                        <a href="<?= base_url('admin/stocks/edit/' . $list['id']) ?>" class="list-group-item  
                           <?php if ($list['selling_point']== 1): 
                                echo 'list-group-item-info'; 
                                elseif ($list['selling_point']== 2):
                                echo 'list-group-item-warning';
                                else:
                                echo ' ';
                                endif;
                                echo json_encode($list['selling_point']);
                                ?> 
                            ">
                            <i class="fa fa-tasks fa-fw"></i> 
                                <?php echo $model->model ?>-<?php echo $list['serial'] ?> - <?php echo $vendor->name ?>
                                    <?php if($days > 0 && $days < 10000): ?>
                            <span style="color:red" class="pull-center text-muted small">
                                <?php    echo 'delay ' . $days . ' DAYS!';    ?>
                            </span>
                                <?php endif; ?>
                            <span class="pull-right text-muted small">
                                <em> απο <?php echo $list['day_in'] ?></em>
                            </span>
                        </a>  
                            <?php endforeach;   ?>                        
                    </div><!-- /.list-group -->
                    <a href="<?= base_url('admin/earlabs') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div>       
        <div class="col-lg-3">            
            <div class="panel panel-default panel-warning">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> Επισκευές Ανοιχτές       <span class="pull-right"></span>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <?php //echo json_encode($services) ?>
                        <?php foreach ($services as $key => $list): ?>
                            <?php  
                                $this->load->model(array('admin/customer'));
                                $this->load->model(array('admin/stock'));
                                $date_now = time();
                                
                                $ha_service = $this->stock->get($list['ha_service']);
                                $name = $this->customer->get($ha_service->customer_id); 
                                
                                $temp_date = $list['day_in'];                                
                                $delay = $date_now -strtotime($temp_date);
                                $days = round($delay / (60 * 60 * 24));
                            ?>                        
                        <a href="<?= base_url('admin/services/edit/' . $list['id']) ?>" class="list-group-item  
                           <?php if ($ha_service->selling_point == 1): 
                                echo 'list-group-item-info'; 
                                elseif ($ha_service->selling_point == 2):
                                echo 'list-group-item-warning';
                                else:
                                echo ' ';
                                endif;
                                //echo json_encode($list['selling_point']);
                                ?> 
                            ">
                            <i class="fa fa-tasks fa-fw"></i> <?php echo $name->name ?>   
                            <?php if($days > 0 && $days < 10000): ?>
                                <span style="color:whitesmoke" class="pull-center text-muted small badge">   
                                <?php    echo 'ON SERVICE FOR ' . $days . ' DAYS!';    ?>
                                </span>                                
                                <?php endif; ?>
                            
                            <span class="pull-left text-muted small"> 
                                <em> απο <?php echo $list['day_in'] ?>    </em>                                
                            </span>
                        </a>
                        <?php endforeach;   ?>                        
                    </div><!-- /.list-group -->
                    <a href="<?= base_url('admin/services/list_open') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
            <!--doseis here -->
            <?php if ($this->is_admin): ?>
            <div class="panel panel-default panel-danger">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> Εκκρεμότητες Δόσεων       <span class="pull-right"><strong>€ <?php echo $sum_debt[0]['data'] ?></strong></span>
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" onclick="hideFunction('panel-body-debt')" style="float: right">Εμφάνιση</button>
                </div><!-- /.panel-heading -->
                <div class="panel-body" id="panel-body-debt" hidden="false">
                    <div class="list-group">
                        <?php foreach ($stock_debt as $key => $list): ?>
                            <?php  
                                $this->load->model(array('admin/customer'));
                                $this->load->model(array('admin/pay'));
                                $this->load->model(array('admin/stock'));
                                $date_now = time();
                                
                                $hearing_aid_id = $this->stock->get($list['id']);
                                $name = $this->customer->get($hearing_aid_id->customer_id);                                
                                $temp_date = $this->pay->get_all('MAX(date) AS last_pay', ' customer=' . $name->id);                                
                                $delay = $date_now -strtotime($temp_date[0]['last_pay']);
                                $days = round($delay / (60 * 60 * 24));
                            ?>                        
                        <a href="<?= base_url('admin/stocks/pays/' . $list['id']) ?>" class="list-group-item
                           <?php if ($list['selling_point']== 1): 
                                echo 'list-group-item-info'; 
                                elseif ($list['selling_point']== 2):
                                echo 'list-group-item-warning';
                                else:
                                echo ' ';
                                endif;
                                echo json_encode($list['selling_point']);
                                ?> 
                            ">
                            <i class="fa fa-tasks fa-fw"></i> <?php echo $name->name ?>
                                   
                                <?php if($days > 30 && $days < 10000): ?>
                                <span style="color:blue" class="pull-center text muted small">   
                                <?php    echo 'DELAYED ' . $days . ' DAYS!';    ?>
                                </span>
                                <?php elseif ($days > 10000 ): ?>
                                <span style="color:red" class="pull-center text muted small">
                                <?php echo 'NOT PAYED YET'; ?>
                                </span>
                                <?php endif;        ?>
                            </span>
                            <span class="pull-right text-muted small"> 
                                <em>€     
                                <?php echo $list['balance'] ?>
                                </em> </span>
                        </a>
                        <?php endforeach;   ?>                        
                    </div><!-- /.list-group -->
                    <a href="<?= base_url('admin/customers/get_all_pays') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
            <?php endif; ?>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-default panel-success">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> Προς Παράδοση - Είσπραξη      <span class="pull-right"><strong>€ <?php echo $sum_debt_on_hold[0]['data'] ?></strong></span>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <?php foreach ($on_hold_debt as $key => $list): ?>
                            <?php  
                                $this->load->model(array('admin/customer'));
                                $name = $this->customer->get($list['customer_id']);?>
                        <a href="<?= base_url('admin/stocks/pays/' . $list['id']) ?>" class="list-group-item
                           <?php if ($list['selling_point']== 1): 
                                echo 'list-group-item-info'; 
                                elseif ($list['selling_point']== 2):
                                echo 'list-group-item-warning';
                                else:
                                echo ' ';
                                endif;
                                echo json_encode($list['selling_point']);
                                ?> 
                            ">
                            <i class="fa fa-tasks fa-fw"></i> <?php echo $name->name ?>
                            <span class="pull-right text-muted small"><em>€<?php echo $list['balance'] ?></em></span>
                        </a>
                        <?php endforeach; ?>                        
                    </div><!-- /.list-group -->
                    <a href="<?= base_url('admin/customers/get_all_pays') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div>
    </div>  
<div id="vendor-stats"></div>
</div><!-- /#page-wrapper -->
<script>
    //var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    new Morris.Bar({
        element: 'year-levadia',
        data: <?php echo json_encode($statistics_levadia) ?>,       
        xkey: 'year',
        ykeys: ['sales', 'nosales'],
        labels: ['Sales', 'Missed Sales'],
        xLabels: ['year']
    });
    new Morris.Bar({
        element: 'year-thiva',
        data: <?php echo json_encode($statistics_thiva) ?>,       
        xkey: 'year',
        ykeys: ['sales', 'nosales'],
        labels: ['Sales', 'Missed Sales'],
        xLabels: ['year']
    });
    new Morris.Bar({
        element: 'year-general',
        data: <?php echo json_encode($statistics_general) ?> ,
        xkey: 'year',
        ykeys: ['sales', 'nosales'],
        labels: ['Sales', 'Missed Sales'],
        xLabels: ['year']
    });  
    new Morris.Bar({
        element: 'chart-this-year',
        data: <?php echo $this_year?> ,
        xkey: ['year'],
        ykeys: ['data'],
        labels: ['Μηνιαίες Πωλήσεις']
    });     
</script>