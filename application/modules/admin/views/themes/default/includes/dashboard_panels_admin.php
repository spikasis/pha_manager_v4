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