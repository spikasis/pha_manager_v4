<?php
$CI =& get_instance();
$user_id = $CI->ion_auth->get_user_id();
$group = $CI->ion_auth->get_users_groups($user_id)->row();
$group_id = $group->id;
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin/dashboard') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-headphones"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Pikasis <sup>CRM</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Αρχική</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Διαχείριση
    </div>

    <?php if ($group_id == 1): // Admin ?>
    
    <!-- Nav Item - Customers (Admin - Full Access) -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'customers') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomers" aria-expanded="true" aria-controls="collapseCustomers">
            <i class="fas fa-fw fa-users"></i>
            <span>Πελάτες</span>
        </a>
        <div id="collapseCustomers" class="collapse <?= ($this->uri->segment(2) == 'customers') ? 'show' : '' ?>" aria-labelledby="headingCustomers" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Πελατολόγια:</h6>
                <a class="collapse-item <?= ($this->uri->segment(2) == 'customers' && $this->uri->segment(3) == '') ? 'active' : '' ?>" href="<?= base_url('admin/customers') ?>">Πλήρες Πελατολόγιο</a>
                <a class="collapse-item" href="<?= base_url('admin/customers/get_interested') ?>">Ενδιαφερόμενοι</a>
                <a class="collapse-item" href="<?= base_url('admin/customers/get_onhold_full') ?>">Σε Εκκρεμότητα</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Ειδικές Αναφορές:</h6>
                <a class="collapse-item" href="#" onclick="selectDoctorReport()">Περιστατικά Γιατρού</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Stock Management (Admin - Full Access) -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'stocks') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStocks" aria-expanded="true" aria-controls="collapseStocks">
            <i class="fas fa-fw fa-headphones"></i>
            <span>Ακουστικά</span>
        </a>
        <div id="collapseStocks" class="collapse <?= ($this->uri->segment(2) == 'stocks') ? 'show' : '' ?>" aria-labelledby="headingStocks" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Διαχείριση:</h6>
                <a class="collapse-item <?= ($this->uri->segment(2) == 'stocks' && $this->uri->segment(3) == '') ? 'active' : '' ?>" href="<?= base_url('admin/stocks') ?>">Πλήρος Κατάλογος</a>
                <a class="collapse-item <?= ($this->uri->segment(3) == 'create') ? 'active' : '' ?>" href="<?= base_url('admin/stocks/create') ?>">Νέο Ακουστικό</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Κατάσταση Αποθήκης:</h6>
                <a class="collapse-item" href="<?= base_url('admin/stocks/get_onstock') ?>">Διαθέσιμα</a>
                <a class="collapse-item" href="<?= base_url('admin/stocks/get_demo/5') ?>">Demo</a>
                <a class="collapse-item" href="<?= base_url('admin/stocks/get_returns') ?>">Επιστροφές</a>
                <a class="collapse-item" href="<?= base_url('admin/stocks/get_stockblack') ?>">Μαύρη Λίστα</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Οικονομικά:</h6>
                <a class="collapse-item" href="#" onclick="viewDebtItems()">Χρέη</a>
                <a class="collapse-item" href="#" onclick="selectStockOnDebt()">Χρέη ανά Έτος/Υποκατάστημα</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Ειδικές Αναφορές:</h6>
                <a class="collapse-item" href="#" onclick="selectYearSelling('stocks')">Πωλήσεις ανά Έτος</a>
                <a class="collapse-item" href="#" onclick="selectVendorYear()">Πωλήσεις Κατασκευαστή</a>
                <a class="collapse-item" href="#" onclick="selectBarcodePending()">Barcodes Εκκρεμείς</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Services -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'services') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseServices" aria-expanded="true" aria-controls="collapseServices">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Επισκευές</span>
        </a>
        <div id="collapseServices" class="collapse <?= ($this->uri->segment(2) == 'services') ? 'show' : '' ?>" aria-labelledby="headingServices" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Διαχείριση Επισκευών:</h6>
                <a class="collapse-item" href="<?= base_url('admin/services') ?>">Όλες οι Επισκευές</a>
                <a class="collapse-item" href="<?= base_url('admin/services/create') ?>">Νέα Επισκευή</a>
                <a class="collapse-item" href="<?= base_url('admin/services/list_open') ?>">Ανοιχτές</a>
                <a class="collapse-item" href="<?= base_url('admin/services/list_completed') ?>">Ολοκληρωμένες</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Laboratory -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'earlabs') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/earlabs') ?>">
            <i class="fas fa-fw fa-flask"></i>
            <span>Εργαστήριο</span>
        </a>
    </li>

    <!-- Nav Item - Financial -->
    <li class="nav-item <?= in_array($this->uri->segment(2), ['pays', 'eopyy_pays', 'financial']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFinancial" aria-expanded="true" aria-controls="collapseFinancial">
            <i class="fas fa-fw fa-euro-sign"></i>
            <span>Οικονομικά</span>
        </a>
        <div id="collapseFinancial" class="collapse <?= in_array($this->uri->segment(2), ['pays', 'eopyy_pays', 'financial']) ? 'show' : '' ?>" aria-labelledby="headingFinancial" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Διαχείριση:</h6>
                <a class="collapse-item" href="<?= base_url('admin/pays') ?>">Πληρωμές</a>
                <a class="collapse-item" href="<?= base_url('admin/eopyy_pays') ?>">ΕΟΠΥΥ</a>
                <a class="collapse-item" href="<?= base_url('admin/financial/reports') ?>">Αναφορές</a>
            </div>
        </div>
    </li>

    <?php elseif (in_array($group_id, [2, 4, 5])): // Υποκαταστήματα: member, Levadia, Thiva ?>
    
    <!-- Nav Item - Customers (Branch - Limited Access) -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'customers') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomersBranch" aria-expanded="true" aria-controls="collapseCustomersBranch">
            <i class="fas fa-fw fa-users"></i>
            <span>Πελάτες</span>
        </a>
        <div id="collapseCustomersBranch" class="collapse <?= ($this->uri->segment(2) == 'customers') ? 'show' : '' ?>" aria-labelledby="headingCustomersBranch" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Πελατολόγια:</h6>
                <a class="collapse-item <?= ($this->uri->segment(2) == 'customers' && $this->uri->segment(3) == '') ? 'active' : '' ?>" href="<?= base_url('admin/customers') ?>">Πλήρες Πελατολόγιο</a>
                <a class="collapse-item" href="<?= base_url('admin/customers/get_interested') ?>">Ενδιαφερόμενοι</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Ανά Υποκατάστημα:</h6>
                <a class="collapse-item" href="#" onclick="selectYearSelling('interested')">Ενδιαφερόμενοι ανά Έτος</a>
                <a class="collapse-item" href="#" onclick="selectSelling('onhold')">Σε Εκκρεμότητα</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Stocks (Branch - Limited Access) -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'stocks') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStocksBranch" aria-expanded="true" aria-controls="collapseStocksBranch">
            <i class="fas fa-fw fa-headphones"></i>
            <span>Ακουστικά</span>
        </a>
        <div id="collapseStocksBranch" class="collapse <?= ($this->uri->segment(2) == 'stocks') ? 'show' : '' ?>" aria-labelledby="headingStocksBranch" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Διαχείριση:</h6>
                <a class="collapse-item <?= ($this->uri->segment(2) == 'stocks' && $this->uri->segment(3) == '') ? 'active' : '' ?>" href="<?= base_url('admin/stocks') ?>">Πλήρος Κατάλογος</a>
                <a class="collapse-item <?= ($this->uri->segment(3) == 'create') ? 'active' : '' ?>" href="<?= base_url('admin/stocks/create') ?>">Νέο Ακουστικό</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Κατάσταση Αποθήκης:</h6>
                <a class="collapse-item" href="<?= base_url('admin/stocks/get_onstock') ?>">Διαθέσιμα</a>
                <a class="collapse-item" href="#" onclick="selectBranchDemo()">Demo Υποκαταστήματος</a>
                <a class="collapse-item" href="<?= base_url('admin/stocks/get_returns') ?>">Επιστροφές</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Οικονομικά:</h6>
                <a class="collapse-item" href="#" onclick="selectBranchDebt()">Χρέη Υποκαταστήματος</a>
                <a class="collapse-item" href="#" onclick="selectBranchYearSales()">Πωλήσεις ανά Έτος</a>
            </div>
        </div>
    </li>

    <?php elseif ($group_id == 6): // Service Group (Lab) ?>
    
    <!-- Nav Item - Customers (Lab - All Branches Access) -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'customers') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomersLab" aria-expanded="true" aria-controls="collapseCustomersLab">
            <i class="fas fa-fw fa-users"></i>
            <span>Πελάτες</span>
        </a>
        <div id="collapseCustomersLab" class="collapse <?= ($this->uri->segment(2) == 'customers') ? 'show' : '' ?>" aria-labelledby="headingCustomersLab" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Πελατολόγια:</h6>
                <a class="collapse-item <?= ($this->uri->segment(2) == 'customers' && $this->uri->segment(3) == '') ? 'active' : '' ?>" href="<?= base_url('admin/customers') ?>">Πλήρες Πελατολόγιο</a>
                <a class="collapse-item" href="<?= base_url('admin/customers/get_interested') ?>">Ενδιαφερόμενοι</a>
                <a class="collapse-item" href="<?= base_url('admin/customers/get_onhold_full') ?>">Σε Εκκρεμότητα</a>
            </div>
        </div>
    </li>
    
    <!-- Nav Item - Repairs (Lab) -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'services') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/services') ?>">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Επισκευές</span>
        </a>
    </li>

    <!-- Nav Item - Stocks (Lab - Service Access) -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'stocks') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStocksLab" aria-expanded="true" aria-controls="collapseStocksLab">
            <i class="fas fa-fw fa-headphones"></i>
            <span>Ακουστικά</span>
        </a>
        <div id="collapseStocksLab" class="collapse <?= ($this->uri->segment(2) == 'stocks') ? 'show' : '' ?>" aria-labelledby="headingStocksLab" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Διαχείριση:</h6>
                <a class="collapse-item <?= ($this->uri->segment(2) == 'stocks' && $this->uri->segment(3) == '') ? 'active' : '' ?>" href="<?= base_url('admin/stocks') ?>">Πλήρος Κατάλογος</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Κατάσταση Αποθήκης:</h6>
                <a class="collapse-item" href="<?= base_url('admin/stocks/get_onstock') ?>">Διαθέσιμα</a>
                <a class="collapse-item" href="<?= base_url('admin/stocks/get_returns') ?>">Επιστροφές</a>
                <a class="collapse-item" href="<?= base_url('admin/stocks/get_stockblack') ?>">Μαύρη Λίστα</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Tasks (Lab) -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'tasks') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/tasks') ?>">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Εργασίες</span>
        </a>
    </li>

    <?php elseif ($group_id == 3): // Other groups ?>
    
    <!-- Basic access for other groups -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'customers') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/customers') ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Πελάτες</span>
        </a>
    </li>

    <!-- Nav Item - Stocks (Other Groups - Basic Access) -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'stocks') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/stocks') ?>">
            <i class="fas fa-fw fa-headphones"></i>
            <span>Ακουστικά</span>
        </a>
    </li>

    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Αναφορές & Ρυθμίσεις
    </div>

    <!-- Nav Item - Reports -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'reports') ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseReports">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Αναφορές</span>
        </a>
        <div id="collapseReports" class="collapse" aria-labelledby="headingReports" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Στατιστικά:</h6>
                <a class="collapse-item" href="<?= base_url('admin/reports/sales') ?>">Πωλήσεις</a>
                <a class="collapse-item" href="<?= base_url('admin/reports/customers') ?>">Πελάτες</a>
                <a class="collapse-item" href="<?= base_url('admin/reports/financial') ?>">Οικονομικά</a>
            </div>
        </div>
    </li>

    <?php if ($group_id == 1): // Only Admin sees settings ?>
    <!-- Nav Item - Settings -->
    <li class="nav-item <?= ($this->uri->segment(2) == 'settings') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/settings') ?>">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Ρυθμίσεις</span>
        </a>
    </li>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->