<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Pikasis Hearing CRM System - Διαχείριση Ακουστικών Βαρηκοΐας">
    <meta name="author" content="Pikasis Hearing">

    <title>Pikasis Hearing CRM V3.0 - <?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>assets/sbadmin2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>assets/sbadmin2/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="<?= base_url() ?>assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="<?= base_url() ?>assets/sbadmin2/vendor/chart.js/Chart.min.js"></script>

    <!-- Custom CSS for Greek Language Support -->
    <style>
        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
        }
        
        .sidebar-brand {
            font-weight: 800;
        }
        
        .card-header {
            font-weight: 600;
        }
        
        .btn {
            font-weight: 600;
        }
        
        /* Greek text improvements */
        .nav-link, .dropdown-item, .card-body {
            font-size: 0.9rem;
        }
        
        /* Custom colors for hearing aid business */
        .bg-primary-custom {
            background: linear-gradient(45deg, #4e73df, #224abe);
        }
        
        .text-primary-custom {
            color: #4e73df !important;
        }

        /* Print styles */
        @media print {
            .sidebar, .topbar, .footer, .hidden-print {
                display: none !important;
            }
            
            #content-wrapper {
                margin-left: 0 !important;
            }
            
            .container-fluid {
                padding: 0 !important;
            }
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php $this->load->view($this->config->item('ci_my_admin_template_dir_admin') . 'sidemenu'); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php $this->load->view($this->config->item('ci_my_admin_template_dir_admin') . 'topbar'); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">