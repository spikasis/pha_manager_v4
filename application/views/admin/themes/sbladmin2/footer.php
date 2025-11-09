            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Pikasis Hearing CRM 2025</span>
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
                <div class="modal-body">Επιλέξτε "Αποσύνδεση" παρακάτω εάν είστε έτοιμοι να τερματίσετε την τρέχουσα συνεδρία.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Άκυρο</button>
                    <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Αποσύνδεση</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>assets/sbladmin2/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/sbladmin2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>assets/sbladmin2/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>assets/sbladmin2/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url() ?>assets/sbladmin2/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/sbladmin2/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url() ?>assets/sbladmin2/js/demo/datatables-demo.js"></script>

    <!-- Custom JavaScript -->
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('#dataTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Greek.json'
                }
            });
            
            // Initialize search functionality
            initializeSearch();
        });

        // Hide/Show function for dashboard panels
        function hideFunction(id) {
            var element = document.getElementById(id);
            if (element.style.display === "none") {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        }

        // Search functionality
        function initializeSearch() {
            let searchTimeout;
            const searchInput = $('#topbar-search-input');
            const searchDropdown = $('#search-dropdown');
            const resultsContainer = $('#search-results-container');
            const viewAllLink = $('#view-all-results');

            if (searchInput.length === 0) return; // Exit if search input doesn't exist

            searchInput.on('input', function() {
                const query = $(this).val().trim();
                
                clearTimeout(searchTimeout);
                
                if (query.length < 2) {
                    searchDropdown.hide();
                    return;
                }

                searchTimeout = setTimeout(function() {
                    performSearch(query);
                }, 300); // Debounce for 300ms
            });

            // Hide dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.navbar-search').length) {
                    searchDropdown.hide();
                }
            });

            // Update "View all results" link
            searchInput.on('input', function() {
                const query = $(this).val().trim();
                viewAllLink.attr('href', '<?= base_url("admin/search") ?>?q=' + encodeURIComponent(query));
            });

            function performSearch(query) {
                $.ajax({
                    url: '<?= base_url("admin/search/ajax_search") ?>',
                    type: 'POST',
                    data: { query: query },
                    dataType: 'json',
                    beforeSend: function() {
                        resultsContainer.html('<div class="dropdown-item"><i class="fas fa-spinner fa-spin"></i> Αναζήτηση...</div>');
                        searchDropdown.show();
                    },
                    success: function(response) {
                        if (response.success) {
                            displaySearchResults(response);
                        } else {
                            resultsContainer.html('<div class="dropdown-item text-danger">' + response.message + '</div>');
                        }
                    },
                    error: function() {
                        resultsContainer.html('<div class="dropdown-item text-danger">Σφάλμα κατά την αναζήτηση</div>');
                    }
                });
            }

            function displaySearchResults(data) {
                let html = '';
                
                if (data.total_count === 0) {
                    html = '<div class="dropdown-item text-muted">Δεν βρέθηκαν αποτελέσματα</div>';
                } else {
                    // Display customers
                    if (data.customers && data.customers.length > 0) {
                        html += '<h6 class="dropdown-header"><i class="fas fa-users text-primary"></i> Πελάτες</h6>';
                        data.customers.forEach(function(customer) {
                            html += '<a class="dropdown-item" href="' + customer.view_url + '">';
                            html += '<div class="font-weight-bold">' + customer.name + '</div>';
                            html += '<small class="text-muted">' + customer.city + ' • ' + customer.phone_home + '</small>';
                            html += '</a>';
                        });
                    }
                    
                    // Display stocks
                    if (data.stocks && data.stocks.length > 0) {
                        if (data.customers && data.customers.length > 0) {
                            html += '<div class="dropdown-divider"></div>';
                        }
                        html += '<h6 class="dropdown-header"><i class="fas fa-box text-success"></i> Ακουστικά</h6>';
                        data.stocks.forEach(function(stock) {
                            html += '<a class="dropdown-item" href="' + stock.view_url + '">';
                            html += '<div class="font-weight-bold">Serial: ' + stock.serial + '</div>';
                            html += '<small class="text-muted">' + stock.customer_name + '</small>';
                            html += '</a>';
                        });
                    }
                }
                
                resultsContainer.html(html);
                searchDropdown.show();
            }
        }
        
        // Demo management functions
        function selectBranchDemo() {
            <?php 
            $CI =& get_instance();
            $user_id = $CI->ion_auth->get_user_id();
            $groups = $CI->ion_auth->get_users_groups($user_id)->result();
            $user_selling_point = isset($groups[0]) ? $groups[0]->id : 1;
            $is_admin = $CI->ion_auth->is_admin();
            ?>
            
            // Αυτόματη ανάκτηση του selling_point του χρήστη
            var user_selling_point = <?= $user_selling_point ?>;
            
            // Αν ο χρήστης είναι admin, δώσε επιλογές
            <?php if ($is_admin): ?>
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
    </script>

</body>
</html>