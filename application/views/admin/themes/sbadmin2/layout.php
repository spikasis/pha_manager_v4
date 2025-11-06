<?php $this->load->view('admin/themes/sbadmin2/header', $data); ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php $this->load->view('admin/themes/sbadmin2/sidemenu', $data); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php $this->load->view('admin/themes/sbadmin2/topbar', $data); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?= $content ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<?php $this->load->view('admin/themes/sbadmin2/footer'); ?>