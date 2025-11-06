<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pikasis Hearing CRM V2.5</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
 
    <!-- Bootstrap Core CSS και JavaScript (3.3.7) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- MetisMenu CSS -->
    <link href="<?= base_url() ?>assets/admin/css/metisMenu.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/metismenu/dist/metisMenu.min.css">-->

    <!-- DataTables CSS -->
    <link href="<?= base_url() ?>assets/admin/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/admin/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= base_url() ?>assets/admin/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?= base_url() ?>assets/admin/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Morris.js CSS (Για Γραφήματα) -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <!-- Highcharts (Για Γραφήματα) -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Morris.js (Εξαρτάται από Raphael.js) -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <style>
        @media print {
            a[href]:after {
                content: "";
            }
            a {
                text-decoration: none;
                color: black;
            }
        }
    </style>
</head>

<!--ENDOF HEAD-->
<body>
    <div id="wrapper"><!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
           <div class="navbar-header">                
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <button id="toggle-menu" class="btn btn-default navbar-toggle" style="margin-top: 10px;">
                    <i class="fa fa-bars"></i>
                </button>
                    <?php 
                    $this->load->model(array('admin/company'));
                    
                    $company_name = $this->company->get(1);
                    
                    ?>
                <a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>">Καλωσήρθατε <?= $this->logged_in_name ?> | <?php echo $company_name->company_name ?> v2.5</a>
                    <?php 
                    
                    switch ($this->logged_id)
                    {
                        case 1:
                            $sp_id = 'selling_point';
                            
                            break;
                        case 14:                
                            $sp_id = 2;
                            break;
                        case 19 : 
                            $sp_id = 1;
                            break;      
                        case 6 : 
                            $sp_id = '';
                            break;       
                        case 20 : 
                            $sp_id = '';
                            break;        
                    }
                    ?>
            </div><!-- /.navbar-header -->
                <?php
                $this->load->model(array('admin/customer'));
                $this->load->model(array('admin/service'));
                $this->load->model(array('admin/earlab'));
                $this->load->model(array('admin/stock'));
                $this->load->model(array('admin/task'));
                
                //$selling_point = $sp_id;

                
                $demo_on_test = $this->stock->get_all('id, serial', 'on_test=1');
                $on_hold = $this->task->get_filtered_tasks($sp_id);
                $debt_count = $this->stock->getStocksWithDetails($sp_id, null, 3, 'non_zero');
                //$on_hold = $this->customer->get_customers(null, $sp_id, 'pending');
                $services = $this->service->get_all('id, ha_service, day_in', 'status = 2');
                $moulds = $this->earlab->get_all('id, customer_id,date_order', 'date_delivery=0');
                $stock_bc = $this->stock->get_all('id','ekapty_code=0 AND YEAR(day_in)>=2024');
                $year_this = date("Y");
                
                ?>
            <ul class="nav navbar-top-links navbar-right">
				<li>
                    <a href="<?= base_url('admin/stocks/get_demo/5/' . $sp_id) ?>" class="btn hidden-print">
                        Demos: <span class="badge"><?= count($demo_on_test) ?></span>
                        
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/stocks/view_stock_on_debt_full/' . $sp_id) ?>" class="btn hidden-print">
                        Πελάτες με υπολοιπο: <span class="badge"><?= count($debt_count) ?></span>
                        
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/tasks/filtered_tasks/' . $sp_id) ?>" class="btn hidden-print">
                        Ανοιχτές Εργασίες: <span class="badge"><?= count($on_hold) ?></span>
                        
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/services/list_open') ?>" class="btn hidden-print">
                        Ανοιχτές επισκευές: <span class="badge"><?= count($services) ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/earlabs/list_open/' . $sp_id) ?>" class="btn hidden-print">
                        Ανοιχτές κατασκευές: <span class="badge"><?= count($moulds) ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/stocks/view_barcodes_pending/' . $sp_id . '/' . $year_this) ?>" class="btn hidden-print">
                        Εκκρεμή BC: <span class="badge"><?= count($stock_bc) ?></span>                            
                    </a>                        
                </li>
                
                <!-- Dropdown για Νέα Καταχώρηση -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Νέα Καταχώρηση <i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= base_url('admin/customers/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέος Πελάτης</a></li>
                        <li><a href="<?= base_url('admin/stocks/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέο Ακουστικό</a></li>
                        <li><a href="<?= base_url('admin/services/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέα Επισκευή</a></li>
                        <li><a href="<?= base_url('admin/earlabs/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέα Κατασκευή</a></li>
                        <li><a href="<?= base_url('admin/tasks/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέα Εργασία</a></li>
                    </ul>
                </li>
                
                <!-- Dropdown για το Χρήστη -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-menu">
        <?php if ($this->is_admin): ?>
                        <li><a href="<?= base_url('admin/users/view/' . $this->logged_id) ?>"><i class="fa fa-user fa-fw"></i> Προφίλ Χρήστη</a></li>
                        <li><a href="<?= base_url('admin/usergroups') ?>"><i class="fa fa-users fa-fw"></i> Ομάδες Χρηστών</a></li>
                        <li><a href="<?= base_url('admin/users') ?>"><i class="fa fa-users fa-fw"></i> Διαχείριση Χρηστών</a></li>
                        <li class="divider"></li>
        <?php endif; ?>
                        <li><a href="<?= base_url('auth/logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Αποσύνδεση</a></li>
                    </ul>
                </li>
            </ul>            
            <div class="navbar-default sidebar" role="navigation">                
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </li>
                        
                        <li>
                            <a href="#" data-toggle="collapse" data-target="#statistics" aria-expanded="false">
                                <i class="fa fa-line-chart fa-fw"></i> Statistics <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" id="statistics">
                                <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-bar-chart-o fa-fw"></i> General</a></li>
                                <li  class="bg-info"><a href="<?= base_url('admin/tasks/') ?>" class="btn hidden-print"><i class="fa fa-tasks fa-fw"></i>Όλες οι Εργασίες</a></li> 
                    <?php if ($this->is_admin): ?>
                                <li>
                                    <a href="#" data-toggle="collapse" data-target="#admin-stats" aria-expanded="false">
                                        <i class="fa fa-line-chart fa-fw"></i> Admin Stats <span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-second-level collapse" id="admin-stats">
                                        <li>
                                            <a href="#" data-toggle="collapse" data-target="#sales-stats" aria-expanded="false">
                                                <i class="fa fa-line-chart fa-fw"></i> Στατιστικά Πωλήσεων <span class="fa arrow"></span>
                                            </a>
                                            <ul class="nav nav-third-level collapse" id="sales-stats">
                                    <?php
                                    $year = 2014;
                                    $year_now = date('Y');
                                    for ($year; $year <= $year_now; $year++) { ?>
                                                <li>
                                                    <a href="<?= base_url('admin/charts/sales_charts/' . $year) ?>">
                                                        <i class="fa fa-bar-chart fa-fw"></i> Sales <?php echo $year ?>
                                                    </a>
                                                </li>
                                    <?php } ?>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="<?= base_url('admin/services/service_stats') ?>">
                                                <i class="fa fa-support fa-fw"></i> Στατιστικα Μοντέλων
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url('admin/service_tickets/service_stats/1') ?>" data-toggle="collapse" data-target="#repair-stats" aria-expanded="false">
                                                <i class="fa fa-line-chart fa-fw"></i> Στατιστικά Επισκευών <span class="fa arrow"></span>
                                            </a>                                            
                                        </li>
                                        
                                        <!--start of ChatGPT Addition -->
                                        <li>
                                            <a href="#" data-toggle="collapse" data-target="#store-stats" aria-expanded="false">                                                
                                                <i class="fa fa-line-chart fa-fw"></i> Στατιστικά Καταστημάτων <span class="fa arrow"></span>
                                            </a>
                                            <ul class="nav nav-third-level collapse" id="store-stats">
                                            <?php
                                                $this->load->model(array('admin/selling_point'));
                                                $selling_point = $this->selling_point->get_all('id, city');
                                                foreach ($selling_point as $list): ?>
                                                <li>
                                                    <a href="<?= base_url('admin/dashboard/' . $list['id']) ?>">
                                                        <i class="fa fa-pie-chart fa-fw"></i> <?php echo $list['city'] ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                                
                                                <!-- Adding Overall Yearly Statistics -->
                                                <li>
                                                    <a href="<?= base_url('admin/dashboard/selling_point') ?>">
                                                        <i class="fa fa-bar-chart fa-fw"></i> Συνολικά Στατιστικά Έτους
                                                    </a>
                                                </li>
                                            </ul>
                                        </li><!--end of ChatGPT Addition -->                                        
                                    </ul>
                                </li>
                    <?php endif; ?>
                            </ul>
                        </li>                                               
                        <li class="bg-success">
                            <a href="#" data-toggle="collapse" data-target="#new-entries" aria-expanded="false">
                                <i class="fa fa-plus fa-fw"></i> Νέες Καταχωρήσεις <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" id="new-entries">
                                <li><a href="<?= base_url('admin/customers/create') ?>"><i class="fa fa-plus fa-fw"></i> Πελάτης</a></li>
                                <li><a href="<?= base_url('admin/offers/create') ?>"><i class="fa fa-plus fa-fw"></i> Προσφορά</a></li>
                                <li><a  href="<?= base_url('admin/stocks/create') ?>" ><i class="fa fa-plus fa-fw"></i>Ακουστικό</a></li>
                                <li><a  href="<?= base_url('admin/services/create') ?>"><i class="fa fa-plus fa-fw"></i>Επισκευή</a></li>
                                <li><a  href="<?= base_url('admin/earlabs/create') ?>" ><i class="fa fa-plus fa-fw"></i>Κατασκευή</a></li>
                                <li><a href="#" class="btn-hover"><i class="fa fa-plus fa-fw"></i>Μοντέλα Ακουστικών</a>
                                    <ul class="nav nav-third-level">                                          
                                        <li><a  href="<?= base_url('admin/models') ?>"><i class="fa fa-eye fa-fw"></i>Προβολή Μοντέλων</a></li>
                                        <li><a  href="<?= base_url('admin/models/create') ?>"><i class="fa fa-plus fa-fw"></i>Προσθήκη Μοντέλου</a></li>
                                        <?php if ($this->is_admin): ?>
                                        <li><a  href="<?= base_url('admin/series') ?>" ><i class="fa fa-eye fa-fw"></i>Προβολή Σειρών Ακουστικών</a></li>
                                        <li><a  href="<?= base_url('admin/series/create') ?>" ><i class="fa fa-plus fa-fw"></i>Προσθήκη Σειράς Ακουστικών</a></li>
                                        <?php endif;?>
                                    </ul>  
                                </li>
                            </ul>
                        </li>
                        <li class="bg-warning">
                            <a href="#" data-toggle="collapse" data-target="#customers-menu">
                                <i class="fa fa-android fa-fw"></i> Πελάτες<span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" id="customers-menu">
                                <li><a href="<?= base_url('admin/customers/get_sold/' . $sp_id) ?>"><i class="fa fa-check-circle fa-fw"></i> Πωλήσεις <?php echo $this->logged_in_name; ?></a></li>
                                <li><a href="<?= base_url('admin/customers/get_interested_sp/' . $sp_id) ?>"><i class="fa fa-openid fa-fw"></i> Ενδιαφερόμενοι <?php echo $this->logged_in_name; ?></a></li>
                                <li><a href="<?= base_url('admin/customers/') ?>"><i class="fa fa-check-circle fa-fw"></i> Πλήρης Λίστα Πελατών</a></li>
                                <li><a href="<?= base_url('admin/customers/get_onhold/' . $sp_id) ?>"><i class="fa fa-pause fa-fw"></i> Σε Εκκρεμότητα</a></li>
                                <li><a href="<?= base_url('admin/offers') ?>"><i class="fa fa-dollar fa-fw"></i> Προσφορές</a></li>
                            </ul>
                        </li>
                        
                        <li class="bg-info">
                            <a href="#" data-toggle="collapse" data-target="#acousticMenu">
                                <i class="fa fa-headphones fa-fw"></i> Ακουστικά <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" id="acousticMenu">
                                <li><a href="<?= base_url('admin/stocks/list_sp/') ?>"><i class="fa fa-check fa-fw"></i> Ακουστικά Πλήρης Λίστα</a></li>
                                <li><a href="<?= base_url('admin/stocks/list_sp/' . $sp_id ) ?>"><i class="fa fa-check fa-fw"></i> Ακουστικά <?= $this->logged_in_name; ?></a></li>
                                <li><a href="<?= base_url('admin/stocks/get_demo/5/' . $sp_id) ?>"><i class="fa fa-try fa-fw"></i> Demo</a></li>
                                <li><a href="<?= base_url('admin/stocks/view_free_barcodes/' . $year_this) ?>"><i class="fa fa-barcode fa-fw"></i> Ελέυθερα BC</a></li>
                                
                            <?php if ($this->is_admin): ?>
                                <li><a href="<?= base_url('admin/stocks/get_onstock') ?>"><i class="fa fa-stack-overflow fa-fw"></i> Διαθέσιμα Αποθήκης</a></li>
                                <li><a href="<?= base_url('admin/stocks/get_available_serial') ?>"><i class="fa fa-barcode fa-fw"></i> Serials/BC (Διαθέσιμα)</a></li>
                                <li><a href="<?= base_url('admin/stocks/get_stockblack') ?>"><i class="fa fa-outdent fa-fw"></i> Black</a></li>
                                <li><a href="<?= base_url('admin/stocks/get_returns') ?>"><i class="fa fa-recycle fa-fw"></i> Επιστροφές</a></li>
                            <?php endif; ?>
                                
                            <?php if ($this->logged_id == 20): ?>
                                <li><a href="<?= base_url('admin/stocks/list_sp/') ?>"><i class="fa fa-check fa-fw"></i> Ακουστικά Πλήρης Λίστα</a></li>
                                <li><a href="<?= base_url('admin/stocks/get_onstock') ?>"><i class="fa fa-bookmark fa-fw"></i> Διαθέσιμα Αποθήκης</a></li>
                                <li><a href="<?= base_url('admin/stocks/get_available_serial') ?>"><i class="fa fa-barcode fa-fw"></i> Serials/BC (Διαθέσιμα)</a></li>
                                <li><a href="<?= base_url('admin/stocks/get_returns') ?>"><i class="fa fa-barcode fa-fw"></i> Επιστροφές</a></li>
                            <?php endif; ?>
                            </ul>
                        </li>
                        <li class="bg-danger">
                            <a href="#" data-toggle="collapse" data-target="#labMenu">
                                <i class="fa fa-wrench fa-fw"></i> Εργαστήριο <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" id="labMenu">
                                <li><a href="<?= base_url('admin/services/list_sp/' . $sp_id) ?>"><i class="fa fa-support fa-fw"></i> Service <?= $this->logged_in_name; ?></a></li>
                                <li><a href="<?= base_url('admin/earlabs/list_sp/' . $sp_id) ?>"><i class="fa fa-gear fa-fw"></i> Κατασκευές <?= $this->logged_in_name; ?></a></li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="#" data-toggle="collapse" data-target="#documentsMenu">
                                <i class="fa fa-paperclip fa-fw"></i> Έντυπα <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" id="documentsMenu">
                                <li>
                                    <a href="#" data-toggle="collapse" data-target="#ekaptyMenu">
                                        <i class="fa fa-file-archive-o fa-fw"></i> ΕΚΑΠΤΥ <span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-third-level collapse" id="ekaptyMenu">
                                        <li><a href="<?= base_url('admin/vendors/view_all_ekapty') ?>"><i class="fa fa-file-archive-o fa-fw"></i> Λίστα Προμηθευτων</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" data-toggle="collapse" data-target="#otherDocumentsMenu">
                                        <i class="fa fa-certificate fa-fw"></i> Διάφορα Έντυπα <span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-third-level collapse" id="otherDocumentsMenu">
                                        <li><a href="<?= base_url('admin/banks/view') ?>"><i class="fa fa-bank fa-fw"></i> Τραπεζικοί Λογαριασμοί</a></li>
                                        <li><a href="<?= base_url('assets/uploads/files/documents/first_user.pdf') ?>" target="_blank"><i class="fa fa-user fa-fw"></i> Πρώτη Εφαρμογή</a></li>
                                        <li><a href="<?= base_url('assets/uploads/files/documents/perifereia_students.pdf') ?>" target="_blank"><i class="fa fa-briefcase fa-fw"></i> Δικαιολογητικά Περιφέρειας - Μαθητές</a></li>
                                        <li><a href="<?= base_url('assets/uploads/files/documents/battery_consumption.pdf') ?>" target="_blank"><i class="fa fa-check-circle fa-fw"></i> Φόρμα Κατανάλωσης Μπαταρίας</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        
                        
                        <li class="bg-danger">
                            <a href="#" data-toggle="collapse" data-target="#paymentsMenu" aria-expanded="false">
                                <i class="fa fa-money fa-fw"></i> Πληρωμές <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" id="paymentsMenu">
                                <li><a href="<?= base_url('admin/pays/get_pays_sp/' . $sp_id ) ?>"><i class="fa fa-money fa-fw"></i> Οφειλές Πελατών</a></li>
        <?php if ($this->is_admin): ?>
                                <li><a href="<?= base_url('admin/pays') ?>"><i class="fa fa-money fa-fw"></i> Πληρωμές Πελατών</a></li>
                                <li><a href="<?= base_url('admin/eopyy_pays') ?>"><i class="fa fa-money fa-fw"></i> Πληρωμές ΕΟΠΥΥ</a></li>
        <?php endif; ?>
                            </ul>
                        </li>
                        
                            <?php if ($this->is_admin): ?>
                        <li>
                            <a href="#" data-toggle="collapse" data-target="#partnersMenu" aria-expanded="false">
                                <i class="fa fa-briefcase fa-fw"></i> Συνεργάτες <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" id="partnersMenu">
                                <li><a href="<?= base_url('admin/doctors') ?>"><i class="fa fa-user-md fa-fw"></i> Γιατροί</a></li>
                                <li><a href="<?= base_url('admin/vendors') ?>"><i class="fa fa-briefcase fa-fw"></i> Προμηθευτές</a></li>
                                <li><a href="<?= base_url('admin/manufacturers') ?>"><i class="fa fa-headphones fa-fw"></i> Brands</a></li>
                                <li><a href="<?= base_url('admin/ManufacturerReport/') ?>"><i class="fa fa-headphones fa-fw"></i> Στατιστικα</a></li>
                            
                            </ul>
                        </li>
                        
                        <li>
                            <a href="#" data-toggle="collapse" data-target="#settingsMenu" aria-expanded="false">
                                <i class="fa fa-gears fa-fw"></i> Ρυθμίσεις <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse" id="settingsMenu">
                                <li>
                                    <a href="#" data-toggle="collapse" data-target="#businessSettingsMenu" aria-expanded="false">
                                        <i class="fa fa-edit fa-fw"></i> Settings Επιχείρησης <span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-third-level collapse" id="businessSettingsMenu">
                                        <li><a href="<?= base_url('admin/companies') ?>"><i class="fa fa-edit fa-fw"></i> Προφίλ Επιχείρησης</a></li>
                                        <li><a href="<?= base_url('admin/selling_points') ?>"><i class="fa fa-edit fa-fw"></i> Καταστήματα</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?= base_url('admin/banks') ?>"><i class="fa fa-edit fa-fw"></i> Τραπεζικοί Λογαριασμοί</a></li>
                                <li><a href="<?= base_url('admin/usergroups') ?>"><i class="fa fa-edit fa-fw"></i> User Groups</a></li>
                                <li><a href="<?= base_url('admin/users') ?>"><i class="fa fa-edit fa-fw"></i> Users</a></li>
                            </ul>
                        </li>
                            <?php endif; ?>
                        
                </div>
            </div>            
        </nav>
    </div>
   
    <script>
    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
    });
    
    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
        $('#toggle-menu').on('click', function() {
            $('#wrapper').toggleClass('collapsed');
            $('.navbar-default.sidebar').toggleClass('sidebar-hidden');
        });
    });
    </script>
    <style>
    .sidebar-hidden {
        display: none;
    }

    #wrapper {
        transition: margin-left 0.3s;
    }

    #wrapper.collapsed {
        margin-left: 0;
    }

    #toggle-menu {
        display: inline-block; /* Διασφαλίζει ότι το κουμπί είναι ορατό */
        margin-top: 10px; /* Εάν χρειάζεται να προσαρμόσεις την απόσταση */
        color: #000; /* Ίσως να χρειαστείς διαφορετικό χρώμα */
        cursor: pointer; /* Χερί για να δείξεις ότι είναι κλικαριστό */
    }
    
    #main-content {
        transition: margin-left 0.3s; /* Ομαλή μετάβαση */
    }
    
    #wrapper.collapsed #main-content {
        margin-left: 0; /* Αφαίρεση περιθωρίου όταν είναι κρυφό το sidebar */
    }
    </style>
    