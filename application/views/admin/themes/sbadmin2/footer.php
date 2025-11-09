            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; <?= date('Y') ?> Pikasis Hearing Aid Centers. 
                        Powered by <a href="#" class="text-primary">PHA Manager v4</a> | 
                        <?php if ($this->ion_auth->logged_in()): ?>
                            Χρήστης: <?= $this->ion_auth->user()->row()->username ?>
                        <?php endif; ?>
                        </span>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Είστε σίγουροι ότι θέλετε να αποσυνδεθείτε;</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Επιλέξτε "Αποσύνδεση" παρακάτω εάν είστε έτοιμοι να τερματίσετε την τρέχουσα συνεδρία σας.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Άκυρο</button>
                    <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Αποσύνδεση</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/sbadmin2/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/sbadmin2/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/sbladmin2/js/sb-admin-2.min.js') ?>"></script>
    
    <!-- Stock Management Functions -->
    <script src="<?= base_url('assets/admin/js/stock-functions.js') ?>"></script>

    <?php if (isset($page_scripts) && !empty($page_scripts)): ?>
        <?php foreach ($page_scripts as $script): ?>
            <script src="<?= base_url($script) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($custom_js) && !empty($custom_js)): ?>
        <script>
        <?= $custom_js ?>
        </script>
    <?php endif; ?>

    <!-- Customer Menu JavaScript Functions -->
    <script>
    function selectYearSelling(type) {
        var year = prompt('Εισάγετε έτος (π.χ. 2025):');
        var selling_point = prompt('Εισάγετε ID υποκαταστήματος:');
        
        if (year && selling_point) {
            if (type === 'interested') {
                window.location.href = '<?= base_url("admin/customers/get_interested_list/") ?>' + year + '/' + selling_point;
            }
        }
    }
    
    function selectSelling(type) {
        var selling_point = prompt('Εισάγετε ID υποκαταστήματος:');
        
        if (selling_point) {
            if (type === 'onhold') {
                window.location.href = '<?= base_url("admin/customers/get_onhold/") ?>' + selling_point;
            }
        }
    }
    
    function selectDoctorReport() {
        var doctor = prompt('Εισάγετε ID γιατρού:');
        var year = prompt('Εισάγετε έτος (π.χ. 2025):');
        
        if (doctor && year) {
            window.location.href = '<?= base_url("admin/customers/view_doctors_customers/") ?>' + doctor + '/' + year;
        }
    }
    </script>

</body>

</html>