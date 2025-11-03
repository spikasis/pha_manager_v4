        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-deaf"></i>
                </div>
                <div class="sidebar-brand-text mx-3">PHA Manager <sup>v4</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Customers -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomers"
                    aria-expanded="true" aria-controls="collapseCustomers">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Πελάτες</span>
                </a>
                <div id="collapseCustomers" class="collapse" aria-labelledby="headingCustomers" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Διαχείριση Πελατών:</h6>
                        <a class="collapse-item" href="<?= base_url('customers') ?>">Όλοι οι Πελάτες</a>
                        <a class="collapse-item" href="<?= base_url('customers/create') ?>">Νέος Πελάτης</a>
                        <a class="collapse-item" href="<?= base_url('customers/search') ?>">Αναζήτηση</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Services -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseServices"
                    aria-expanded="true" aria-controls="collapseServices">
                    <i class="fas fa-fw fa-tools"></i>
                    <span>Υπηρεσίες</span>
                </a>
                <div id="collapseServices" class="collapse" aria-labelledby="headingServices" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Service Tickets:</h6>
                        <a class="collapse-item" href="#">Ενεργές Υπηρεσίες</a>
                        <a class="collapse-item" href="#">Νέο Service</a>
                        <a class="collapse-item" href="#">Ιστορικό</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Διαχείριση
            </div>

            <!-- Nav Item - Doctors -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-user-md"></i>
                    <span>Γιατροί</span></a>
            </li>

            <!-- Nav Item - Stock -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-boxes"></i>
                    <span>Αποθήκη</span></a>
            </li>

            <!-- Nav Item - Reports -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Αναφορές</span></a>
            </li>

            <!-- Admin Section (visible only to admins) -->
            <?php if (session()->get('user_group') === 'admin'): ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Διαχείριση Συστήματος
            </div>

            <!-- Nav Item - Users -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin"
                    aria-expanded="true" aria-controls="collapseAdmin">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Χρήστες & Ρόλοι</span>
                </a>
                <div id="collapseAdmin" class="collapse" aria-labelledby="headingAdmin" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Διαχείριση:</h6>
                        <a class="collapse-item" href="<?= base_url('admin/users') ?>">Χρήστες</a>
                        <a class="collapse-item" href="<?= base_url('admin/groups') ?>">Ρόλοι</a>
                        <a class="collapse-item" href="<?= base_url('admin/settings') ?>">Ρυθμίσεις</a>
                    </div>
                </div>
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
