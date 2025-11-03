<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="PHA Manager v4 - Σύστημα Διαχείρισης Ακουστικών Βαρηκοΐας">
    <meta name="author" content="PHA Manager">

    <title><?= isset($title) ? esc($title) : 'PHA Manager v4' ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('public/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('public/sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="<?= base_url('public/vendor/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        .sidebar-brand-icon {
            font-size: 2rem;
        }
        
        .navbar-nav .nav-item .nav-link {
            color: #858796;
        }
        
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }
        
        .btn-icon-split .icon {
            padding: 0.375rem 0.75rem;
        }
        
        .alert {
            border: none;
            border-radius: 0.35rem;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        .img-profile {
            width: 2rem;
            height: 2rem;
        }
        
        .badge {
            font-size: 0.75em;
        }
        
        /* Greek fonts support */
        body, .sidebar .nav-item .nav-link, .topbar .navbar-nav .nav-item .nav-link {
            font-family: 'Nunito', 'Arial', sans-serif;
        }
        
        /* Authentication forms */
        .auth-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .auth-card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .auth-card .card-body {
            padding: 2rem;
        }
        
        .form-control-user {
            font-size: 0.8rem;
            border-radius: 10rem;
            padding: 1.5rem 1rem;
        }
        
        .btn-user {
            font-size: 0.8rem;
            border-radius: 10rem;
            padding: 0.75rem 1rem;
        }
        
        /* Loading spinner */
        .loading-spinner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: none;
        }
        
        .loading-spinner .spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>

    <?= $this->renderSection('head') ?>
</head>

<body id="page-top">

    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loading-spinner">
        <div class="spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Φορτώνει...</span>
            </div>
        </div>
    </div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php if (is_logged_in()): ?>
            <!-- Sidebar -->
            <?= $this->include('templates/sidebar') ?>

            <!-- Content Wrapper -->
            <?= $this->include('templates/topbar') ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <?= $this->renderSection('content') ?>
            </div>
            <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?= $this->include('templates/footer') ?>

            </div>
            <!-- End of Content Wrapper -->

        <?php else: ?>
            <!-- Authentication Layout -->
            <?= $this->renderSection('content') ?>
        <?php endif; ?>

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('public/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('public/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('public/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('public/sbadmin2/js/sb-admin-2.min.js') ?>"></script>

    <!-- DataTables JavaScript-->
    <script src="<?= base_url('public/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('public/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>

    <!-- Chart.js -->
    <script src="<?= base_url('public/vendor/chart.js/Chart.min.js') ?>"></script>

    <!-- Global JavaScript -->
    <script>
        $(document).ready(function() {
            // Show loading spinner on form submit
            $('form').on('submit', function() {
                $('#loading-spinner').show();
            });

            // Hide loading spinner on page load
            $(window).on('load', function() {
                $('#loading-spinner').hide();
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Confirm delete actions
            $('.btn-delete').on('click', function(e) {
                if (!confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτό το στοιχείο;')) {
                    e.preventDefault();
                }
            });

            // CSRF token for AJAX requests
            $.ajaxSetup({
                beforeSend: function(xhr, settings) {
                    if (!/^(GET|HEAD|OPTIONS|TRACE)$/i.test(settings.type) && !this.crossDomain) {
                        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                    }
                }
            });
        });

        // Greek DataTables translation
        if (typeof $.fn.DataTable !== 'undefined') {
            $.extend(true, $.fn.dataTable.defaults, {
                "language": {
                    "sEmptyTable": "Δεν υπάρχουν δεδομένα στον πίνακα",
                    "sInfo": "Εμφανίζονται _START_ έως _END_ από _TOTAL_ εγγραφές",
                    "sInfoEmpty": "Εμφανίζονται 0 έως 0 από 0 εγγραφές",
                    "sInfoFiltered": "(φιλτραρισμένες από _MAX_ συνολικές εγγραφές)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "Δείξε _MENU_ εγγραφές",
                    "sLoadingRecords": "Φορτώνει...",
                    "sProcessing": "Επεξεργάζεται...",
                    "sSearch": "Αναζήτηση:",
                    "sSearchPlaceholder": "Αναζήτηση εγγραφών",
                    "sThousands": ".",
                    "sUrl": "",
                    "sZeroRecords": "Δε βρέθηκαν εγγραφές που να ταιριάζουν",
                    "oPaginate": {
                        "sFirst": "Πρώτη",
                        "sLast": "Τελευταία",
                        "sNext": "Επόμενη",
                        "sPrevious": "Προηγούμενη"
                    },
                    "oAria": {
                        "sSortAscending": ": ενεργοποιήστε για αύξουσα ταξινόμηση της στήλης",
                        "sSortDescending": ": ενεργοποιήστε για φθίνουσα ταξινόμηση της στήλης"
                    }
                }
            });
        }
    </script>

    <?= $this->renderSection('scripts') ?>

</body>

</html>