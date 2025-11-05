    <!-- Bootstrap JS -->
    <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    
    <!-- jQuery Easing -->
    <script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    
    <!-- SB Admin 2 JS -->
    <script src="<?= base_url('sbadmin2/js/sb-admin-2.min.js') ?>"></script>
    
    <!-- DataTables JS (if needed) -->
    <?php if (isset($load_datatables) && $load_datatables): ?>
    <script src="<?= base_url('vendor/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
    <?php endif; ?>

    <!-- Chart.js (if needed) -->
    <?php if (isset($load_charts) && $load_charts): ?>
    <script src="<?= base_url('vendor/chart.js/Chart.min.js') ?>"></script>
    <?php endif; ?>

    <!-- Custom JS for this page -->
    <?php if (isset($custom_js)): ?>
        <?php foreach ($custom_js as $js): ?>
            <script src="<?= base_url($js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Inline Scripts (if provided) -->
    <?php if (isset($inline_scripts)): ?>
        <script><?= $inline_scripts ?></script>
    <?php endif; ?>
</body>
</html>