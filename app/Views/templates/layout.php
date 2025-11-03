<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="PHA Manager v4 - Σύστημα Διαχείρισης Ακουστικών Βαρηκοΐας">
    <meta name="author" content="PHA Manager">

    <title><?= isset($title) ? esc($title) : 'PHA Manager v4' ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- SB Admin 2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet" integrity="sha512-D4EvMhb8Q1SbzC6h4EaQlKcg8FC7hhP7R4CHLWBjkDh1FjsOgRE8XhyL0qxSmE5STMqhhzjJZ+z5LnMeBw0Ng==" crossorigin="anonymous">

    <!-- Custom CSS -->
    <style>
        /* Sidebar customization */
        .sidebar {
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
        }
        
        .sidebar-brand-icon {
            font-size: 2rem;
            color: #fff !important;
        }
        
        .sidebar .nav-item .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .sidebar .nav-item .nav-link:hover {
            color: #fff !important;
        }
        
        /* Topbar */
        .topbar {
            height: 4.375rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
        }
        
        .navbar-nav .nav-item .nav-link {
            color: #858796 !important;
        }
        
        /* Cards */
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
            border: 1px solid #e3e6f0 !important;
        }
        
        .card-header {
            background-color: #f8f9fc !important;
            border-bottom: 1px solid #e3e6f0 !important;
        }
        
        /* Buttons */
        .btn-primary {
            background-color: #4e73df !important;
            border-color: #4e73df !important;
        }
        
        .btn-icon-split .icon {
            padding: 0.375rem 0.75rem;
            background-color: rgba(0, 0, 0, 0.15) !important;
        }
        
        /* Alerts */
        .alert {
            border: none !important;
            border-radius: 0.35rem !important;
        }
        
        /* Tables */
        .table td {
            vertical-align: middle !important;
        }
        
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #e3e6f0 !important;
        }
        
        /* Profile images */
        .img-profile {
            width: 2rem !important;
            height: 2rem !important;
        }
        
        /* Badges */
        .badge {
            font-size: 0.75em !important;
        }
        
        /* Greek fonts support */
        body, .sidebar .nav-item .nav-link, .topbar .navbar-nav .nav-item .nav-link {
            font-family: 'Nunito', 'Arial', sans-serif !important;
        }
        
        /* Authentication forms */
        .auth-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .auth-card {
            border: 0 !important;
            border-radius: 1rem !important;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
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
        
        /* DataTables customization */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 1rem !important;
        }
        
        /* Scroll to top button */
        .scroll-to-top {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            display: none;
            width: 2.75rem;
            height: 2.75rem;
            text-align: center;
            color: #fff;
            background: rgba(90, 92, 105, 0.5);
            line-height: 46px;
            border-radius: 100% !important;
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- jQuery Easing -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g0bUfdm2LfbLp3QqqrqJzoA2lltSyx9eidR3BZ9JmN1Lm/98dGcD2JL9BFe2SxZAAiz+r5rTQ2Q==" crossorigin="anonymous"></script>

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <!-- SB Admin 2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js" integrity="sha512-+QnjQxxaOpoJ+AAeNgvVatHiUWEDbvHja9l46BHhmzvP0blLTXC4QaQDkZKf+/F2XK6VZTWpd2c9OhmvMfwjKQ==" crossorigin="anonymous"></script>

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