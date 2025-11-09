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
    <script src="<?= base_url('assets/sbadmin2/js/sb-admin-2.min.js') ?>"></script>
    
    <!-- DataTables JavaScript -->
    <script src="<?= base_url('assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
    
    <!-- SweetAlert2 for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
    
    function selectBranchDemo() {
        <?php 
        $CI =& get_instance();
        $user_id = $CI->ion_auth->get_user_id();
        $group = $CI->ion_auth->get_users_groups($user_id)->row();
        $user_selling_point = $group->id;
        ?>
        
        // Αυτόματη ανάκτηση του selling_point του χρήστη
        var user_selling_point = <?= $user_selling_point ?>;
        
        // Αν ο χρήστης είναι admin (group_id = 1), δώσε επιλογές
        <?php if ($group->id == 1): ?>
        var selling_point = prompt('Εισάγετε ID υποκαταστήματος:\n1 = Κεντρικό (Αθήνα)\n2 = Λιβαδειά\n3 = Θήβα\n\nΕισάγετε αριθμό:');
        
        if (selling_point && selling_point >= 1 && selling_point <= 3) {
            window.location.href = '<?= base_url("admin/stocks/get_demo/") ?>' + selling_point;
        } else if (selling_point) {
            alert('Μη έγκυρο υποκατάστημα. Παρακαλώ εισάγετε 1, 2 ή 3.');
        }
        <?php else: ?>
        // Για υποκαταστήματα, χρησιμοποίησε το δικό τους selling_point
        window.location.href = '<?= base_url("admin/stocks/get_demo/") ?>' + user_selling_point;
        <?php endif; ?>
    }
    
    function selectBranchDebt() {
        <?php 
        $CI =& get_instance();
        $user_id = $CI->ion_auth->get_user_id();
        $group = $CI->ion_auth->get_users_groups($user_id)->row();
        ?>
        
        // Αν ο χρήστης είναι admin (group_id = 1), δώσε επιλογές για όλα τα υποκαταστήματα
        <?php if ($group->id == 1): ?>
        var choice = prompt('Επιλέξτε:\n0 = Όλα τα χρέη (γενικά)\n1 = Κεντρικό (Αθήνα)\n2 = Λιβαδειά\n4 = Θήβα\n\nΕισάγετε αριθμό:');
        
        if (choice === '0') {
            // Γενικά χρέη - όλα τα υποκαταστήματα
            window.location.href = '<?= base_url("admin/stocks/on_debt") ?>';
        } else if (choice && (choice == '1' || choice == '2' || choice == '4')) {
            // Συγκεκριμένο υποκατάστημα
            window.location.href = '<?= base_url("admin/stocks/on_debt/") ?>' + choice;
        } else if (choice) {
            alert('Μη έγκυρη επιλογή. Παρακαλώ εισάγετε 0, 1, 2 ή 4.');
        }
        <?php else: ?>
        // Για υποκαταστήματα, εμφάνισε μόνο τα δικά τους χρέη
        window.location.href = '<?= base_url("admin/stocks/get_branch_debt") ?>';
        <?php endif; ?>
    }
    
    function selectBranchYearSales() {
        <?php 
        $CI =& get_instance();
        $user_id = $CI->ion_auth->get_user_id();
        $group = $CI->ion_auth->get_users_groups($user_id)->row();
        ?>
        
        var year = prompt('Εισάγετε έτος (π.χ. 2025):');
        
        if (year && year >= 2020 && year <= 2030) {
            // Αν ο χρήστης είναι admin, δώσε επιλογές υποκαταστήματος
            <?php if ($group->id == 1): ?>
            var selling_point = prompt('Επιλέξτε υποκατάστημα:\n2 = Λιβαδειά\n4 = Θήβα\n\nΕισάγετε αριθμό:');
            
            if (selling_point && (selling_point == '2' || selling_point == '4')) {
                window.location.href = '<?= base_url("admin/stocks/get_sold_thisYear_sp/") ?>' + year + '/' + selling_point;
            } else if (selling_point) {
                alert('Μη έγκυρο υποκατάστημα. Παρακαλώ εισάγετε 2 ή 4.');
            }
            <?php else: ?>
            // Για υποκαταστήματα, χρησιμοποίησε αυτόματα το δικό τους selling_point
            window.location.href = '<?= base_url("admin/stocks/get_branch_sales_year/") ?>' + year;
            <?php endif; ?>
        } else if (year) {
            alert('Μη έγκυρο έτος. Παρακαλώ εισάγετε έτος μεταξύ 2020-2030.');
        }
    }
    </script>

</body>

</html>