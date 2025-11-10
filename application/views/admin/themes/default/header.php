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
                <!-- Καθυστερημένες Επισκευές Notification -->
                <li class="dropdown" id="delayed-services-notification">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Καθυστερημένες Επισκευές">
                        <i class="fa fa-exclamation-triangle text-danger"></i> 
                        Καθυστερημένες: <span class="badge badge-danger" id="delayed-services-count">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts" style="width: 350px;">
                        <li class="dropdown-header">
                            <i class="fa fa-exclamation-triangle"></i> Επισκευές με Καθυστέρηση
                        </li>
                        <li class="divider"></li>
                        <div id="delayed-services-list">
                            <!-- Θα φορτωθεί με AJAX -->
                        </div>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center">
                                <a href="<?= base_url('admin/services/delayed') ?>" class="btn btn-sm btn-primary">
                                    <i class="fa fa-eye"></i> Προβολή Όλων
                                </a>
                                <button class="btn btn-sm btn-default" id="refresh-delayed-services">
                                    <i class="fa fa-refresh"></i> Ανανέωση
                                </button>
                            </div>
                        </li>
                    </ul>
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
            <!-- Sidebar Menu - Loaded from separate file -->
            <?php $this->load->view($this->config->item('ci_my_admin_template_dir_admin') . 'sidemenu'); ?>




            
        </nav>
    </div>
   
    <script>
    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
        
        // Menu toggle functionality
        $('#toggle-menu').on('click', function() {
            $('#wrapper').toggleClass('collapsed');
            $('.navbar-default.sidebar').toggleClass('sidebar-hidden');
        });
        
        // Initialize delayed services notification system
        loadDelayedServicesNotification();
        
        // Refresh delayed services every 5 minutes
        setInterval(loadDelayedServicesNotification, 300000);
        
        // Manual refresh button
        $(document).on('click', '#refresh-delayed-services', function(e) {
            e.preventDefault();
            loadDelayedServicesNotification();
        });
    });
    
    function loadDelayedServicesNotification() {
        $.get('<?= base_url("admin/services/get_delayed_services") ?>', function(data) {
            if (data && typeof data === 'object') {
                updateDelayedServicesUI(data);
            }
        }).fail(function() {
            console.log('Σφάλμα φόρτωσης καθυστερημένων επισκευών');
        });
    }
    
    function updateDelayedServicesUI(data) {
        var count = data.count || 0;
        var services = data.services || [];
        
        // Update badge
        $('#delayed-services-count').text(count);
        
        // Show/hide notification based on count
        if (count > 0) {
            $('#delayed-services-notification').show();
            
            // Update list
            var listHtml = '';
            services.forEach(function(service) {
                var daysLate = service.days_in_lab;
                var badgeClass = daysLate > 14 ? 'badge-danger' : (daysLate > 7 ? 'badge-warning' : 'badge-info');
                
                listHtml += '<li>' +
                    '<div class="dropdown-item-content">' +
                        '<div><strong>' + service.customer_name + '</strong></div>' +
                        '<div class="small text-muted">' + service.device_model + ' - S/N: ' + service.device_serial + '</div>' +
                        '<div class="small">' +
                            '<span class="badge ' + badgeClass + '">' + daysLate + ' ημέρες</span> ' +
                            '<span class="text-muted">στο ' + service.lab_name + '</span>' +
                        '</div>' +
                        '<div class="text-right">' +
                            '<a href="<?= base_url("admin/services/edit/") ?>' + service.id + '" class="btn btn-xs btn-primary">Επεξεργασία</a>' +
                        '</div>' +
                    '</div>' +
                '</li>' +
                (services.indexOf(service) < services.length - 1 ? '<li class="divider"></li>' : '');
            });
            
            $('#delayed-services-list').html(listHtml);
            
            // Make notification more prominent if there are critical delays (>14 days)
            var criticalCount = services.filter(function(s) { return s.days_in_lab > 14; }).length;
            if (criticalCount > 0) {
                $('#delayed-services-notification').addClass('pulse-danger');
            } else {
                $('#delayed-services-notification').removeClass('pulse-danger');
            }
        } else {
            $('#delayed-services-notification').hide();
        }
    }
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
        display: inline-block;
        margin-top: 10px;
        color: #000;
        cursor: pointer;
    }
    
    /* Delayed Services Notification Styles */
    .dropdown-alerts {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .dropdown-item-content {
        padding: 10px 15px;
        border-bottom: 1px solid #eee;
    }
    
    .dropdown-item-content:last-child {
        border-bottom: none;
    }
    
    .badge-danger {
        background-color: #d9534f;
    }
    
    .badge-warning {
        background-color: #f0ad4e;
    }
    
    .badge-info {
        background-color: #5bc0de;
    }
    
    /* Pulse animation for critical notifications */
    @keyframes pulse-danger {
        0% { box-shadow: 0 0 0 0 rgba(217, 83, 79, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(217, 83, 79, 0); }
        100% { box-shadow: 0 0 0 0 rgba(217, 83, 79, 0); }
    }
    
    .pulse-danger {
        animation: pulse-danger 2s infinite;
    }
    
    #delayed-services-notification .fa-exclamation-triangle {
        animation: blink 1s infinite;
    }
    
    @keyframes blink {
        0%, 50% { opacity: 1; }
        51%, 100% { opacity: 0.5; }
    }
    
    /* Notification hidden by default */
    #delayed-services-notification {
        display: none;
    }
    
    #main-content {
        transition: margin-left 0.3s; /* Ομαλή μετάβαση */
    }
    
    #wrapper.collapsed #main-content {
        margin-left: 0; /* Αφαίρεση περιθωρίου όταν είναι κρυφό το sidebar */
    }
    </style>
    