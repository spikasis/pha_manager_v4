<?php
$CI =& get_instance();
$user_id = $CI->ion_auth->get_user_id();
$group = $CI->ion_auth->get_users_groups($user_id)->row();
$group_id = $group->id;

// Load necessary models
$CI->load->model(array('admin/customer', 'admin/service', 'admin/earlab', 'admin/stock', 'admin/task'));

// Determine selling point ID based on user
switch ($CI->logged_id) {
    case 1:
        $sp_id = 'selling_point'; // Admin sees all
        break;
    case 14:
        $sp_id = 2; // Θήβα
        break;
    case 19:
        $sp_id = 1; // Λιβαδειά
        break;
    case 6:
    case 20:
        $sp_id = ''; // Lab users
        break;
    default:
        $sp_id = '';
        break;
}
?>

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Αναζήτηση...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </li>

            <!-- Αρχική -->
            <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard fa-fw"></i> Αρχική</a></li>

            <!-- Διαχείριση Πελατών -->
            <?php if (in_array($group_id, [1, 4, 5])): // Admin, Υποκατάστημα Λιβαδειάς, Υποκατάστημα Θήβας ?>
            <li>
                <a href="#" data-toggle="collapse" data-target="#customers-menu" aria-expanded="false">
                    <i class="fa fa-users fa-fw"></i> Πελάτες <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" id="customers-menu">
                    <?php if ($group_id == 1): // Admin sees all ?>
                    <li><a href="<?= base_url('admin/customers') ?>"><i class="fa fa-list fa-fw"></i> Όλοι οι Πελάτες</a></li>
                    <li><a href="<?= base_url('admin/customers/list_sp/1') ?>"><i class="fa fa-building-o fa-fw"></i> Πελάτες Λιβαδειάς</a></li>
                    <li><a href="<?= base_url('admin/customers/list_sp/2') ?>"><i class="fa fa-building-o fa-fw"></i> Πελάτες Θήβας</a></li>
                    <?php else: // Υποκαταστήματα see their own ?>
                    <li><a href="<?= base_url('admin/customers/list_sp/' . $sp_id) ?>"><i class="fa fa-list fa-fw"></i> Πελάτες <?= ($sp_id == 1) ? 'Λιβαδειάς' : 'Θήβας' ?></a></li>
                    <?php endif; ?>
                    
                    <li><a href="<?= base_url('admin/customers/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέος Πελάτης</a></li>
                    <?php if ($group_id == 1): // Admin only ?>
                    <li><a href="<?= base_url('admin/customers/search') ?>"><i class="fa fa-search fa-fw"></i> Αναζήτηση Πελάτη</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Διαχείριση Ακουστικών -->
            <?php if (in_array($group_id, [1, 4, 5])): ?>
            <li>
                <a href="#" data-toggle="collapse" data-target="#stocks-menu" aria-expanded="false">
                    <i class="fa fa-headphones fa-fw"></i> Ακουστικά <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" id="stocks-menu">
                    <?php if ($group_id == 1): // Admin sees all ?>
                    <li><a href="<?= base_url('admin/stocks') ?>"><i class="fa fa-list fa-fw"></i> Όλα τα Ακουστικά</a></li>
                    <li><a href="<?= base_url('admin/stocks/list_sp/1') ?>"><i class="fa fa-building-o fa-fw"></i> Ακουστικά Λιβαδειάς</a></li>
                    <li><a href="<?= base_url('admin/stocks/list_sp/2') ?>"><i class="fa fa-building-o fa-fw"></i> Ακουστικά Θήβας</a></li>
                    <li><a href="<?= base_url('admin/stocks/get_onstock') ?>"><i class="fa fa-bookmark fa-fw"></i> Διαθέσιμα Αποθήκης</a></li>
                    <li><a href="<?= base_url('admin/stocks/get_returns') ?>"><i class="fa fa-recycle fa-fw"></i> Επιστροφές</a></li>
                    <?php else: // Υποκαταστήματα see their own ?>
                    <li><a href="<?= base_url('admin/stocks/list_sp/' . $sp_id) ?>"><i class="fa fa-list fa-fw"></i> Ακουστικά <?= ($sp_id == 1) ? 'Λιβαδειάς' : 'Θήβας' ?></a></li>
                    <li><a href="<?= base_url('admin/stocks/get_demo/5/' . $sp_id) ?>"><i class="fa fa-cog fa-fw"></i> Demo Ακουστικά</a></li>
                    <li><a href="<?= base_url('admin/stocks/view_stock_on_debt_full/' . $sp_id) ?>"><i class="fa fa-exclamation-triangle fa-fw"></i> Με Υπόλοιπο</a></li>
                    <?php endif; ?>
                    
                    <li><a href="<?= base_url('admin/stocks/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέο Ακουστικό</a></li>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Επισκευές -->
            <?php if (in_array($group_id, [1, 4, 5, 6])): // Admin, Υποκαταστήματα, Lab ?>
            <li>
                <a href="#" data-toggle="collapse" data-target="#services-menu" aria-expanded="false">
                    <i class="fa fa-wrench fa-fw"></i> Επισκευές <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" id="services-menu">
                    <?php if ($group_id == 1): // Admin sees all ?>
                    <li><a href="<?= base_url('admin/services') ?>"><i class="fa fa-list fa-fw"></i> Όλες οι Επισκευές</a></li>
                    <li><a href="<?= base_url('admin/services/list_sp/1') ?>"><i class="fa fa-building-o fa-fw"></i> Λιβαδειά</a></li>
                    <li><a href="<?= base_url('admin/services/list_sp/2') ?>"><i class="fa fa-building-o fa-fw"></i> Θήβα</a></li>
                    <?php elseif (in_array($group_id, [4, 5])): // Υποκαταστήματα see their own ?>
                    <li><a href="<?= base_url('admin/services/list_sp/' . $sp_id) ?>"><i class="fa fa-list fa-fw"></i> Επισκευές <?= ($sp_id == 1) ? 'Λιβαδειάς' : 'Θήβας' ?></a></li>
                    <?php else: // Lab sees all ?>
                    <li><a href="<?= base_url('admin/services') ?>"><i class="fa fa-list fa-fw"></i> Όλες οι Επισκευές</a></li>
                    <?php endif; ?>
                    
                    <?php if (in_array($group_id, [1, 4, 5])): // Not lab users ?>
                    <li><a href="<?= base_url('admin/services/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέα Επισκευή</a></li>
                    <?php endif; ?>
                    <li><a href="<?= base_url('admin/services/list_open') ?>"><i class="fa fa-clock-o fa-fw"></i> Ανοιχτές Επισκευές</a></li>
                    <li><a href="<?= base_url('admin/services/delayed') ?>"><i class="fa fa-exclamation-triangle fa-fw"></i> Καθυστερημένες</a></li>
                    <?php if ($group_id == 1): // Admin only ?>
                    <li><a href="<?= base_url('admin/services/service_stats') ?>"><i class="fa fa-bar-chart fa-fw"></i> Στατιστικά Επισκευών</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Εργασίες -->
            <?php if (in_array($group_id, [1, 4, 5, 6])): ?>
            <li>
                <a href="#" data-toggle="collapse" data-target="#tasks-menu" aria-expanded="false">
                    <i class="fa fa-tasks fa-fw"></i> Εργασίες <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" id="tasks-menu">
                    <li><a href="<?= base_url('admin/tasks') ?>"><i class="fa fa-list fa-fw"></i> Όλες οι Εργασίες</a></li>
                    <li><a href="<?= base_url('admin/tasks/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέα Εργασία</a></li>
                    <?php if ($sp_id && $sp_id !== 'selling_point'): ?>
                    <li><a href="<?= base_url('admin/tasks/filtered_tasks/' . $sp_id) ?>"><i class="fa fa-filter fa-fw"></i> Εργασίες Υποκαταστήματος</a></li>
                    <?php elseif ($group_id == 1): ?>
                    <li><a href="<?= base_url('admin/tasks/filtered_tasks/1') ?>"><i class="fa fa-building fa-fw"></i> Εργασίες Λιβαδειάς</a></li>
                    <li><a href="<?= base_url('admin/tasks/filtered_tasks/2') ?>"><i class="fa fa-building fa-fw"></i> Εργασίες Θήβας</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Κατασκευές -->
            <?php if (in_array($group_id, [1, 4, 5, 6])): ?>
            <li>
                <a href="#" data-toggle="collapse" data-target="#earlabs-menu" aria-expanded="false">
                    <i class="fa fa-flask fa-fw"></i> Κατασκευές <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" id="earlabs-menu">
                    <?php if ($group_id == 1): // Admin sees all ?>
                    <li><a href="<?= base_url('admin/earlabs') ?>"><i class="fa fa-list fa-fw"></i> Όλες οι Κατασκευές</a></li>
                    <li><a href="<?= base_url('admin/earlabs/list_sp/1') ?>"><i class="fa fa-building-o fa-fw"></i> Κατασκευές Λιβαδειάς</a></li>
                    <li><a href="<?= base_url('admin/earlabs/list_sp/2') ?>"><i class="fa fa-building-o fa-fw"></i> Κατασκευές Θήβας</a></li>
                    <li><a href="<?= base_url('admin/earlabs/list_open/1') ?>"><i class="fa fa-clock-o fa-fw"></i> Ανοιχτές Λιβαδειάς</a></li>
                    <li><a href="<?= base_url('admin/earlabs/list_open/2') ?>"><i class="fa fa-clock-o fa-fw"></i> Ανοιχτές Θήβας</a></li>
                    <?php elseif (in_array($group_id, [4, 5])): // Υποκαταστήματα see their own ?>
                    <li><a href="<?= base_url('admin/earlabs/list_sp/' . $sp_id) ?>"><i class="fa fa-list fa-fw"></i> Κατασκευές <?= ($sp_id == 1) ? 'Λιβαδειάς' : 'Θήβας' ?></a></li>
                    <li><a href="<?= base_url('admin/earlabs/list_open/' . $sp_id) ?>"><i class="fa fa-clock-o fa-fw"></i> Ανοιχτές Κατασκευές</a></li>
                    <?php else: // Lab sees all ?>
                    <li><a href="<?= base_url('admin/earlabs') ?>"><i class="fa fa-list fa-fw"></i> Όλες οι Κατασκευές</a></li>
                    <?php endif; ?>
                    
                    <?php if (in_array($group_id, [1, 4, 5])): // Not lab users ?>
                    <li><a href="<?= base_url('admin/earlabs/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέα Κατασκευή</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Πληρωμές -->
            <?php if (in_array($group_id, [1, 4, 5])): ?>
            <li>
                <a href="#" data-toggle="collapse" data-target="#payments-menu" aria-expanded="false">
                    <i class="fa fa-money fa-fw"></i> Πληρωμές <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" id="payments-menu">
                    <?php if ($group_id == 1): // Admin sees all ?>
                    <li><a href="<?= base_url('admin/pays') ?>"><i class="fa fa-credit-card fa-fw"></i> Όλες οι Πληρωμές</a></li>
                    <li><a href="<?= base_url('admin/pays/get_pays_sp/1') ?>"><i class="fa fa-building-o fa-fw"></i> Οφειλές Λιβαδειάς</a></li>
                    <li><a href="<?= base_url('admin/pays/get_pays_sp/2') ?>"><i class="fa fa-building-o fa-fw"></i> Οφειλές Θήβας</a></li>
                    <li><a href="<?= base_url('admin/eopyy_pays') ?>"><i class="fa fa-university fa-fw"></i> Πληρωμές ΕΟΠΥΥ</a></li>
                    <?php else: // Υποκαταστήματα see their own ?>
                    <li><a href="<?= base_url('admin/pays/get_pays_sp/' . $sp_id) ?>"><i class="fa fa-credit-card fa-fw"></i> Οφειλές Πελατών</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Στατιστικά -->
            <?php if ($group_id == 1): // Admin only ?>
            <li>
                <a href="#" data-toggle="collapse" data-target="#statistics-menu" aria-expanded="false">
                    <i class="fa fa-line-chart fa-fw"></i> Στατιστικά <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" id="statistics-menu">
                    <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard fa-fw"></i> Γενικά Στατιστικά</a></li>
                    <li>
                        <a href="#" data-toggle="collapse" data-target="#sales-stats" aria-expanded="false">
                            <i class="fa fa-shopping-cart fa-fw"></i> Στατιστικά Πωλήσεων <span class="fa arrow"></span>
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
                        <a href="#" data-toggle="collapse" data-target="#store-stats" aria-expanded="false">
                            <i class="fa fa-building fa-fw"></i> Στατιστικά Καταστημάτων <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-third-level collapse" id="store-stats">
                            <?php
                            $CI->load->model('admin/selling_point');
                            $selling_points = $CI->selling_point->get_all('id, city');
                            foreach ($selling_points as $sp): ?>
                                <li>
                                    <a href="<?= base_url('admin/dashboard/' . $sp['id']) ?>">
                                        <i class="fa fa-pie-chart fa-fw"></i> <?php echo $sp['city'] ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            <li>
                                <a href="<?= base_url('admin/dashboard/selling_point') ?>">
                                    <i class="fa fa-bar-chart fa-fw"></i> Συνολικά Στατιστικά
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="<?= base_url('admin/service_tickets/service_stats/1') ?>"><i class="fa fa-wrench fa-fw"></i> Στατιστικά Επισκευών</a></li>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Διαχείριση Συστήματος -->
            <?php if (in_array($group_id, [1, 4, 5])): ?>
            <li>
                <a href="#" data-toggle="collapse" data-target="#management-menu" aria-expanded="false">
                    <i class="fa fa-cogs fa-fw"></i> Διαχείριση <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" id="management-menu">
                    <li><a href="<?= base_url('admin/vendors') ?>"><i class="fa fa-briefcase fa-fw"></i> Προμηθευτές</a></li>
                    <li><a href="<?= base_url('admin/manufacturers') ?>"><i class="fa fa-headphones fa-fw"></i> Κατασκευαστές</a></li>
                    <?php if ($group_id == 1): // Admin only ?>
                    <li><a href="<?= base_url('admin/companies') ?>"><i class="fa fa-building fa-fw"></i> Προφίλ Επιχείρησης</a></li>
                    <li><a href="<?= base_url('admin/selling_points') ?>"><i class="fa fa-map-marker fa-fw"></i> Καταστήματα</a></li>
                    <li><a href="<?= base_url('admin/banks') ?>"><i class="fa fa-bank fa-fw"></i> Τραπεζικοί Λογαριασμοί</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Έντυπα & Έγγραφα -->
            <li>
                <a href="#" data-toggle="collapse" data-target="#documents-menu" aria-expanded="false">
                    <i class="fa fa-file-text fa-fw"></i> Έντυπα <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" id="documents-menu">
                    <?php if ($group_id == 1): // Admin only ?>
                    <li><a href="<?= base_url('admin/vendors/view_all_ekapty') ?>"><i class="fa fa-file-archive-o fa-fw"></i> ΕΚΑΠΤΥ</a></li>
                    <li><a href="<?= base_url('admin/banks/view') ?>"><i class="fa fa-bank fa-fw"></i> Τραπεζικοί Λογαριασμοί</a></li>
                    <?php endif; ?>
                    <li><a href="<?= base_url('assets/uploads/files/documents/first_user.pdf') ?>" target="_blank"><i class="fa fa-user fa-fw"></i> Πρώτη Εφαρμογή</a></li>
                    <li><a href="<?= base_url('assets/uploads/files/documents/perifereia_students.pdf') ?>" target="_blank"><i class="fa fa-briefcase fa-fw"></i> Δικαιολογητικά Περιφέρειας</a></li>
                    <li><a href="<?= base_url('assets/uploads/files/documents/battery_consumption.pdf') ?>" target="_blank"><i class="fa fa-check-circle fa-fw"></i> Φόρμα Κατανάλωσης Μπαταρίας</a></li>
                </ul>
            </li>

            <!-- Ρυθμίσεις -->
            <?php if ($group_id == 1): // Admin only ?>
            <li>
                <a href="#" data-toggle="collapse" data-target="#settings-menu" aria-expanded="false">
                    <i class="fa fa-gears fa-fw"></i> Ρυθμίσεις <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" id="settings-menu">
                    <li><a href="<?= base_url('admin/services/notification_settings') ?>"><i class="fa fa-bell fa-fw"></i> Ρυθμίσεις Ειδοποιήσεων</a></li>
                    <li><a href="<?= base_url('admin/users') ?>"><i class="fa fa-users fa-fw"></i> Διαχείριση Χρηστών</a></li>
                    <li><a href="<?= base_url('admin/usergroups') ?>"><i class="fa fa-group fa-fw"></i> Ομάδες Χρηστών</a></li>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Γρήγορες Ενέργειες -->
            <li>
                <a href="#" data-toggle="collapse" data-target="#quick-actions" aria-expanded="false">
                    <i class="fa fa-bolt fa-fw"></i> Γρήγορες Ενέργειες <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse" id="quick-actions">
                    <?php if (in_array($group_id, [1, 4, 5])): ?>
                    <li><a href="<?= base_url('admin/customers/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέος Πελάτης</a></li>
                    <li><a href="<?= base_url('admin/stocks/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέο Ακουστικό</a></li>
                    <li><a href="<?= base_url('admin/services/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέα Επισκευή</a></li>
                    <li><a href="<?= base_url('admin/earlabs/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέα Κατασκευή</a></li>
                    <?php endif; ?>
                    <li><a href="<?= base_url('admin/tasks/create') ?>"><i class="fa fa-plus fa-fw"></i> Νέα Εργασία</a></li>
                    
                    <!-- Quick Stats for current selling point -->
                    <?php if ($sp_id && $sp_id !== 'selling_point'): ?>
                    <li class="divider"></li>
                    <li class="nav-header">Γρήγορα Στατιστικά</li>
                    <li><a href="<?= base_url('admin/stocks/view_barcodes_pending/' . $sp_id . '/' . date('Y')) ?>"><i class="fa fa-barcode fa-fw"></i> Εκκρεμή Barcodes</a></li>
                    <?php endif; ?>
                </ul>
            </li>

        </ul>
    </div>
</div>
