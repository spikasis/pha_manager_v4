<?php
$CI =& get_instance();
$user_id = $CI->ion_auth->get_user_id();
$groups = $CI->ion_auth->get_users_groups($user_id)->result();
$group_id = isset($groups[0]) ? $groups[0]->id : 0;
$is_admin = $CI->ion_auth->is_admin();
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-headphones"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Pikasis <sup>CRM</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= (uri_string() == 'admin' || uri_string() == 'admin/dashboard' || uri_string() == 'admin/dashboard_sp') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url($is_admin ? 'admin' : 'admin/dashboard_sp') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Διαχείριση
    </div>

    <!-- Nav Item - Customers -->
    <li class="nav-item <?= strpos(uri_string(), 'customers') !== false ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/customers') ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Πελάτες</span>
        </a>
    </li>

    <!-- Nav Item - Stock -->
    <li class="nav-item <?= strpos(uri_string(), 'stock') !== false ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStock" aria-expanded="true" aria-controls="collapseStock">
            <i class="fas fa-fw fa-box"></i>
            <span>Ακουστικά</span>
        </a>
        <div id="collapseStock" class="collapse <?= strpos(uri_string(), 'stock') !== false ? 'show' : '' ?>" aria-labelledby="headingStock" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Διαχείριση:</h6>
                <a class="collapse-item <?= uri_string() == 'admin/stock' ? 'active' : '' ?>" href="<?= base_url('admin/stock') ?>">Λίστα Ακουστικών</a>
                <a class="collapse-item <?= uri_string() == 'admin/stock/create' ? 'active' : '' ?>" href="<?= base_url('admin/stock/create') ?>">Νέο Ακουστικό</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Demo Ακουστικά:</h6>
                <a class="collapse-item" href="<?= base_url('admin/stocks/get_demo') ?>">Demo Γενικά</a>
                <a class="collapse-item" href="#" onclick="selectBranchDemo()">Demo Υποκαταστήματος</a>
                <a class="collapse-item" href="<?= base_url('admin/stocks/manage_demo_types') ?>">Διαχείριση Demo Types</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Ειδικές Κατηγορίες:</h6>
                <a class="collapse-item" href="<?= base_url('admin/stock/list_demo') ?>">Demo Ακουστικά (Παλιό)</a>
                <a class="collapse-item" href="<?= base_url('admin/stock/list_debt') ?>">Χρέη</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Tasks -->
    <li class="nav-item <?= strpos(uri_string(), 'tasks') !== false ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/tasks') ?>">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Εργασίες</span>
        </a>
    </li>

    <!-- Nav Item - Services -->
    <li class="nav-item <?= strpos(uri_string(), 'services') !== false ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/services') ?>">
            <i class="fas fa-fw fa-tools"></i>
            <span>Επισκευές</span>
        </a>
    </li>

    <!-- Nav Item - Earlabs -->
    <li class="nav-item <?= strpos(uri_string(), 'earlabs') !== false ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/earlabs') ?>">
            <i class="fas fa-fw fa-flask"></i>
            <span>Κατασκευές</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Οικονομικά
    </div>

    <!-- Nav Item - Payments -->
    <li class="nav-item <?= strpos(uri_string(), 'pay') !== false ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/pay') ?>">
            <i class="fas fa-fw fa-euro-sign"></i>
            <span>Πληρωμές</span>
        </a>
    </li>

    <!-- Nav Item - Financial -->
    <li class="nav-item <?= uri_string() == 'admin/financial' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/financial') ?>">
            <i class="fas fa-fw fa-chart-line"></i>
            <span>Οικονομικά</span>
        </a>
    </li>

    <?php if ($is_admin): ?>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Διαχειριστής
    </div>

    <!-- Nav Item - Users -->
    <li class="nav-item <?= strpos(uri_string(), 'users') !== false ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/users') ?>">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Χρήστες</span>
        </a>
    </li>

    <!-- Nav Item - Settings -->
    <li class="nav-item <?= strpos(uri_string(), 'settings') !== false ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Ρυθμίσεις</span>
        </a>
        <div id="collapseSettings" class="collapse" aria-labelledby="headingSettings" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Διαμόρφωση:</h6>
                <a class="collapse-item" href="<?= base_url('admin/manufacturers') ?>">Κατασκευαστές</a>
                <a class="collapse-item" href="<?= base_url('admin/models') ?>">Μοντέλα</a>
                <a class="collapse-item" href="<?= base_url('admin/series') ?>">Σειρές</a>
                <a class="collapse-item" href="<?= base_url('admin/vendors') ?>">Προμηθευτές</a>
                <a class="collapse-item" href="<?= base_url('admin/selling_points') ?>">Υποκαταστήματα</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Reports -->
    <li class="nav-item <?= strpos(uri_string(), 'reports') !== false ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/reports') ?>">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Αναφορές</span>
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