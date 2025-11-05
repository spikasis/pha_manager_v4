<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?? 'PHA Manager v4' ?></title>

    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <!-- SB Admin 2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }

        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--light-color);
        }

        .sidebar {
            background: linear-gradient(180deg, var(--primary-color) 10%, #224abe 100%);
            min-height: 100vh;
        }

        .sidebar .nav-item .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
        }

        .sidebar .nav-item .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-item .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .sidebar .collapse-inner {
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .sidebar .collapse-item {
            padding: 0.5rem 1rem;
            margin: 0.125rem 0;
            display: block;
            color: #3a3b45;
            text-decoration: none;
            border-radius: 0.35rem;
            white-space: nowrap;
        }

        .sidebar .collapse-item:hover {
            background-color: #eaecf4;
        }

        .sidebar .collapse-header {
            margin: 0;
            white-space: nowrap;
            color: #6e707e;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.075em;
            padding: 1.5rem 1rem 0.5rem;
        }

        .topbar {
            height: 4.375rem;
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
        }

        .topbar .navbar-brand {
            color: var(--primary-color);
            font-weight: 800;
            font-size: 1.25rem;
        }

        .dropdown-list {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .dropdown-list .dropdown-header {
            background-color: var(--primary-color);
            border: 1px solid var(--primary-color);
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
        }

        .icon-circle {
            height: 2.5rem;
            width: 2.5rem;
            border-radius: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content-wrapper {
            background-color: var(--light-color);
            min-height: calc(100vh - 4.375rem);
        }

        .page-header {
            background: linear-gradient(90deg, var(--primary-color) 0%, #36b9cc 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 15px 15px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
            color: var(--primary-color);
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), #36b9cc);
            border: none;
            border-radius: 25px;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #36b9cc, var(--primary-color));
            transform: translateY(-1px);
        }

        .stats-card {
            border-left: 5px solid var(--primary-color);
            transition: transform 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-2px);
        }

        .footer {
            background-color: #fff;
            border-top: 1px solid #e3e6f0;
            padding: 1rem 0;
            margin-top: 2rem;
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 0;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            color: rgba(255, 255, 255, 0.7);
        }

        .sidebar-brand {
            height: 4.375rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            background-color: rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand:hover {
            color: #fff;
        }

        .nav-section-title {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            padding: 1rem 1rem 0.5rem 1rem;
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                width: 250px;
                height: 100vh;
                z-index: 1050;
                transition: left 0.3s;
            }

            .sidebar.show {
                left: 0;
            }

            .content-wrapper {
                margin-left: 0;
            }
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-assistive-listening-systems"></i>
                </div>
                <div class="sidebar-brand-text mx-3">PHA Manager <sup>v4</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= (service('uri')->getSegment(1) == 'dashboard' || service('uri')->getSegment(1) == '') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="nav-section-title">ΒΑΣΙΚΑ ΔΕΔΟΜΕΝΑ</div>

            <!-- Nav Item - Customers -->
            <li class="nav-item <?= (service('uri')->getSegment(1) == 'customers') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('customers') ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Πελάτες</span>
                </a>
            </li>

            <!-- Nav Item - Doctors -->
            <li class="nav-item <?= (service('uri')->getSegment(1) == 'doctors') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('doctors') ?>">
                    <i class="fas fa-fw fa-user-md"></i>
                    <span>Γιατροί</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="nav-section-title">ΑΠΟΘΗΚΗ & ΠΩΛΗΣΕΙΣ</div>

            <!-- Nav Item - Stocks -->
            <li class="nav-item <?= (service('uri')->getSegment(1) == 'stocks') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('stocks') ?>">
                    <i class="fas fa-fw fa-boxes"></i>
                    <span>Αποθέματα</span>
                </a>
            </li>

            <!-- Nav Item - Low Stock Alert -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('stocks/low-stock') ?>">
                    <i class="fas fa-fw fa-exclamation-triangle text-warning"></i>
                    <span>Χαμηλά Αποθέματα</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="nav-section-title">ΑΝΑΦΟΡΑ ΠΙΝΑΚΕΣ</div>

            <!-- Nav Item - Insurances -->
            <li class="nav-item <?= (service('uri')->getSegment(1) == 'insurances') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('insurances') ?>">
                    <i class="fas fa-fw fa-shield-alt"></i>
                    <span>Ασφαλιστικά Ταμεία</span>
                </a>
            </li>

            <!-- Nav Item - Customer Statuses -->
            <li class="nav-item <?= (service('uri')->getSegment(1) == 'customer-statuses') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('customer-statuses') ?>">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Καταστάσεις Πελατών</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="nav-section-title">ΔΙΑΧΕΙΡΙΣΗ ΧΡΗΣΤΩΝ</div>

            <!-- Nav Item - Users -->
            <li class="nav-item <?= (service('uri')->getSegment(1) == 'users') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('users') ?>">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Χρήστες</span>
                </a>
            </li>

            <!-- Nav Item - Groups -->
            <li class="nav-item <?= (service('uri')->getSegment(1) == 'groups') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('groups') ?>">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Ομάδες</span>
                </a>
            </li>

            <!-- Nav Item - Login Attempts -->
            <li class="nav-item <?= (service('uri')->getSegment(1) == 'login-attempts') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('login-attempts') ?>">
                    <i class="fas fa-fw fa-shield-alt"></i>
                    <span>Προσπάθειες Σύνδεσης</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="nav-section-title">ΣΥΣΤΗΜΑ</div>

            <!-- Nav Item - Settings -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Ρυθμίσεις</span>
                </a>
                <div id="collapseSettings" class="collapse" data-bs-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Ρυθμίσεις Συστήματος:</h6>
                        <a class="collapse-item" href="<?= base_url('settings/general') ?>">Γενικές Ρυθμίσεις</a>
                        <a class="collapse-item" href="<?= base_url('settings/security') ?>">Ασφάλεια</a>
                        <a class="collapse-item" href="<?= base_url('settings/backup') ?>">Αντίγραφα Ασφαλείας</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ms-auto">

                        <!-- Nav Item - Alerts Dropdown (Optional) -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts (optional) -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Ειδοποιήσεις
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="<?= base_url('stocks/low-stock') ?>">
                                    <div class="me-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Αποθέματα</div>
                                        <span class="font-weight-bold">Χαμηλά αποθέματα προϊόντων</span>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="<?= base_url('notifications') ?>">Όλες οι Ειδοποιήσεις</a>
                            </div>
                        </li>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="me-2 d-none d-lg-inline text-gray-600 small">
                                    <?= session()->get('username') ?: 'Χρήστης' ?>
                                </span>
                                <i class="fas fa-user-circle fa-lg text-gray-400"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in">
                                <a class="dropdown-item" href="<?= base_url('profile') ?>">
                                    <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                                    Προφίλ
                                </a>
                                <a class="dropdown-item" href="<?= base_url('settings/account') ?>">
                                    <i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>
                                    Ρυθμίσεις Λογαριασμού
                                </a>
                                <a class="dropdown-item" href="<?= base_url('help') ?>">
                                    <i class="fas fa-question-circle fa-sm fa-fw me-2 text-gray-400"></i>
                                    Βοήθεια
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('logout') ?>">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
                                    Αποσύνδεση
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Header -->
                    <?php if (isset($page_title)): ?>
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                                        <?php if (isset($breadcrumbs)): ?>
                                            <?php foreach ($breadcrumbs as $crumb): ?>
                                                <li class="breadcrumb-item"><?= $crumb ?></li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ol>
                                </nav>
                                <h1 class="h2 mb-0"><?= $page_title ?></h1>
                                <?php if (isset($page_description)): ?>
                                    <p class="mb-0 opacity-75"><?= $page_description ?></p>
                                <?php endif; ?>
                            </div>
                            <?php if (isset($page_actions)): ?>
                            <div class="col-auto">
                                <?= $page_actions ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Flash Messages -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('warning')): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= session()->getFlashdata('warning') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('info')): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <?= session()->getFlashdata('info') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Main Content -->
                    <?= $this->renderSection('content') ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="footer bg-white">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; PHA Manager v4 <?= date('Y') ?></span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <span class="text-muted small">Professional Hearing Aid Management System</span>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Initialize DataTables with default options
            if (typeof window.initDataTable === 'function') {
                window.initDataTable();
            }

            // Sidebar toggle for mobile
            $('#sidebarToggleTop').click(function() {
                $('#accordionSidebar').toggleClass('show');
            });

            // Close sidebar when clicking outside on mobile
            $(document).click(function(e) {
                if (!$(e.target).closest('#accordionSidebar, #sidebarToggleTop').length) {
                    $('#accordionSidebar').removeClass('show');
                }
            });

            // Improve dropdown functionality
            $('.dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                var dropdownMenu = $(this).next('.dropdown-menu');
                dropdownMenu.toggleClass('show');
            });

            // Close dropdowns when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').removeClass('show');
                }
            });

            // Sidebar collapse functionality
            $('.nav-link[data-bs-toggle="collapse"]').on('click', function(e) {
                e.preventDefault();
                var target = $($(this).attr('data-bs-target'));
                target.toggleClass('show');
                
                // Close other open collapses
                $('.collapse.show').not(target).removeClass('show');
            });

            // Add active class to current menu item
            var currentPath = window.location.pathname;
            $('.sidebar .nav-link').each(function() {
                var linkPath = $(this).attr('href');
                if (linkPath && currentPath.includes(linkPath.replace(window.location.origin, ''))) {
                    $(this).closest('.nav-item').addClass('active');
                }
            });

            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                }
            });
        });
    </script>

    <?= $this->renderSection('scripts') ?>

</body>

</html>